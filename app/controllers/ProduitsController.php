<?php

namespace App\Controllers;

use App\Core\App;

class ProduitsController

{
	/* Start GET */

	public function ajouterproduit()
	
	{
		
		session_start();

		if($_SESSION['admin'] == FALSE)
			return view('login');

		else
		{
			return view('ajouterproduit');
		}	
	}

	public function rechercheproduit()
	
	{
		
		
	}

	public function modifierproduit()
		
	{
		
		session_start();

		if($_SESSION['admin'] == FALSE)
			return view('login');

		else
		
		{

			$ex = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
			
			if(count($ex) != 2 && !is_integer((int)$ex[1]) )
				die("Error");
			
			$produit = App::get('Produit')->selectByID((int)$ex[1]);

			$imageProduit = App::get('Image')->selectNameImageById($produit->img_id);

			return view('modifierproduit',compact('produit','imageProduit'));
		}
	}

	public function  tirernombreproduit()
	
	{
		
		session_start();

		if($_SESSION['admin'] == FALSE)
			return view('login');

		else
		
		{
			$ex = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
			
			if(count($ex) != 2 && !is_integer((int)$ex[1]) )
				die("Error");
			
			$produit = App::get('Produit')->selectByID((int)$ex[1]);

			$imageProduit = App::get('Image')->selectNameImageById($produit->img_id);

			return view('tirernombreproduit',compact('produit','imageProduit'));
		}
	}


	/* End GET */

	/* Start POST */
	public function checkajouterproduit()
	
	{
		
		if($_POST['ajouter'])

		{

			if($_FILES['fic'] != NULL)
			
			{

				$insertImage = App::get('Image')->insererImage($_FILES['fic']);
				//var_dump($insertImage);
				
				if($insertImage)
				
				{

					$insertProduit = App::get('Produit')->insertProduit($_POST['nom'],$_POST['nombre'],App::get('Image')->lastIdInserer());
					if($insertProduit)
						echo "oui";
					else
						echo "no";
				}
			}
		}
	}

	public function checkrechercheproduit()
	
	{
		
		if($_POST['recherche'])

		{

			$produits = App::get('Produit')->rechercheProduit($_POST['nom']);
			$imgid = App::get('Image')->arrayImageOfIdAndName();
			if($produits)
				return view("rechercheproduit",compact('produits','imgid'));
			else
				echo "no";
		}
	}
	public function checkmodifierproduit()
	
	{
		
		if($_POST['modifier'])

		{

			$ex = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
			$id = (int)$ex[1];
			$produit = App::get('Produit')->selectByID($id);

			if($_FILES['fic'] != NULL)
			
			{

				$updateImage = App::get('Image')->updateImage($produit->img_id,$_FILES['fic']);
				//var_dump($insertImage);
				
				if($updateImage)
				
				{

					$updateProduit = App::get('Produit')->updateProduit($id,$_POST['nom'],$_POST['nombre']);
					if($updateProduit)
						echo "Vous avez modifié les données";
					else
						echo "Vous avez modifié l'image";
				}
			}

			if($_FILES['fic']['size'] == 0)

			{

				$updateProduit = App::get('Produit')->updateProduit($id,$_POST['nom'],$_POST['nombre']);
				if($updateProduit)
					echo "oui";
				else
					echo "no";				
			}			
		}
	}

	public function checktirernombreproduit()
	
	{
		
		if($_POST['tirer'])

		{

			$ex = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
			$id = (int)$ex[1];

			if((int)$_POST['nombrestock'] != 0)

			{

				$updateProduit = App::get('Produit')->updateProduit($id,$_POST['nom'],(int)$_POST['nombrestock']- $_POST['nombre']);

				$insertTirage = App::get('Tirage')
									->insertTirage($id,$_POST['nombre'],(int)$_POST['nombrestock'],(int)$_POST['nombrestock']- $_POST['nombre']);

				if($updateProduit && $insertTirage)
					echo "oui";
				else
					echo "no";				
			}
			else
				echo "Le stock est vide";
		}		
	}
	/* End POST */
}