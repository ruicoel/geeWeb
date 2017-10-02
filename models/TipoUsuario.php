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
        if($tipo == self::COMUM){
            return "COMUM";
        }else if($tipo == self::PROPRIETARIO){
            return "PROPRIETARIO";
        }else if($tipo == self::MODERADOR){
            return "MODERADOR";
        }else{
            return null;
        }
    }

    public static function getConstants() {
        $constCacheArray[] = null;
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, $constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            $constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return $constCacheArray[$calledClass];
    }
}