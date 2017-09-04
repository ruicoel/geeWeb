<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/08/17
 * Time: 19:40
 */

class Historico
{
    private $id;
    private $campo;
    private $valor;
    private $data;
    private $idLocal;

    /**
 * @return mixed
 */
public function getId()
{
    return $this->id;
}/**
 * @param mixed $id
 */
public function setId($id)
{
    $this->id = $id;
}/**
 * @return mixed
 */
public function getCampo()
{
    return $this->campo;
}/**
 * @param mixed $campo
 */
public function setCampo($campo)
{
    $this->campo = $campo;
}/**
 * @return mixed
 */
public function getValor()
{
    return $this->valor;
}/**
 * @param mixed $valor
 */
public function setValor($valor)
{
    $this->valor = $valor;
}/**
 * @return mixed
 */
public function getData()
{
    return $this->data;
}/**
 * @param mixed $data
 */
public function setData($data)
{
    $this->data = $data;
}/**
 * @return mixed
 */
public function getIdLocal()
{
    return $this->idLocal;
}/**
 * @param mixed $idLocal
 */
public function setIdLocal($idLocal)
{
    $this->idLocal = $idLocal;
}


}