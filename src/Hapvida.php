<?php
require 'Importador.php';
require 'DataBase.php';

class Hapvida extends Importador
{

    


    public function lerArquivoeRetornarUmArrayDeDados()
    {
        $numeroLinha = 1;
        $coluna = null;
        $handle = fopen($this->arquivo, 'r');
        $codPlano = 'A9846';


        if (!($handle)) {
            die("Não foi possível abrir o arquivo...");
        }

        while (($linha = fgetcsv($handle, 1000, ';')) !== false) {
            if ($numeroLinha === 8) {
                $coluna = $linha;
            } //Leitura de dados começa depois da linha de cabeçalho e apartir 
            //da linha que tem como empa A9846 o que representa o plano de saude 
            else if ($numeroLinha > 9 && ($this->removerCractereseAcentosDoTextoeColocarEmCaixaAlta($linha[0]) == $codPlano)) {
                //verifica se a quantidade de dados é igual que a quantidade de colunas
                if (count($coluna) === count($linha)) {
                    $registro = array_combine($coluna, $linha);
                    $this->registros[] = $registro;
                } else {
                    echo "coluna nao corresponde;";
                    break;
                }
            }
            $numeroLinha++;
        }
        fclose($handle);
        // echo "Importando dados a partir do arquivo " . $arquivo . "<br>";
        return $this->registros;
    }

    public function limparDadoseRetornarUmNovoArrayDeColunasSelecionadas()
    {
        //chamando funções herdadas de Importador para limpar os dados das respectivas colunas
        $funcoesColunas = [
            'beneficiario' => 'removerNumerosCaractereseAcentoseConverterCaixaAlta',
            'parentesco'   => 'removerNumerosCaractereseAcentoseConverterCaixaAlta',
            'mae'          => 'removerNumerosCaractereseAcentoseConverterCaixaAlta',
            'credencial'   => 'removerCractereseAcentosDoTextoeColocarEmCaixaAlta',
            'cpf'          => 'removerCracteresCpf',
            'nascimento'   => 'retornarDataFormatada',
            'inicio'       => 'retornarDataFormatada',
            'mensalidade'  => 'converterNumeroParaMoeda',
            'adicional'    => 'converterNumeroParaMoeda',
            'matricula'    => 'limparMatricula',
        ];


        foreach ($this->registros as $registro) {
            $dadosSelecionados = [];
            foreach ($registro as $colunas => &$valor) {
                if (isset($funcoesColunas[$colunas])) {
                    $funcao = $funcoesColunas[$colunas];
                    $valor = $this->$funcao($valor);
                }

                if (in_array(
                    $colunas,
                    [
                        'cpf',
                        'matricula',
                        'credencial',
                        'beneficiario',
                        'mae',
                        'nascimento',
                        'inicio',
                        'parentesco',
                        'plano',
                        'mensalidade',
                        'adicional'
                    ]
                )) {
                    $dadosSelecionados[$colunas] = $valor;
                }
            }
            $this->dadosLimpos[] = $dadosSelecionados;
        }
        return $this->dadosLimpos;
    }

    public function critica()
    {
        echo "Realizando critica dos dados importados Hapvida<br>";
    }
}
