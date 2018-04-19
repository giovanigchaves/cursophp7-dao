<?php
    /**
     *
     * User: Giovani G. Chaves
     * Date: 18/04/2018
     * Time: 23:43
     */

    require_once("config.php");

$root = new Usuario();

$root->loadById(3);

echo $root;













