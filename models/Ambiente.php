<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 14/08/17
 * Time: 20:12
 */

class Ambiente
{
    private $id;
    private $nome;
    private $descricao;
    private $valor;
    private $divisaoHoras;
    private $ativo;
    private $idLocal;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getDivisaoHoras()
    {
        return $this->divisaoHoras;
    }

    /**
     * @param mixed $divisaoHoras
     */
    public function setDivisaoHoras($divisaoHoras)
    {
        $this->divisaoHoras = $divisaoHoras;
    }

    /**
     * @return mixed
     */
    public function getIdLocal()
    {
        return $this->idLocal;
    }

    /**
     * @param mixed $idLocal
     */
    public function setIdLocal($idLocal)
    {
        $this->idLocal = $idLocal;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    public function getValorFormatado(){
        setlocale(LC_MONETARY, 'pt-BR');
        return money_format('R$ %i', $this->valor);
    }

}