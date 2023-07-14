<?php



abstract class Importador
{
    public $arquivo;
    private $status;
    public $hash;
    private $tipoArquivo;
    public $registros = [];

   
    public function __construct()
    {
        $argumentos = func_get_args();
        $numeroDeArgumentos = func_num_args();

        if (method_exists($this, $function =
            'ConstructorWithArgument' . $numeroDeArgumentos)) {
            call_user_func_array(
                array($this, $function),
                $argumentos
            );
        }
    }

    public function ConstructorWithArgument1($arquivo)
    {
        $this->arquivo = $arquivo;
        $this->hash = $this->gerarHashArquivo($arquivo);
    }


    abstract function importar();
    abstract function limparArquivo();
    abstract function preparaQuery($registros);
    abstract function critica();

    public function gerarHashArquivo($arquivo)
    {

        if (file_exists($arquivo)) {
            return hash_file('sha256', $arquivo);
        } else {
            return "Arquivo não existe";
        }
    }

    //Função que valida o digito verificador do cpf
    function validarCPF($cpf)
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
        //remove tudo que não for número
        $cpfSemCracteres = preg_replace('/[^0-9]/', '', $cpf);
        $cpfSemCracteres = str_pad($cpfSemCracteres, 11, '0', STR_PAD_LEFT);
        if ($cpfSemCracteres == '00000000000') {
            $cpfSemCracteres = '';
        }
        return trim($cpfSemCracteres);
    }

    public function removerCracteresCredencial($credencial)
    {
        //remove tudo que não for letra ou número 
        $credencialSemCracteres = preg_replace('/[^0-9,A-Z,a-z]/', '', $credencial);
        $credencialFormatadaCaixaAlta = strtoupper($credencialSemCracteres);
        return trim($credencialFormatadaCaixaAlta);
    }

    public function limparMatricula($matricula)
    {
        //remove tudo que não for número
        $matricula = preg_replace('/[^0-9]/', '', $matricula);

        if (strlen($matricula > 6)) {
            $matriculaFormatada = substr($matricula, -6);
        } else {

            $matriculaFormatada = str_pad($matricula, 6, '0', STR_PAD_LEFT);

            if ($matriculaFormatada == '000000') {
                $matriculaFormatada = '';
            }
        }
        return trim($matriculaFormatada);
    }

    public function removerCaracteresEspeciaiseConverterCaixaAlta($texto)
    {
        //Remove Acentos
        $textoSemAcento = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $texto);

        //Remove caracteres especiais e números 
        $textoSemCaracteresEspeciais = preg_replace('/[^a-zA-Z\s]/', '', $textoSemAcento);

        //Converte para caixa alta
        $textoFomatado = strtoupper($textoSemCaracteresEspeciais);

        //Remove excesso de espaços
        $textoFinal = preg_replace('/\s+/', ' ', $textoFomatado);
        return trim($textoFinal);
    }

    public function retornarDataFormatada($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', trim($data));
        if ($data === false) {
            echo "Erro ao converter data. <br>";
            $errors = DateTime::getLastErrors();
            return $errors;
        } else {
            $dataFormatada = $data->format('d-m-Y');
            //$p_data_formatada = $p_data->format('d/m/Y');
        }
        return $dataFormatada;
    }

    public function converterNumeroParaMoeda($numero)
    {
        $numeroSemCracteres = preg_replace('/[^0-9]/', '', $numero);

        if (is_numeric($numeroSemCracteres)) {
            $numeroSemCracteres = $numeroSemCracteres * 0.01;
            $numeroFormatadoReais = number_format($numeroSemCracteres, 2, '.', '.');
            return trim($numeroFormatadoReais);
        } else {
            return '';
        }
    }
}
