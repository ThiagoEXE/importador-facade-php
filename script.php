<?php

require 'ImportadorFacade.php';
require 'Hapvida.php';
require 'Itau.php';
$importador = new ImportadorFacade();

$importador->importar('teste.CSV', 'hapvida');
//$importador->importar('itau.csv', 'itau');
//$importador->importar('hapvida.txt', 'outros');


