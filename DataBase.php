<?php

class DataBase
{

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
        echo "teste";
        $config = $this->load_config();
        $host = $config['POSTGRESQL']['host'];
        $port = $config['POSTGRESQL']['port'];
        $user = $config['POSTGRESQL']['user'];
        $password = $config['POSTGRESQL']['password'];
        $dbname = $config['POSTGRESQL']['dbname'];
        $keepalive_idle = 300;

        $conexao =  pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password keepalives_idle=$keepalive_idle");
        if($conexao){
            echo "conectou no banco";
        
          }else{
            echo "não conectou no banco";
          }
        return $conexao;
    }

    
}
