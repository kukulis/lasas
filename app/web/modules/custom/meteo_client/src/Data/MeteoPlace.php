<?php
/**
 * Created by PhpStorm.
 * User: giedrius
 * Date: 20.6.13
 * Time: 12.17
 */

namespace Drupal\meteo_client\Data;


/**
 * This class represents location structure, received from meteo.lt
 * Class MeteoPlace
 * @package Gt\Data
 */
class MeteoPlace
{
    public $code;
    public $name;
    public $administrativeDivision;
    public $countryCode;

    /** @var Coordinates */
    public $coordinates;
}