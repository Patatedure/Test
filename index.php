<?php
	include('inc.twig.php'); //inclusion de la bibliotheque twig par le biais d'une page php

	$template_index = $twig->loadTemplate('index.tpl'); // charge une partie de la page 

	$n_jours_previsions = 3;

	$ville = "Limoges"; 

	//~ Clé API
	//~ Si besoin, vous pouvez générer votre propre clé d'API gratuitement, en créant 
	//~ votre propre compte ici : https://home.openweathermap.org/users/sign_up
	$apikey = "10eb2d60d4f267c79acb4814e95bc7dc";

	$data_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?APPID='.$apikey.'&q='.$ville.',fr&lang=fr&units=metric&cnt='.$n_jours_previsions;

	$data_contenu = file_get_contents($data_url); // récupère les données que renvoie l'api
		
	$_data_array = json_decode($data_contenu, true); //decode les données dans un tableau
	//print_r($_data_array);
	$_ville = $_data_array['city']; //prend les données dans le tableau ici les données liée à la ville
	//print_r($_ville);
	$_journees_meteo = $_data_array['list']; //prend les données liste liée à la prévision météo

	for ($i = 0; $i < count($_journees_meteo); $i++) {
		$_meteo = getMeteoImage($_journees_meteo[$i]['weather'][0]['icon']);
		
		$_journees_meteo[$i]['meteo'] = $_meteo;
	}

	echo $template_index->render(array( //pour les utilisé plus tard dans le code de la page
		'_journees_meteo'	=> $_journees_meteo,
		'_ville'			=> $_ville,
		'n_jours_previsions'=> $n_jours_previsions
	));

	function getMeteoImage($code){ //image du soleil autre chose
		if(strpos($code, 'n'))
			return 'entypo-moon';
		

		$_icones_meteo = array( //poliuce 
'01d' => 'entypo-light-up',
'02d' => 'entypo-light-up',
'03d' => 'entypo-cloud',
'04d' => 'entypo-cloud','09d' => 'entypo-water', 
'10d' => 'entypo-water',
'11d' => 'entypo-flash',
'13d' => 'entypo-star', 
'50d' => 'entypo-air');

		if(array_key_exists($code, $_icones_meteo)){
			return $_icones_meteo[$code];
		}
		else{
			return 'entypo-help';
		}
	}
