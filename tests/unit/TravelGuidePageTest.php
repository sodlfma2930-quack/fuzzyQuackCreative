<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class TravelGuidePageTest extends CIUnitTestCase
{
	use FeatureTestTrait;

	public function testTravelGuidePageLoads(): void
	{
		$result	= $this->get('travel-guide');

		$result->assertStatus(200);
		$result->assertSee('대구 여행 가이드');
		$result->assertSee('Spot Light');
	}
}
