<?php
    /**
     *
     * User: Giovani G. Chaves
     * Date: 18/04/2018
     * Time: 23:43
     */

    require_once("config.php");


    $sql = new Sql();

    $usuarios = $sql->select("SELECT * FROM tb_usuarios");

    echo json_encode($usuarios);



















