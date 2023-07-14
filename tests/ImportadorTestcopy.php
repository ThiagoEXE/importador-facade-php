<?php

use PHPUnit\Framework\TestCase;

class ImportadorTestcopy extends TestCase
{

    public function testDeveGerarHashDoArquivo()
    {
        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->gerarHashArquivo('./src/teste.csv');
        $hashEsperado = 'f2a14f34fd47dfe595438d1d4fe12aa760b1a368ebb10b582b0b48c899c5eb85';

        //Assert
        $this->assertEquals($hashEsperado, $result);
    }

    public function testDeveValidarCpf()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->ValidarCpf('@@### 908.104.130-43');
      
        //Assert
        $this->assertTrue($result);
    }
    public function testDeveRemoverCaracteresDoCpf()
    {
        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->removerCracteresCpf('@@### 124.874.458-68');
        $cpfEsperado = '12487445868';
        //Assert
        $this->assertEquals($cpfEsperado, $result);
    }

    public function testDeveRemoverCractereseEspacosDaCredencial()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);


        //Act
        $result = $abstractImportadorMock->removerCracteresCredencial('04ex.9000008-#00 1');
        $credencialEsperada = '04EX9000008001';


        //Assert
        $this->assertEquals($credencialEsperada, $result);
    }

    public function testDeveRetornarAMatriculaLimpa()
    {
        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->limparMatricula("0000000##@ 8162");

        $matriculaEsperada = '008162';
        $this->assertEquals($matriculaEsperada, $result);
        //Assert
    }

    public function testDeveRemoverCaracteresEspeciaiseConverterCaixaAlta()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->removerCaracteresEspeciaiseConverterCaixaAlta("Thiago     Barbosa Luís medrado @@#");
        $textoEsperado = 'THIAGO BARBOSA LUIS MEDRADO';

        //Assert
        $this->assertEquals($textoEsperado, $result);
    }

    public function testDeveRetornarDataFormatada()
    {
        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->retornarDataFormatada('25/04/2023');

        $dataEsperada = '25-04-2023';

        //Assert
        $this->assertEquals($dataEsperada, $result);
    }

    public function testDeveConverterNumeroParaMoeda()
    {
        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->converterNumeroParaMoeda('150.@@##$$87');

        $dataEsperada = '150.87';

        //Assert
        $this->assertEquals($dataEsperada, $result);
    }
}
