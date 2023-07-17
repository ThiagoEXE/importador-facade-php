<?php

use PHPUnit\Framework\TestCase;

class ImportadorTest extends TestCase
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
        $hashEsperado = '7dbbfad3206267bb6dce9de412971a6aac9ada2b9544aaf6c9f2d9a3de283b00';

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

    public function testDeveRemoverCractereseAcentosDoTextoeColocarEmCaixaAlta()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);


        //Act
        $result = $abstractImportadorMock->removerCractereseAcentosDoTextoeColocarEmCaixaAlta('A9142@');
        $textoEsperado = 'A9142';


        //Assert
        $this->assertEquals($textoEsperado, $result);
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

    public function testDeveRemoverNumerosCaractereseAcentoseConverterCaixaAlta()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);

        //Act
        $result = $abstractImportadorMock->removerNumerosCaractereseAcentoseConverterCaixaAlta("Thiago     Barbosa Luís medrado @@#");
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
