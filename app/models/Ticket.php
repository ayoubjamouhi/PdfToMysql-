<?php 

namespace App\Models;
use \PDO;
use App\Core\Connection;
use App\Core\App;

class Ticket

{

	private $pdo;

	public function __construct(PDO $pdo)

	{

		$this->pdo = $pdo;
    }

    public function selectAll($extra='')

	{
		$statment = $this->pdo->prepare("SELECT * FROM `electronic_ticket` {$extra}");

		$statment->execute();

		if(!$statment)
			return NULL;

		return $statment->fetchAll(PDO::FETCH_OBJ);
	}
	public function insertDonneesPdfToDb($donneesArg)
	{
		$i=0;
		foreach($donneesArg as $donnees1)
		{
			foreach($donnees1 as $donnees)
			{

				$statment = $this->pdo->prepare("INSERT INTO `electronic_ticket` 
							VALUES(NULL,'{$donnees[0]}','MAD','{$donnees[2]}','{$donnees[3]}','{$donnees[4]}','{$donnees[5]}',{$donnees[6]},'{$donnees[7]}','{$donnees[8]}','{$donnees[9]}','{$donnees[10]}',".((int) $donnees[11]).",'{$donnees[12]}','{$donnees[13]}','{$donnees[14]}','{$donnees[15]}','{$donnees[16]}',".((int) $donnees[17]).",'{$donnees[18]}','{$donnees[19]}','{$donnees[20]}','{$donnees[21]}','{$donnees[22]}','{$donnees[23]}',".((int) $donnees[24]).",".((int) $donnees[25]).",".((int) $donnees[26]).")
					");
				// var_dump($donnees);
				// var_dump($statment);
				$ex = $statment->execute();
				if($ex)
					$i++;
			}
		}
		return $i;
	}
	public function selectFromDeuxiemeDbByDateInitAndFinal($dateinit, $datefinal)
	{

	// $statment = $this->pdo->prepare("SELECT * FROM `air_tbl` WHERE `ALLER` BETWEEN {$dateinit} AND {$datefinal}");

	// 	$statment->execute();

	// 	if(!$statment)
	// 		return NULL;

	// 	return $statment->fetchAll(PDO::FETCH_OBJ);		
	}
}