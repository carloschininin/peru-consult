<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 15/11/2017
 * Time: 04:16 PM.
 */

namespace Peru\Reniec;

use JsonSerializable;

/**
 * Class Person.
 */
class Person implements JsonSerializable
{
    public string $dni;
    public string $nombres;
    public string $apellidoPaterno;
    public string $apellidoMaterno;
    public string $codVerifica;

    /**
     * Specify data which should be serialized to JSON.
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
