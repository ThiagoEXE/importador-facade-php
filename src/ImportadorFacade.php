<?php

class ImportadorFacade{
    private $obImportador;
    private $persisteDados;
    private $conexao;

    public function __construct() {
        //$this->itau = new Itau();
        $this->persisteDados = new PersisteDados();
        $this->conexao = new DataBase();
    }

    function importar($arquivo, $tipo){
        if($tipo === 'hapvida'){
            $this->obImportador = new Hapvida($arquivo);

            $hashArquivo = $this->obImportador->hash;
            
            $this->obImportador->importar();
            $registros = $this->obImportador->limparArquivo();
           // $query = $this->obImportador->preparaQuery($registros);
          //  $conexao = $this->conexao->conexaoBanco();
          //  $this->persisteDados->insereDadosHapVida($conexao, $query);
            
            $this->obImportador->critica();
        }else if($tipo === 'itau'){
            $this->obImportador = new Itau($arquivo);
            $this->obImportador->importar($arquivo);
           // $this->obImportador->critica();
            $this->obImportador->limparArquivo();
        }else{
            echo "Tipo de importação inválido";
        }
    }
}