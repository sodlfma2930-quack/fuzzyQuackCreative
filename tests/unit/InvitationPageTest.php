<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class InvitationPageTest extends CIUnitTestCase
{
	use FeatureTestTrait;
	use DatabaseTestTrait;

	protected $DBGroup		= 'tests';
	protected $namespace	= null;
	protected $refresh		= true;
	protected $migrate		= true;
	protected $migrateOnce	= true;

	public function testRootRedirectsToSlug(): void
	{
		$result	= $this->get('/');

		$result->assertStatus(302);
		$result->assertRedirectTo('seungchul-hyunji');
	}

	public function testInvitationPageLoads(): void
	{
		$result	= $this->get('seungchul-hyunji');

		$result->assertStatus(200);
		$result->assertSee('열 해의 사랑, 이제는 한 집의 빛이 되는 날');
		$result->assertSee('참석 여부 알려줘');
	}

	public function testGalleryEndpointReturnsItems(): void
	{
		$result	= $this->get('gallery');

		$result->assertStatus(200);

		$payload	= json_decode($result->getJSON(), true);

		$this->assertIsArray($payload);
		$this->assertArrayHasKey('items', $payload);
		$this->assertNotEmpty($payload['items']);
		$this->assertArrayHasKey('src', $payload['items'][0]);
		$this->assertArrayHasKey('alt', $payload['items'][0]);
	}

	public function testRsvpValidationFailure(): void
	{
		$result	= $this->post('rsvp', [
			'name'		=> '',
			'phone'		=> 'abc',
			'guests'	=> '10',
			'attendance'	=> '',
			'message'	=> str_repeat('a', 300),
		]);

		$result->assertStatus(400);

		$payload	= json_decode($result->getJSON(), true);

		$this->assertIsArray($payload);
		$this->assertArrayHasKey('messages', $payload);
		$this->assertArrayHasKey('name', $payload['messages']);
		$this->assertArrayHasKey('phone', $payload['messages']);
		$this->assertArrayHasKey('guests', $payload['messages']);
		$this->assertArrayHasKey('attendance', $payload['messages']);
	}

	public function testRsvpSuccessCreatesRecord(): void
	{
		$payload	= [
			'name'		=> '홍길동',
			'phone'		=> '01012345678',
			'guests'	=> '2',
			'attendance'	=> 'yes',
			'message'	=> '축하해! 꼭 갈게.',
		];

		$result	= $this->post('rsvp', $payload);

		$result->assertStatus(201);

		$this->seeInDatabase('rsvps', [
			'name'		=> '홍길동',
			'phone'		=> '01012345678',
			'guests'	=> 2,
			'attendance'	=> 'yes',
		]);
	}
}
