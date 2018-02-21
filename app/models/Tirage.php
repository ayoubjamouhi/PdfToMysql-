<?php 

namespace App\Models;
use \PDO;
use App\Core\Connection;
use App\Core\App;

class Tirage

{

	private $pdo;

	public function __construct(PDO $pdo)

	{

		$this->pdo = $pdo;
	}

	public function selectAll($extra='')

	{
		$statment = $this->pdo->prepare("SELECT * FROM `tirage` {$extra}");

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

	public function selectByIdProduit($id)

	{

		$_id = (int)$id;
		$statment = $this->selectAll("WHERE `id_produit` = {$_id} ORDER BY `date_tirage` DESC");

		if($statment)
			return $statment;
		else
			return NULL;
	}

	public function insertTirage($id_produit,$nombre,$nombreProduitDansLeStock,$nombreProduitDansLeStockApresTire)
		
	{
			
		$_nombre = (int)$nombre;
		$_id_produit = (int)$id_produit;
		$_nombreProduitDansLeStock = (int)$nombreProduitDansLeStock;
		$_nombreProduitDansLeStockApresTire = (int)$nombreProduitDansLeStockApresTire;

	
		$statment = $this->pdo->prepare("INSERT INTO `tirage` VALUES(NULL,{$_id_produit},{$_nombre},CURRENT_TIMESTAMP(),{$_nombreProduitDansLeStock},{$_nombreProduitDansLeStockApresTire})");	

		var_dump($statment);

		$e = $statment->execute();

		if($e)
			return TRUE;
		else
			return FALSE;
	}
}