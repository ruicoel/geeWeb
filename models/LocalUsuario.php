<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 14/08/17
 * Time: 20:08
 */

class LocalUsuario
{
    private $idLocal;
    private $idUsuario;

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
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }


}