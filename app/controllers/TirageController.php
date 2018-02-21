<?php

namespace App\Controllers;

use App\Core\App;

class TirageController

{

	public function historiquetirage()
	
	{
		
		session_start();

		if($_SESSION['admin'] == FALSE)
			return view('login');

		else

		{

			$ex = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
			$id = (int)$ex[1];

			if(isset($ex[1]) && is_int($id))
			
			{

				$tirages = App::get('Tirage')->selectByIdProduit($id);
				$produit = App::get('Produit')->selectByID($id);
			}
			return view('historiquetirage',compact('tirages','produit'));
		}
	}
}