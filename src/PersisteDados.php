<?php

class PersisteDados
{
    public $hashArquivo;
    public $tipo;
    public $conexao;
    public $query;
    public $status;
    public $nomeDoArquivo;


    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }


    public function preparaQueryDeImportacaoHapVida($id, $registros)
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
            $idHeadArquivo = $id;

            $valores[] = "('$cpf', '$matricula', '$credencial', '$beneficiario', 
        '$mae', '$dtNascimento', '$dtInicio', '$parentesco', '$plano', $mensalidade, $adicional, $idHeadArquivo)";
        }
        $this->query =
            "INSERT INTO tmp_hapvida_saude_titular 
        (cpf, matricula, credencial, beneficiario, mae, nascimento, inicio, 
        parentesco, plano, mensalidade, adicional, id_head_arquivo) 
        VALUES " . implode(", ", $valores);


        return $this->query;
    }

    public function insereDadosHapVida($hashArquivo, $tipo, $nomeDoArquivo, $registros)
    {
        $this->hashArquivo = $hashArquivo;
        $this->tipo = $tipo;
        $this->nomeDoArquivo = $nomeDoArquivo;
        if (!$this->conexao) {
            die("Conexão com banco de dados falhou .");
            exit;
        }

        $this->conexao->beginTransaction();

        try {

            $queryHead = "INSERT INTO tmp_hapvida_saude_head(hash_arquivo, nome, tipo)
            VALUES (?,?,?)";

            $stmt = $this->conexao->prepare($queryHead);
            $stmt->execute([$this->hashArquivo, $this->nomeDoArquivo, $this->tipo]);


             // Obtém o ID gerado pela query de INSERT
        $idInserido = $this->conexao->lastInsertId();

        $this->preparaQueryDeImportacaoHapVida($idInserido, $registros);

        $stmt = $this->conexao->prepare($this->query);
        $resultado = $stmt->execute();
        
            if ($resultado) {
                // Se tudo ocorreu bem, realiza o commit das alterações
                $this->conexao->commit();
                echo "Dados inseridos com sucesso.";
            } else {
                // Caso a segunda query falhe, desfaz as alterações (rollback)
                $this->conexao->rollBack();
                echo "Erro ao inserir os dados em tm_saude_hapvida_titular.";
            }
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            echo "Erro na transação: " . $e->getMessage();
        }
    }
}
