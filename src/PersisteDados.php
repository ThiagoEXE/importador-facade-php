<?php

class PersisteDados
{
    public $hashArquivo;
    public $tipo;
    public $conexao;
    public $query;


    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function preparaQueryDeImportacaoHapVida($hashArquivo, $tipo, $registros)
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

            $valores[] = "('$cpf', '$matricula', '$credencial', '$beneficiario', 
        '$mae', '$dtNascimento', '$dtInicio', '$parentesco', '$plano', $mensalidade, $adicional)";
        }
        $this->query =
            "INSERT INTO tmp_hapvida_saude_titular 
        (cpf, matricula, credencial, beneficiario, mae, nascimento, inicio, 
        parentesco, plano, mensalidade, adicional) 
        VALUES " . implode(", ", $valores);

       
        return $this->query;
    }

    public function insereDadosHapVida()
    {
        if(!$this->conexao){
            die("Conexão com banco de dados falhou .");
            exit;
        }
        //testar a conexão com o banco antes de executar a query
        $resultado = pg_query($this->conexao, $this->query);

        $resultado = ($resultado == true) ? "Dados inseridos com sucesso." : "Erro ao inserir os dados.";
        echo $resultado;
    }
}
