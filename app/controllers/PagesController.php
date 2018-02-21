<?php

namespace App\Controllers;

use App\Core\App;

class PagesController

{

	public function login()
	
	{
		session_start();

		if(isset($_SESSION['admin']) == FALSE)
			return view('login');

		else
			return redirect('home',2000);
	}

	public function home()
	
	{
		
		session_start();

		if($_SESSION['admin'] == FALSE)
			return view('login');
		
		else

		{
			$tickets = App::get('Ticket')->selectAll('LIMIT 10');
			// $imgid = App::get('Image')->arrayImageOfIdAndName();
			return view('index',compact('tickets'));
		}
	}

	public function logout()
	
	{
		
		session_start();

		if($_SESSION['admin'] != FALSE)
		{

			$_SESSION['admin'] = FALSE;

		   	echo 	"<script type='text/javascript'>
		      		function Redirect() 
		      		{  
		      		window.location='/'; 
		      		} 
		      		setTimeout('Redirect()', 2000);  
		    		</script>";
		}
	}
}