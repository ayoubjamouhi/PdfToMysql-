<?php 

namespace App\Models;
use \PDO;
use App\Core\Connection;
use App\Core\App;

class Produit

{

	private $pdo;

	public function __construct(PDO $pdo)

	{

		$this->pdo = $pdo;
	}

	public function selectAll($extra='')

	{
		$statment = $this->pdo->prepare("SELECT * FROM `produits` {$extra}");

		$statment->execute();

		if(!$statment)
			return NULL;

		return $statment->fetchAll(PDO::FETCH_OBJ);
	}

	public function selectByID($id)

	{

		$_id = (int)$id;
		$statment = $this->selectAll("WHERE `id` = {$_id}");

		if($statment)
			return $statment[0];
		else
			return NULL;
	}

	public function insertProduit($nom,$nombreProduit,$img_id)
		
	{
			
		$_nom = $this->pdo->quote($nom);
		$_nombreProduit = (int)$nombreProduit;
		$_imgId = (int)$img_id;

	
		$statment = $this->pdo->prepare("INSERT INTO `produits` VALUES(NULL,{$_nom},{$_nombreProduit},{$_imgId})");	

		var_dump($statment);

		$e = $statment->execute();

		if($e)
			return TRUE;
		else
			return FALSE;
	}	

	public function updateProduit($id,$nom=NULL,$nombreProduit=NULL)
	
	{
		
		$_id = (int)$id;
		
		$produit = $this->selectByID($_id);

		/**
		 * [vois que les données existent ou no]
		 * @var [type]
		 */
		if($produit->nom == $nom && $produit->nombre_produit == $nombreProduit)
			{return false;}

		$q = [];
		$requete = "UPDATE `produits` SET ";

		if(!empty($nom))

		{

			$_nom = $this->pdo->quote($nom);
			$q[@count($q)] = "`nom` = {$_nom}";
		}



		$_nombreProduit = (int)$nombreProduit;
		$q[@count($q)] = "`nombre_produit` = {$_nombreProduit}";
		
		


		if(count($q) == 0)
			return FALSE;

		elseif(count($q) == 1)
			$requete .= $q[0] . " WHERE `id` = {$_id}";

		else
		
		{

			for($i=0;$i<count($q);$i++)

			{

				if($i < count($q) -1)
					$requete .= $q[$i] . ",";
				else
					$requete .= $q[$i] . " WHERE `id` = {$_id}";

			}
		}

		$statment = $this->pdo->prepare($requete);
		//var_dump($statment);
		$e = $statment->execute();

		if(!$e)
			return FALSE;
		return TRUE;
	}

	public function rechercheProduit($nom)
	
	{
		
		$_nom = $this->pdo->quote($nom);

		$recherche = $this->selectAll("WHERE `nom` = $_nom");

		if($recherche)
			return $recherche;
		else
			return NULL;
	}
}