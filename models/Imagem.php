<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 14/08/17
 * Time: 20:01
 */

class Imagem
{
    private $id;
    private $arquivo;
    private $idAmbiente;

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
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
    }

    /**
     * @return mixed
     */
    public function getIdAmbiente()
    {
        return $this->idAmbiente;
    }

    /**
     * @param mixed $idAmbiente
     */
    public function setIdAmbiente($idAmbiente)
    {
        $this->idAmbiente = $idAmbiente;
    }


}