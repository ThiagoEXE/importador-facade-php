<?php

require 'ImportadorFacade.php';
require 'Hapvida.php';
require 'Itau.php';
require 'PersisteDados.php';
//require 'DataBase.php';
$importador = new ImportadorFacade();

$importador->importar('teste.csv', 'hapvida');
//$importador->importar('itau.csv', 'itau');
//$importador->importar('hapvida.txt', 'outros');


