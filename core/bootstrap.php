<?php
	
use App\Core\App;
use App\Core\Db\Connection;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Image;
use App\Models\Produit;
use App\Models\Tirage;


App::bind('config' , require 'config.php');






App::bind('User'   , new User(
							Connection::make(App::get('config')['database'])	
));

App::bind('Ticket'   , new Ticket(
	Connection::make(App::get('config')['database'])	
));

App::bind('Parser'   , new \Smalot\PdfParser\Parser());

//
App::bind('Image' ,  new Image(
	Connection::make(App::get('config')['database'])	
));
App::bind('Produit'   , new Produit(
							Connection::make(App::get('config')['database'])	
));
App::bind('Tirage'   , new Tirage(
							Connection::make(App::get('config')['database'])	
));
//
if (!function_exists('view')) 

{

	function view($page,$data = [])
		
	{
		extract($data);
		return require "app/views/{$page}.view.php";
	}
}
if (!function_exists('redirect')) 

{
	function redirect($url,$time =0)
	{
		echo 	"<script type='text/javascript'>
						function Redirect() 
						{  
						window.location='/{$url}'; 
						} 
						setTimeout('Redirect()', {$time});  
						</script>";
	}
}