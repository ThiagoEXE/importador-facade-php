<?php

class PersisteDados
{

    public function insereDadosHapVida($conexao, $query)
    {

        $resultado = pg_query($conexao, $query);

        $resultado = ($resultado == true) ? "Dados inseridos com sucesso." : "Erro ao inserir os dados.";
        echo $resultado;
    }
}
