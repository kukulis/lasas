<?php

namespace Drupal\Tests\meteo_client\Unit;

use Drupal\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('meteo_client')]
class MeteoClientSmokeTest extends UnitTestCase {

  public function testTrue(): void {
    $this->assertTrue(TRUE);
  }

}
