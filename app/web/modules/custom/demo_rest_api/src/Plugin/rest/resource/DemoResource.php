<?php

namespace Drupal\demo_rest_api\Plugin\rest\resource;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\rest\Attribute\RestResource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;


/**
 * Provides a Demo Resource.
 */
#[RestResource(
  id: "demo_resource",
  label: new TranslatableMarkup("Demo Resource"),
  uri_paths: [
    "canonical" => "/demo_rest_api/demo_resource",
  ]
)]
class DemoResource extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return ResourceResponse
   */
  public function get() {
    $response = ['message' => 'Hello, this is a rest service'];
    return new ResourceResponse($response);
  }
}
