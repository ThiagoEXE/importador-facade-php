<?php

class DataBase
{

    private $conexao;

    public function load_config()
    {
        if (file_exists('config.dev')) {
            $array_config = parse_ini_file("config.dev", true);
        } else {
            $array_config = parse_ini_file("config.ini", true);
        }
        return $array_config;
    }

    public function conexaoBanco()
    {
        $config = $this->load_config();
        $host = $config['POSTGRESQL']['host'];
        $port = $config['POSTGRESQL']['port'];
        $user = $config['POSTGRESQL']['user'];
        $password = $config['POSTGRESQL']['password'];
        $dbname = $config['POSTGRESQL']['dbname'];

        try {
            $this->conexao = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


            return $this->conexao;
        } catch (PDOException $e) {
            die("Falha na conexão com o banco: " . $e->getMessage());
        }
    }
}
