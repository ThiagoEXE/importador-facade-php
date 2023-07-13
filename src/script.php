<?php

require 'ImportadorFacade.php';
require 'Hapvida.php';
require 'Itau.php';
require 'PersisteDados.php';
//require 'DataBase.php';
$importador = new ImportadorFacade('Relatório_EMPRESA_A9846_REMESSA_3223780 (1).CSV');

$importador->importar('Relatório_EMPRESA_A9846_REMESSA_3223780 (1).CSV', 'hapvida');
//$importador->importar('itau.csv', 'itau');
//$importador->importar('hapvida.txt', 'outros');


