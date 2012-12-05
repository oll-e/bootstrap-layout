<?php

define('ROOT_DIR', dirname(__FILE__));

$file = isset($_GET['file']) ? $_GET['file'] : 'index.twg';
$ext = pathinfo($file, PATHINFO_EXTENSION);

switch ($ext)
{
case 'twg':
	require_once ROOT_DIR . '/app/Twig/Autoloader.php';
	Twig_Autoloader::register();

	$loader = new Twig_Loader_Filesystem(ROOT_DIR . '/templates');
	$twig = new Twig_Environment($loader);

	try {
		echo $twig->render($file, array('name' => 'Fabien'));
	} catch (Twig_Error_Loader $ex) {
		echo $twig->render('page.404.twg');
	}
	break;
case 'less':
	require ROOT_DIR . '/app/lessc.inc.php';

	header('Content-type: text/css');

	$less = new lessc();
	echo $less->compileFile(ROOT_DIR . '/assets/less/' . $file);
	break;
default:
	header('HTTP/1.0 404 Not Found');
	break;
}