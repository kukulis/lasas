<?php

namespace Drupal\Tests\meteo_client\Unit;

use Drupal\meteo_client\Service\MeteoClient;
use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\Group;

/**
 * Hits the real meteo.lt API, so exclude the "network" group in regular CI.
 */
#[Group('meteo_client')]
#[Group('network')]
class MeteoClientIntegrationTest extends UnitTestCase {

  private MeteoClient $meteoClient;

  protected function setUp(): void {
    parent::setUp();
    $guzzleClient = new Client();
    $this->meteoClient = new MeteoClient($guzzleClient, 'https://api.meteo.lt/v1');
  }

  public function testPlacesClient(): void {
    $places = $this->meteoClient->getPlaces();

    $this->assertIsArray($places);
    $this->assertGreaterThan(0, count($places));
    $this->assertIsString($places[0]->name);
    $this->assertIsString($places[0]->countryCode);
    $this->assertIsString($places[0]->administrativeDivision);
    $this->assertIsString($places[0]->code);
  }

  public function testGetDetailedPlace(): void {
    $place = $this->meteoClient->getDetailedPlace('vilnius');

    $this->assertIsObject($place);
    $this->assertIsObject($place->coordinates);
    $this->assertIsString($place->name);
    $this->assertIsString($place->countryCode);
    $this->assertIsString($place->administrativeDivision);
    $this->assertIsString($place->code);
  }

  public function testForecast(): void {
    $forecast = $this->meteoClient->getForecast('vilnius');

    $this->assertIsObject($forecast);
    $this->assertIsArray($forecast->forecastTimestamps);
    $this->assertGreaterThan(0, count($forecast->forecastTimestamps));
    $this->assertIsObject($forecast->forecastTimestamps[0]);

    $this->assertIsString($forecast->forecastTimestamps[0]->forecastTimeUtc);
    $this->assertIsNumeric($forecast->forecastTimestamps[0]->airTemperature);
    $this->assertIsInt($forecast->forecastTimestamps[0]->windSpeed);
    $this->assertIsInt($forecast->forecastTimestamps[0]->windGust);
    $this->assertIsInt($forecast->forecastTimestamps[0]->windDirection);
    $this->assertIsInt($forecast->forecastTimestamps[0]->cloudCover);
    $this->assertIsInt($forecast->forecastTimestamps[0]->seaLevelPressure);
    $this->assertIsInt($forecast->forecastTimestamps[0]->relativeHumidity);
    $this->assertIsInt($forecast->forecastTimestamps[0]->totalPrecipitation);
    $this->assertIsString($forecast->forecastTimestamps[0]->conditionCode);
  }

}
