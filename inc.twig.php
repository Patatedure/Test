<?php
	include_once('lib/Twig/Autoloader.php'); //inclu les données de twig une seul fois

	Twig_Autoloader::register();

	$templates = new Twig_Loader_Filesystem('templates');
	$twig      = new Twig_Environment($templates);
 ?>