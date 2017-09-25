<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 10/08/17
 * Time: 21:53
 */

abstract class TipoUsuario
{
    const COMUM = 0;
    const PROPRIETARIO = 1;
    const MODERADOR = 2;

    public static function getTipo($tipo){
        if($tipo == COMUM){
            return "COMUM";
        }else if($tipo == PROPRIETARIO){
            return "PROPRIETARIO";
        }else if($tipo == MODERADOR){
            return "MODERADOR";
        }else{
            return null;
        }
    }
}