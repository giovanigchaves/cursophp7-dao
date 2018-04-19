<?php
    /**
     *
     * User: Giovani G. Chaves
     * Date: 18/04/2018
     * Time: 23:38
     */


    spl_autoload_register(function ($class_name){

        $filename = "Class". DIRECTORY_SEPARATOR .$class_name . ".php";

        if (file_exists(($filename))){
            require_once($filename);
        }

    });





































