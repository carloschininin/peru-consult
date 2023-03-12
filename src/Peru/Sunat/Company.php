<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 15/11/2017
 * Time: 04:17 PM.
 */

namespace Peru\Sunat;

use JsonSerializable;

class Company implements JsonSerializable
{
    public string $ruc;

    public string $razonSocial;
    
    public string $nombreComercial;

    public array $telefonos;

    public string $tipo;

    public string $estado;

    public string $condicion;

    public string $direccion;

    public string $departamento;

    public string $provincia;

    public string $distrito;

    public ?string $fechaInscripcion;

    public string $sistEmsion;

    public string $sistContabilidad;

    public string $actExterior;

    public array $actEconomicas;

    public array $cpPago;

    public array $sistElectronica;

    public ?string $fechaEmisorFe;

    public ?array $cpeElectronico;

    public ?string $fechaPle;

    public array $padrones;

    public ?string $fechaBaja;

    public ?string $profesion;

    /**
     * Specify data which should be serialized to JSON.
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
