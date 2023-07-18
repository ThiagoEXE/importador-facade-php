<?php

class ImportadorFacade
{
    private $obImportador;
    private $persisteDados;
    private $conexao;

    public function __construct()
    {
        
    }
    
    function importar($arquivo, $tipo)
    {
        if ($tipo === 'hapvida') {
            $this->obImportador = new Hapvida($arquivo);
            
            $hashArquivo = $this->obImportador->hash;
            //nome do arquivo
            $nomeDoArquivo = basename($arquivo);
            $this->obImportador->lerArquivoeRetornarUmArrayDeDados();
            $this->obImportador->limparDadoseRetornarUmNovoArrayDeColunasSelecionadas();
            //$this->obImportador->critica();
            //recebe os dados limpos do array que esta na classe abstrata Importador
            $dadosHapVida = $this->obImportador->dadosLimpos;

            if(!empty($dadosHapVida)){
                $this->conexao = new DataBase();
                $conexao = $this->conexao->conexaoBanco();
                $this->persisteDados = new PersisteDados($conexao);
                $this->persisteDados->insereDadosHapVida($hashArquivo, $tipo, $nomeDoArquivo, $dadosHapVida);
            }
      
        } else if ($tipo === 'itau') {
            $this->obImportador = new Itau($arquivo);
            $this->obImportador->lerArquivoeRetornarUmArrayDeDados($arquivo);
            // $this->obImportador->critica();
            $this->obImportador->limparDadoseRetornarUmNovoArrayDeColunasSelecionadas();
        } else {
            echo "Tipo de importação inválido";
        }
    }
}
