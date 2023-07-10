<?php

class ImportadorFacade{
    private $hapvida;
    private $itau;
    private $persisteDados;
    private $conexao;

    public function __construct() {
        $this->itau = new Itau();
        $this->hapvida = new Hapvida();
        $this->persisteDados = new PersisteDados();
        $this->conexao = new DataBase();
    }

    function importar($arquivo, $tipo){
        if($tipo === 'hapvida'){
            $dadosLidos = $this->hapvida->importar($arquivo);
            $registros = $this->hapvida->validaArquivo($dadosLidos);
            $query = $this->hapvida->preparaQuery($registros);
            $conexao = $this->conexao->conexaoBanco();
            $this->persisteDados->insereDadosHapVida($conexao, $query);
            
            $this->hapvida->critica();
        }else if($tipo === 'itau'){
            $this->itau->importar($arquivo);
            $this->itau->critica();
            $this->itau->validaArquivo($arquivo);
        }else{
            echo "Tipo de importação inválido";
        }
    }
}