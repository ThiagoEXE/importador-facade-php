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
            
            $this->obImportador->lerArquivoeRetornarUmArrayDeDados();
            $this->obImportador->limparDadoseRetornarUmNovoArrayDeColunasSelecionadas();
            $this->obImportador->critica();
            //recebe os dados limpos do array que esta na classe abstrata Importador
            $dadosHapVida = $this->obImportador->dadosLimpos;
            if(!empty($dadosHapVida)){
                $this->conexao = new DataBase();
                $this->persisteDados = new PersisteDados($this->conexao);
                $this->persisteDados->preparaQueryDeImportacaoHapVida($hashArquivo, $tipo, $dadosHapVida);
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
