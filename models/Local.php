<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 14/08/17
 * Time: 20:03
 */

class Local
{
    private $id;
    private $nome;
    private $descricao;
    private $ponto;
    private $ativo;
    private $privado;

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
    public function getPonto()
    {
        return $this->ponto;
    }

    /**
     * @param mixed $ponto
     */
    public function setPonto($ponto)
    {
        $this->ponto = $ponto;
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

    /**
     * @return mixed
     */
    public function getPrivado()
    {
        return $this->privado;
    }

    /**
     * @param mixed $privado
     */
    public function setPrivado($privado)
    {
        $this->privado = $privado;
    }

    public function jsonSerialize() {
        $obj =  [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'ponto' => $this->ponto,
            'ativo' => $this->ativo,
            'privado' => $this->privado
        ];

        return $obj;
    }


}