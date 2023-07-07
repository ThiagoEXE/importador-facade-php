<?php
require 'Importador.php';
require 'DataBase.php';

class Hapvida extends Importador
{
    public function importar($arquivo)
    {
        $numeroLinha = 1;
        $coluna = null;
        //$limit = 30;
        $handle = fopen($arquivo, 'r');
       

        if (!($handle)) {
            die("Não foi possível abrir o arquivo...");
        }
        $registros = [];
        while (($linha = fgetcsv($handle, 1000, ';')) !== false) {
            if ($numeroLinha === 8) {
                $coluna = $linha;
            } //Leitura de dados começa depois da linha de cabeçalho e apartir 
            //da linha que tem como empa A9846 o que representa o plano de saude 
            else if ($numeroLinha > 9 && $linha[0] == 'A9846') {
                //verifica se a quantidade de dados é igual que a quantidade de colunas
                if (count($coluna) === count($linha)) {
                    $registro = array_combine($coluna, $linha);
                    $registros[] = $registro;
                 
                } else {
                    echo "coluna nao corresponde;";
                    break;
                }
            }
            $numeroLinha++;
        }
        fclose($handle);
        return $registros;
        // echo "Importando dados a partir do arquivo " . $arquivo . "<br>";

    }
    public function critica()
    {
        echo "Realizando critica dos dados importados Hapvida<br>";
    }

    public function validaArquivo($registrosArquivo)
    {
        //funções herdadas de Importador
        $funcoesColunas = [
            'beneficiario' => 'removerAcentosEspacoseConverterCaixaAlta',
            'parentesco' => 'removerAcentosEspacoseConverterCaixaAlta',
            'mae' => 'removerAcentosEspacoseConverterCaixaAlta',
            'credencial' => 'removerCracteresCredencial',
            'cpf' => 'removerCracteresCpf',
            'nascimento' => 'retornarDataFormatada',
            'inicio' => 'retornarDataFormatada',
            'mensalidade' => 'converterNumeroParaMoeda',
            'adicional' => 'converterNumeroParaMoeda',
            'matricula' => 'limparMatricula',
        ];

        $dadosModel = [];
        foreach ($registrosArquivo as $registros) {
            $registroModel = [];
            foreach ($registros as $colunas => &$valor) {
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
                    $registroModel[$colunas] = $valor;
                }
            }
            $dadosModel[] = $registroModel;
            
        }
         $this->insereBanco($dadosModel);
    }

    public function insereBanco($registros)
    {
    
     $valores = [];
        foreach ($registros as $registro) {
            //var_dump($registro);
            $credencial = $registro['credencial'];
            $matricula = $registro['matricula'];
            $cpf = $registro['cpf'];
            $beneficiario = $registro['beneficiario'];
            $mae = $registro['mae'];
            $dtNascimento = $registro['nascimento'];
            $dtInicio = $registro['inicio'];
            $parentesco = $registro['parentesco'];
            $plano = $registro['plano'];
            $mensalidade = $registro['mensalidade'];
            $adicional = $registro['adicional'];

            $valores[] = "('$cpf', $matricula, '$credencial', '$beneficiario', 
        '$mae', '$dtNascimento', '$dtInicio', '$parentesco', '$plano', '$mensalidade', '$adicional')";
        }
        $query = 
        "INSERT INTO tmp_hapvida_saude_titular 
        (cpf, matricula, credencial, beneficiario, mae, nascimento, inicio, 
        parentesco, plano, mensalidade, adicional, desconto, val_empresa) 
        VALUES " . implode(", ", $valores);

      /*  echo '<pre>';
        echo $query;
        echo '<pre>';*/
        $banco = new DataBase(); 
        $banco->conexaoBanco();
    }
}
