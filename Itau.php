<?php

class Itau extends Importador
{
    public function importar($arquivo){
    }
    public function critica()
    {
        echo "Realizando critica dos dados importados Itau<br>";
    }
    public function validaArquivo($arquivo)
    {
        echo "Validando arquivo do Itau: " . $arquivo . "<br>";
    }
}
