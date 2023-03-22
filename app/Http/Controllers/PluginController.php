<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class PluginController extends BaseController {

    static $existingPlugins = [];

    public static function pluginExists(String $name){
        //TODO: A linha de baixo deverá passar para o repositório
        $result = DB::select("SELECT * FROM plugins WHERE name = ?", [$name]);
        if(sizeof($result) === 1){
            self::$existingPlugins[$name] = $result[0]->plugin.'/index.html';
            return true;
        }
        return false;
    }

    public static function show(String $name){
        $pluginFile = self::$existingPlugins[$name];
        $fileSize = filesize($pluginFile);
        $openedPluginContent = fopen($pluginFile, "r");
        $content = fread($openedPluginContent, $fileSize);
        print($content);
    }

}