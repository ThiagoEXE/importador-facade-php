<?php

class ImportadorFacade{
    private $hapvida;
    private $itau;

    public function __construct() {
        $this->itau = new Itau();
        $this->hapvida = new Hapvida();
    }

    function importar($arquivo, $tipo){
        if($tipo === 'hapvida'){
            $dadosLidos = $this->hapvida->importar($arquivo);
            $this->hapvida->validaArquivo($dadosLidos);
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