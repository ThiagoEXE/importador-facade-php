<?php

use PHPUnit\Framework\TestCase;

class HapVidaTest extends TestCase
{
    public $dados = array(
        array(

            "empa"    => "A9846",
            "unidade" => "1",
            "nome_unidade" => "OT TRANS",
            "credencial" => "A9846.000001-00 9",
            "matricula" => "1234",
            "cpf" => "111222333-10",
            "beneficiario" => "JOAQUIM ALVES DOS ANJOS",
            "mae" => "JOANITA SANTOS SANTANA",
            "nascimento" => "04/05/2015",
            "inicio" => "01/05/2015",
            "idade" => "56",
            "parentesco" => "TITULAR",
            "plano" => "5252",
            "ac" => "2",
            "mensalidade" => "14087",
            "adicional" => "0",
            "taxa_adesao" => "0",
            "desconto" => "0",
            "cobrado" => "14087"
        )
    );
    public function testDeveLerArquivoeRetornarUmArrayDeDados()
    {
        //Arrange
        $testLeituraDados = new Hapvida('./src/teste.csv');

        //Act
        $arrayEsperado = $this->dados;

        //Assert
        $this->assertEquals($arrayEsperado, $testLeituraDados->lerArquivoeRetornarUmArrayDeDados());
    }

    public function testDeveLimparDadoseRetornarUmNovoArrayDeColunasSelecionadas()
    {
        $testLimpezaDados = new Hapvida();

        $registrosFake = $this->dados;

        $registrosEsperados = array(
            array(
                "credencial" => "A9846000001009",
                "matricula" => "1234",
                "cpf" => "11122233310",
                "beneficiario" => "JOAQUIM ALVES DOS ANJOS",
                "mae" => "JOANITA SANTOS SANTANA",
                "nascimento" => "04-05-2015",
                "inicio" => "01-05-2015",
                "parentesco" => "TITULAR",
                "plano" => "5252",
                "mensalidade" => "140.87",
                "adicional" => "0.00",

            )
        );


        $testLimpezaDados->registros =  $registrosFake;
        echo "Teste da função = testDeveLimparDadoseRetornarUmNovoArrayDeColunasSelecionadas".PHP_EOL;
        echo "Antes da limpeza: ";
        print_r($testLimpezaDados->registros).PHP_EOL;


        $result = $testLimpezaDados->limparDadoseRetornarUmNovoArrayDeColunasSelecionadas();
        echo "Depois da limpeza: ";
        print_r($result);


        $this->assertEquals($registrosEsperados, $result);
    }
}
