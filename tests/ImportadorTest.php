<?php

use JetBrains\PhpStorm\Immutable;
use PHPUnit\Framework\TestCase;

class ImportadorTest extends TestCase
{

    public function testDeveGerarHashDoArquivo()
    {
        // Arrange
        $reflectionClass = new ReflectionClass(Hapvida::class);
        $reflectionMethod = $reflectionClass->getMethod('gerarHashArquivo');
        $reflectionMethod->setAccessible(true);

        $importador = $reflectionClass->newInstanceWithoutConstructor();

        // Act
        $result = $reflectionMethod->invoke($importador, './src/teste.csv');
        $hashEsperado = 'f2a14f34fd47dfe595438d1d4fe12aa760b1a368ebb10b582b0b48c899c5eb85';

        // Assert
        $this->assertEquals($hashEsperado, $result);
    }
}
