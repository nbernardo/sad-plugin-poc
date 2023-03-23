<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use \PhpZip\ZipFile;

class PluginParser extends BaseController {

    public function upload(){

        $uploadFolder = storage_path('app/public');
        
        $file = $_FILES["myFile"]["tmp_name"];
        $name = $_FILES["myFile"]["name"];
        $resultFile = $uploadFolder."/".$name;
        $pluginFolderName = str_replace(".zip","",$name);
        $pluginPath = $uploadFolder."/".$pluginFolderName;

        try{

            if(is_dir($pluginPath)){
                print("Plugin já existente");
                return false;
            }
            
            //TODO: A implementação abaixo deverá ir para uma classe própria (ex: PluginDTO)
            if(move_uploaded_file($file, $resultFile)){
                $zipFile = new ZipFile();
                $metadata = "";
                mkdir($pluginPath,0777); //Criar o directorio do plugin
                $zipFile
                    ->openFile($resultFile)
                    ->extractTo($pluginPath);
                $pluginValues = [$pluginFolderName, $metadata, $pluginPath];
                //TODO: Acesso a BD deverá passar para o repositório (Data Access Layer)
                $save = DB::insert("INSERT INTO plugins (name,metadata,plugin) VALUES (?,?,?)", $pluginValues);
    
                if($save){
                    if(is_file($resultFile))
                        unlink($resultFile); //Exclui o pkg do plugin 
                    print("Plugins instalado com sucesso!");
                }
            }

        }catch(Exception $e){
            //TODO: As linhas de código abaixo está duplicada, deve-se criar um metodo ou class própria
            if(is_file($resultFile))
                unlink($resultFile); //Exclui o pkg do plugin
        }

    }

}