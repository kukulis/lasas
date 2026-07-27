<?php
/**
 * Created by PhpStorm.
 * User: giedrius
 * Date: 20.6.13
 * Time: 12.50
 */

namespace Drupal\meteo_client\Data;


/**
 * This class represents one time period forecast info, received from Meteo.lt
 * Class ForecastTimestamp
 * @package Gt\Data
 */
class ForecastTimestamp
{

    const CONDITION_CLEAR = 'clear'; // - giedra;
    const CONDITION_ISOLATED_CLOUDS = 'isolated-clouds'; // - mažai debesuota;
    const CONDITION_SCATTERED_CLOUDS = 'scattered-clouds'; // - debesuota su pragiedruliais;
    const CONDITION_OVERCAST = 'overcast'; // - debesuota;
    const CONDITION_LIGTH_RAIN='light-rain'; //- nedidelis lietus;
    const CONDITION_MODERATE_RAIN = 'moderate-rain'; //  - lietus;
    const CONDITION_HEAVY_RAIN = 'heavy-rain'; // - smarkus lietus;
    const CONDITION_SLEET='sleet'; // - šlapdriba;
    const CONDITION_LIGHT_SNOW='light-snow'; // - nedidelis sniegas;
    const CONDITION_MODERATE_SNOW='moderate-snow'; // - sniegas;
    const CONDITION_HEAVY_SNOW='heavy-snow'; // - smarkus sniegas;
    const CONDITION_FOG = 'fog'; // - rūkas;
    const CONDITION_NA='na'; // - oro sąlygos nenustatytos.

    /** @var string */
    public $forecastTimeUtc; // "2020-06-13 09:00:00"
    /** @var double */
    public $airTemperature;
    /** @var int */
    public $windSpeed;

    /** @var int */
    public $windGust;

    /** @var int */
    public $windDirection;

    /** @var int */
    public $cloudCover;

    /** @var int */
    public $seaLevelPressure;

    /** @var int */
    public $relativeHumidity;

    /** @var int */
    public $totalPrecipitation;

    /** @var string */
    public $conditionCode;
}