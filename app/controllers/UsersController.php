<?php 

namespace App\Controllers;

use App\Core\App;
use App\Core\Db\Connection;

class UsersController

{

	public function login()
	
	{


			if(empty($_POST['username']) || empty($_POST['password']))
				die("Error");

			$_user = Connection::make(App::get('config')['database'])->quote($_POST['username']);
			$_pass = Connection::make(App::get('config')['database'])->quote(md5($_POST['password']));
			
			$users = App::get('User')->selectAll("WHERE `username` = {$_user} AND `password` = {$_pass}");
			
			session_start();

		    if($users != NULL)

		    {

				$_SESSION['admin'] = $users[0];
				echo "Vous avez connecté avec succés";
		   		return redirect('home',2000);		    	
		    }
		    else

		    {

		    	$_SESSION['admin'] = FALSE;
		    	echo "Erreur dans les données";
				return redirect('home',2000);			    	
		    }

		


	}
}