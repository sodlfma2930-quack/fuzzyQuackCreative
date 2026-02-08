<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', static function () {
	return redirect()->to('seungchul-hyunji');
});
$routes->get('seungchul-hyunji', 'Invitation::index');
$routes->post('rsvp', 'Rsvp::store');
$routes->get('gallery', 'Invitation::gallery');
$routes->get('travel-guide', 'TravelGuide::index');
