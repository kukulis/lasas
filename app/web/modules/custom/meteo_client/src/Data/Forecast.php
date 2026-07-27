<?php
namespace Drupal\meteo_client\Data;

/**
 * This Class represents json structure, received from meteo.lt
 * Class Forecast
 * @package Gt\Data
 */
class Forecast
{
    /** @var MeteoPlace */
    public $place;
    /** @var string */
    public $forecastType;

    /** @var string */
    public $forecastCreationTimeUtc;

    /** @var ForecastTimestamp[] */
    public $forecastTimestamps;
}
