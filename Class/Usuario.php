<?php

/*
 * Classe responsavel por manipular tabela Usuario no banco de dados php7
 */
class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    /*
     * Obtem id_usuario
     */
    /**
     * @return mixed
     */
    public function getIdusuario() {
        return $this->idusuario;
    }

    /**
     * @param $value
     */
    public function setIdusuario($value) {
        $this->idusuario = $value;
    }

    /**
     * @return mixed
     */
    public function getDeslogin() {
        return $this->deslogin;
    }

    /**
     * @param $value
     */
    public function setDeslogin($value) {

        $this->deslogin = $value;
    }

    /**
     * @return mixed
     */
    public function getDessenha() {
        return $this->dessenha;
    }

    /**
     * @param $value
     */
    public function setDessenha($value) {
        $this->dessenha = $value;
    }

    /**
     * @return mixed
     */
    public function getDtcadastro() {
        return $this->dtcadastro;
    }

    /**
     * @param $value
     */
    public function setDtcadastro($value) {
        $this->dtcadastro = $value;
    }

    /**
     * @param $id
     */
    public function loadById($id){

        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE id_usuario = :ID",array(":ID"=>$id));
        
        if(count($results) > 0){
            
            $row = $results[0];
            
            $this->setIdusuario($row['id_usuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));
            
        }
    }

    /**
     * @return array
     */
    public static function getList(){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");


    }

    /**
     * @param $login
     *
     * @return array
     */
    public static function search($login){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin",array(':SEARCH'=>"%".$login."%"));
    }

    public function login($login, $password){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD",array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(count($results) > 0){

            $row = $results[0];

            $this->setIdusuario($row['id_usuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));

        }else{
            throw new Exception("Login e/ou senha invalidos.");
        }

    }


    /**
     * @return string
     */
    public function __toString(){
        
        return json_encode(array(
            
            "id_usuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
            
        ));
    }

    
}
