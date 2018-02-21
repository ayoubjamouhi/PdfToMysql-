<?php

namespace App\Models;
use \PDO;

class User
{
		
	protected $pdo;
	
	public function __construct(PDO $pdo)

	{
		$this->pdo = $pdo;
	}


	public function selectAll($extra='')

	{
		$statment = $this->pdo->prepare("SELECT * FROM `users` {$extra}");

		$statment->execute();

		if(!$statment)
			return NULL;

		return $statment->fetchAll(PDO::FETCH_OBJ);
	}

	public function selectByID($id)

	{
		$statment = $this->selectAll("WHERE `id` = {$id}");

		$statment->execute();

		return $statment->fetchAll(PDO::FETCH_OBJ);
	}
	
}