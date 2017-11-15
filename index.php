<?php
session_start();

/*----------REQUIRE APP--------------*/
require 'app/Config/config.php';
use \App\Model\User;
use \App\Form\FormType;
use \App\Controller\Database;
use \App\Controller\Controller;
use \App\Autoloader;
require 'app/Autoloader.php';
require_once 'vendor/autoload.php';

/*----------CONFIG APP---------------*/
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
	'debug' => true
));
$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new Twig_Extension_Debug());

/*----------DATABASE / CONTROLLER----*/
Autoloader::register();
$db = Database::getInstance();
$dao = new Controller($db);

/*----------ROUTING------------------*/
if (!isset($_GET['page'])) {
	$page = 'home';
}
else{
	$page = trim(htmlentities($_GET['page']));
} 

if(isset($page) AND $page=='home') {

	$listeUsers = $dao->queryUsers();
	$template = $twig->load('core/home.html.twig');
	echo $template->render(array('users' => $listeUsers));
}
elseif (isset($page) AND $page=='blog') {
	$template = $twig->load('blog/blog.html.twig');
	echo $template->render();
}
elseif (isset($page) AND $page=='contact') {

	$form = new FormType();

	$form->setInputList(array(
		0 =>['type'=>'textarea','name'=>'name','placeholder'=>'name','value'=>null, 'required'=>true,'class'=>'form-control','id'=>null],
		1 =>['type'=>'text','name'=>'age','placeholder'=>'age','value'=>null, 'required'=>true,'class'=>'form-control col-xs-6','id'=>null]
	));

	if (!empty($_POST)) {
		if ($_SESSION['token'] == $_POST['_token']) {
			$user = new User();
			$user->setName($_POST['name']);
			$user->setAge($_POST['age']);

			$dao->newUser($user);

			$flashMessage = 'Ajouté!';
			$template = $twig->load('core/contact.html.twig');
			echo $template->render(array(
				'form'=>$form,
				'flashMessage'=>$flashMessage
			));
			$_SESSION['token'] = [];
		}
		else
		{
			header('Location:?page=contact');
		}
	}else{
		$template = $twig->load('core/contact.html.twig');
		$_SESSION['token'] = $form->getTokenValue();
		echo $template->render(array(
			'form'=>$form
		));		
	}
}
else{
	$template = $twig->load('error/404.html.twig');
	echo $template->render(array(
		'page'=>$page
	));
}
