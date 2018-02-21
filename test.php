<?php

	//  function direct()

	// {

	// 		$ex = explode("@", "admin@user");
	// 		return callAction(
	// 				$ex[0],$ex[1]
	// 			);

		


	// }

	//  function callAction($controller,$action)

	// {

	// 	echo $controller;
	// 	echo $action;
	// }

	// direct();

	var_dump($_SERVER);

	function redirect($url,$time)
	{
		echo 	"<script type='text/javascript'>
						function Redirect() 
						{  
						window.location='/{$url}'; 
						} 
						setTimeout('Redirect()', {$time});  
						</script>";
	}
