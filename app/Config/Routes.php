<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', static function () {
	return view('home');
});
$routes->get('seungchul-hyunji', 'Invitation::index');
$routes->post('rsvp', 'Rsvp::store');
$routes->get('gallery', 'Invitation::gallery');
$routes->get('travel-guide', 'TravelGuide::index');

$routes->get('admin', 'Admin::index');
$routes->get('admin/texts', 'Admin::texts');
$routes->post('admin/texts', 'Admin::updateTexts');
$routes->get('admin/gallery', 'Admin::gallery');
$routes->post('admin/gallery/upload', 'Admin::uploadImage');
$routes->post('admin/gallery/delete/(:num)', 'Admin::deleteImage/$1');
$routes->post('admin/gallery/alt/(:num)', 'Admin::updateImageAlt/$1');

$routes->get('admin/blog', 'AdminBlog::index');
$routes->get('admin/blog/create', 'AdminBlog::create');
$routes->post('admin/blog/store', 'AdminBlog::store');
$routes->get('admin/blog/edit/(:num)', 'AdminBlog::edit/$1');
$routes->post('admin/blog/update/(:num)', 'AdminBlog::update/$1');
$routes->post('admin/blog/delete/(:num)', 'AdminBlog::delete/$1');

$routes->get('blog', 'Blog::index');
$routes->get('blog/(:segment)', 'Blog::show/$1');
