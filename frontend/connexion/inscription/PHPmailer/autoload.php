<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

//require 'autoload.php';

if(php_sapi_name() == "cli" && isset($_SERVER['argv'])) {
    $argv = $_SERVER['argv'];
    if(in_array('artisan', $argv) && in_array('clear-compiled', $argv)){
        $files = glob("./bootstrap/cache/*");
        foreach($files as $file) {
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        exit();
    }
}

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}