<?php
	
	namespace App\Core\Db;
	
	/* darori ila dert namespace pour le fichier */
	use \PDO;
	
	class Connection

	{

		public $pdo;
		
		public static function make($config)

		{
			
			try 
		
			{

				$pdo = new PDO('mysql:dbname=pdftomysql;host=localhost','root','');
				return $pdo;
			}

			catch (PDOException $e) 
			
			{
			    echo 'Connexion échouée : ' . $e->getMessage();
			}
		}

		public  static function db_close()

		{

			$pdo = NULL;
		}

	}


?>