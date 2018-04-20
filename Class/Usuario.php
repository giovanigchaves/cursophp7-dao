<?php

    /*
     * Classe responsavel por manipular tabela Usuario no banco de dados php7
     */

    class Usuario
    {

        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;

        /**
         * Usuario constructor.
         */
        public function __construct()
        {

        }

        /*
         * Obtem id_usuario
         */
        /**
         * @return mixed
         */
        public function getIdusuario()
        {
            return $this->idusuario;
        }

        /**
         * @param $value
         */
        public function setIdusuario($value)
        {
            $this->idusuario = $value;
        }

        /**
         * @return mixed
         */
        public function getDeslogin()
        {
            return $this->deslogin;
        }

        /**
         * @param $value
         */
        public function setDeslogin($value)
        {

            $this->deslogin = $value;
        }

        /**
         * @return mixed
         */
        public function getDessenha()
        {
            return $this->dessenha;
        }

        /**
         * @param $value
         */
        public function setDessenha($value)
        {
            $this->dessenha = $value;
        }

        /**
         * @return mixed
         */
        public function getDtcadastro()
        {
            return $this->dtcadastro;
        }

        /**
         * @param $value
         */
        public function setDtcadastro($value)
        {
            $this->dtcadastro = $value;
        }

        /**
         * @param $id
         */
        public function loadById($id)
        {

            $sql = new Sql();

            $results = $sql->select("SELECT * FROM tb_usuarios WHERE id_usuario = :ID", array(":ID" => $id));

//            var_dump($results);
            if(count($results) > 0)
            {

                $this->setData($results[0]);

            }
        }

        /**
         * @return array
         */
        public static function getList()
        {

            $sql = new Sql();

            return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

        }

        /**
         * @param $login
         *
         * @return array
         */
        public static function search($login)
        {

            $sql = new Sql();

            return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(':SEARCH' => "%" . $login . "%"));
        }

        /**
         * @param $login
         * @param $password
         *
         * @throws \Exception
         */
        public function login($login, $password)
        {

            $sql = new Sql();

            $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
                ":LOGIN" => $login, ":PASSWORD" => $password
            ));

            if(count($results) > 0)
            {

                $this->setData($results[0]);

            } else
            {
                throw new Exception("Login e/ou senha invalidos.");
            }

        }

        public function setData($data)
        {

            $this->setIdusuario($data['id_usuario']);
            $this->setDeslogin($data['deslogin']);
            $this->setDessenha($data['dessenha']);
            $this->setDtcadastro(new DateTime($data['dtcadastro']));

        }

        /**
         *
         */
        public function insert($login = "", $password = "")
        {
            $this->setDeslogin($login);
            $this->setDessenha($password);

            $sql = new Sql();

            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
                ':LOGIN' => $this->getDeslogin(), ':PASSWORD' => $this->getDessenha()
            ));

            if(count($results) > 0)
            {
                $this->setData($results[0]);
            }

        }

        public function update($login, $password)
        {

            $this->setDeslogin($login);
            $this->setDessenha($password);

            $sql = new Sql();

            $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE id_usuario = :ID", array(
                ':LOGIN' => $this->getDeslogin(), ':PASSWORD' => $this->getDessenha(), ':ID' => $this->getIdusuario()
            ));

        }

        public function delete($id = "")
        {

            $sql = new Sql();

            if(!$id)
            {

                $sql->query("DELETE FROM tb_usuarios WHERE id_usuario = :ID", array(
                    ':ID' => $this->getIdusuario()
                ));
            } else
            {
                $sql->query("DELETE FROM tb_usuarios WHERE id_usuario = :ID", array(
                    ':ID' => $id
                ));

            }
            $this->setIdusuario(NULL);
            $this->setDeslogin(NULL);
            $this->setDessenha(NULL);
            $this->setDtcadastro(new DateTime());

        }

        /**
         * @return string
         */
        public function __toString()
        {

            return json_encode(array(

                "id_usuario" => $this->getIdusuario(), "deslogin" => $this->getDeslogin(),
                "dessenha" => $this->getDessenha(), "dtcadastro" => $this->getDtcadastro()->format("d/m/Y H:i:s")

            ));
        }

    }
