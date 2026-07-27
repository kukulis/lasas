<?php

namespace Drupal\meteo_client\Service;

use Drupal\meteo_client\Data\Forecast;
use Drupal\meteo_client\Data\MeteoPlace;
use Drupal\meteo_client\Exception\GtNetworkException;
use Drupal\meteo_client\Exception\GtNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Client for meteo.lt api.
 *
 * Class MeteoClient
 * @package Drupal\meteo_client\Service
 */
class MeteoClient
{
    /** @var  Client*/
    private $guzzleClient;

    /** @var string */
    private $baseUrl;

    /**
     * MeteoClient constructor.
     * @param Client $guzzleClient
     * @param string $baseUrl
     */
    public function __construct(Client $guzzleClient, string $baseUrl)
    {
        $this->guzzleClient = $guzzleClient;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $url
     * @return mixed
     * @throws GtNetworkException
     * @throws GtNotFoundException
     */
    protected function getGetMeteoData ( $url ) {
        try {
            $rez = $this->guzzleClient->get($url, []);

            if ($rez->getStatusCode() != 200) {
                throw new GtNetworkException("error connecting meteo:" . $rez->getStatusCode() . ' ' . $rez->getReasonPhrase());
            }
        } catch (ClientException $e ) {
            if (  $e->getCode() == 404 ) {
                throw new GtNotFoundException("Not found:" . $e->getMessage());
            }
            throw new GtNetworkException( "error connecting meteo:". $e->getMessage());
        }
        try {
            $rezJson = (string) $rez->getBody();
            return json_decode($rezJson, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new GtNetworkException( "error connecting meteo:". $e->getMessage());
        }
    }


    /**
     * @return MeteoPlace[] Actually returns \stdClass[] but fields are the same as MeteoPlace
     * @throws GtNetworkException
     * @throws GtNotFoundException
     */
    public function getPlaces() {
        $url = $this->baseUrl.'/places';
        return $this->getGetMeteoData( $url );
    }

    /**
     * @param string $placeCode
     * @return MeteoPlace Actually returns \stdClass but fields are the same as MeteoPlace
     * @throws GtNetworkException
     * @throws GtNotFoundException
     */
    public function getDetailedPlace($placeCode) {
        $url = $this->baseUrl. '/places/'. $placeCode;
        return $this->getGetMeteoData($url);
    }

    /**
     * @param $place
     * @return Forecast
     * @throws GtNetworkException
     * @throws GtNotFoundException
     */
    public function getForecast ( $place ) {
        $url =  $this->baseUrl.'/places/'.$place.'/forecasts/long-term';
        return $this->getGetMeteoData($url);
    }
}
