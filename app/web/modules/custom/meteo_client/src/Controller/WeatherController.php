<?php

namespace Drupal\meteo_client\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\meteo_client\Exception\GtNetworkException;
use Drupal\meteo_client\Exception\GtNotFoundException;
use Drupal\meteo_client\Form\WeatherSearchForm;
use Drupal\meteo_client\Service\MeteoClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Displays today's weather forecast for a place.
 */
class WeatherController extends ControllerBase
{

  public function __construct(
    private readonly MeteoClient $meteoClient,
  ) {
  }

  public static function create(ContainerInterface $container): static
  {
    return new static($container->get('meteo_client.client'));
  }

  /**
   * How long a rendered forecast page may be cached, in seconds.
   */
  private const CACHE_MAX_AGE = 900;

  /**
   * Builds a table of today's forecast timestamps for the given place.
   */
  public function today(string $place = 'vilnius'): array
  {
    $build['umbajumba'] = $this->formBuilder()->getForm(WeatherSearchForm::class);
    $build['#cache'] = ['max-age' => self::CACHE_MAX_AGE];

    try {
      $forecast = $this->meteoClient->getForecast($place);
    } catch (GtNotFoundException $e) {
      $build['message'] = [
        '#markup' => $this->t('No weather data found for %place.', ['%place' => $place]),
      ];
      return $build;
    } catch (GtNetworkException $e) {
      $build['message'] = [
        '#markup' => $this->t('Unable to fetch weather data: @message', ['@message' => $e->getMessage()]),
      ];
      return $build;
    }

    $today = gmdate('Y-m-d');
    $rows = [];
    foreach ($forecast->forecastTimestamps as $timestamp) {
      if (!str_starts_with($timestamp->forecastTimeUtc, $today)) {
        continue;
      }
      $rows[] = [
        substr($timestamp->forecastTimeUtc, 11, 5),
        $timestamp->airTemperature . ' °C',
        $timestamp->windSpeed . ' m/s',
        $timestamp->cloudCover . ' %',
        $timestamp->relativeHumidity . ' %',
        $timestamp->totalPrecipitation . ' mm',
        $timestamp->conditionCode,
      ];
    }

    $placeName = $forecast->place->name ?? $place;

    if (!$rows) {
      $build['message'] = [
        '#markup' => $this->t('No forecast available for today in %place.', ['%place' => $placeName]),
      ];
      return $build;
    }

    $build['updated'] = [
      '#markup' => $this->t('Forecast data as of %date UTC.', [
        '%date' => $forecast->forecastCreationTimeUtc,
      ]),
    ];
    $build['table'] = [
      '#type' => 'table',
      '#caption' => $this->t("Today's weather in %place", ['%place' => $placeName]),
      '#header' => [
        $this->t('Time (UTC)'),
        $this->t('Temperature'),
        $this->t('Wind'),
        $this->t('Cloud cover'),
        $this->t('Humidity'),
        $this->t('Precipitation'),
        $this->t('Condition'),
      ],
      '#rows' => $rows,
    ];

    return $build;
  }

}
