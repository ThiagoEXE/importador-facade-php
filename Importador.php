<?php



abstract class Importador
{

    abstract function importar($arquivo);
    abstract function validaArquivo($arquivo);
    abstract function critica();

    //Função que valida o digito verificado do cpf
    function validaCPF($cpf)
    {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($posicao = 9; $posicao < 11; $posicao++) {
            for ($indice = 0, $acumulador = 0; $indice < $posicao; $indice++) {
                $acumulador += $cpf[$indice] * (($posicao + 1) - $indice);
            }
            //$resultado = ((10 * $acumulador) % 11) % 10;
            $resultado = $acumulador % 11;
            $resultado = ($resultado < 2) ? 0 : 11 - $resultado;

            if ($cpf[$posicao] != $resultado) {
                echo "digito verificador diferente " . $resultado . PHP_EOL;
                return false;
            }
        }

        return true;
    }
    public function removerCracteresCpf($cpf)
    {
        $cpfSemCracteres = preg_replace('/[^0-9]/', '', $cpf);
        $cpfSemCracteres = str_pad($cpfSemCracteres, 11, '0', STR_PAD_LEFT);
        return trim($cpfSemCracteres);
    }

    public function removerCracteresCredencial($credencial)
    {
        $credencialSemCracteres = preg_replace('/[^0-9,A-Z,a-z]/', '', $credencial);
        return trim($credencialSemCracteres);
    }

    function limparMatricula($matricula)
    {
        $matricula = preg_replace('/[^0-9]/', '', $matricula);

        if (strlen($matricula > 6)) {
            $matriculaFormatada = substr($matricula, -6);
        } else {

            $matriculaFormatada = str_pad($matricula, 6, '0', STR_PAD_LEFT);
        }
        return trim($matriculaFormatada);
    }

    public function removerAcentosEspacoseConverterCaixaAlta($texto)
    {
        $textoSemCento = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $texto);

        $textoSemAcentoCxAlta = strtoupper($textoSemCento);
        $textoFormatado = preg_replace('/\s+/', ' ', $textoSemAcentoCxAlta);
        return trim($textoFormatado);
    }

    public function retornarDataFormatada($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', trim($data));
        if ($data === false) {
            echo "Erro ao converter data. <br>";
            $errors = DateTime::getLastErrors();
        } else {
            $dataFormatada = $data->format('d-m-Y');
            //$p_data_formatada = $p_data->format('d/m/Y');
        }
        return $dataFormatada;
    }

    public function converterNumeroParaMoeda($numero)
    {
        $numero = $numero * 0.01;
        $numeroFormatadoReais = number_format($numero, 2, '.', '.');
        return trim($numeroFormatadoReais);
    }
}
