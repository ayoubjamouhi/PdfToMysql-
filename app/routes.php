<?php



	$router->get('' 			 				 , 'PagesController@login');
	$router->get('home' 		 		 		 , 'PagesController@home');
	$router->get('logout' 		 		 		 , 'PagesController@logout');
	$router->get('test' 		 		 		 , 'TicketsController@test');
	
	// /* Start Produit */
	// $router->get('ajouterproduit' 		 	 	 , 'ProduitsController@ajouterproduit');
	// $router->get('rechercheproduit' 		 	 , 'ProduitsController@rechercheproduit');	
	// $router->get('modifierproduit/idp' 		 	 , 'ProduitsController@modifierproduit');
	// $router->get('tirernombreproduit/idp' 		 , 'ProduitsController@tirernombreproduit');
	// $router->get('historiquetirage/idp' 		 , 'TirageController@historiquetirage');

	// $router->post('ajouterproduit' 		 		 , 'ProduitsController@checkajouterproduit');
	// $router->post('rechercheproduit' 		 	 , 'ProduitsController@checkrechercheproduit');
	// $router->post('modifierproduit/idp' 		 , 'ProduitsController@checkmodifierproduit');
	// $router->post('tirernombreproduit/idp' 		 , 'ProduitsController@checktirernombreproduit');

	// /* End Produit */

	$router->post('login' 						 , 'UsersController@login');

	$router->get('pointage-bsp' 				 , 'TicketsController@pointeurbsp');
	$router->post('pointage-bsp' 				 , 'TicketsController@checkpointeurbsp');

	$router->get('pointage-vente' 				 , 'TicketsController@pointeurvente');
	$router->post('pointage-vente' 				 , 'TicketsController@checkpointeurvente');

	$router->post('regenerer-vente' 		     , 'TicketsController@regenerervente');
