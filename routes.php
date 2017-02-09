<?php

	/**
	 * Declare all routes here.
	 */
	$router->get( '' , 'PagesController@home' );
	$router->get( 'about' , 'PagesController@about' );
	$router->get( 'contact' , 'PagesController@contact' );
	$router->get( 'users' , 'UsersController@show' );
	$router->get( 'users/:userId' , 'UsersController@userDetail' );

	$router->get( 'home' , 'HomeController@home' );
	$router->get( 'packages' , 'PackageController@show' );
	$router->get( 'packages/:packageId/:foo/:bar' , 'PackageController@packageDetail' );

	/**
	 * Authentication routes
	 */
	$router->get( 'register' , 'AuthController@register' );
	$router->post( 'register' , 'UsersController@store' );
	$router->get( 'login' , 'AuthController@login' );
	$router->post( 'login' , 'AuthController@signIn' );

	$router->post( 'users' , 'UsersController@store' );