<?php

namespace App\Core;

class Router

{

	protected $routes = [

		'GET' 	=> [],
		'POST'	=> []

	];

	public function get($uri,$controller)
	
	{

		
		require 'core/bootstrap.php';

		$produits = App::get('Produit')->selectAll();

		$ex = explode('/', $uri);


		/**
		 * if $ex[1] exist and == 'idp'
		 */
		//var_dump($ex);
		if(count($ex) == 2)

		{


			if($ex[1] == 'idp')

			{
				foreach($produits as $produit)
					$this->routes['GET'][$ex[0].'/'.$produit->id]= $controller;
			}


		}
		else
			$this->routes['GET'][$uri]= $controller;

		
		//var_dump($this->routes['GET']);
	}

	public function post($uri,$controller)
	
	{

		
		require 'core/bootstrap.php';

		$produits = App::get('Produit')->selectAll();

		$ex = explode('/', $uri);


		/**
		 * if $ex[1] exist and == 'idp'
		 */
		//var_dump($ex);
		if(count($ex) == 2)

		{


			if($ex[1] == 'idp')

			{
				foreach($produits as $produit)
					$this->routes['POST'][$ex[0].'/'.$produit->id]= $controller;
			}


		}
		else
			$this->routes['POST'][$uri]= $controller;

		
		//var_dump($this->routes['GET']);
	}

	public static function load($file)

	{
		$router = new static;
		require $file;
		return $router;
	}

	public function direct($uri,$requestType)

	{

		if(array_key_exists($uri, $this->routes[$requestType]))
		
		{
			$ex = explode("@", $this->routes[$requestType][$uri]);
			return $this->callAction(
					$ex[0],$ex[1]
				);

		}
		else
			echo "Error 404";

	}

	protected function callAction($controller,$action)

	{

		$controller = "App\\Controllers\\{$controller}";

		$controller = new $controller;


		if(! method_exists($controller, $action))

		{

			throw new Exception(
				"{$controller} does  not respond to the {$action}"
				);
			
		}
		
		return $controller->$action();
	}
}