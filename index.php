<?php 

session_start();
require_once("vendor/autoload.php"); // tras minhas dependecias do composer
use  \Slim\Slim;   // caraga a classe que preciso
use \Hcode\Page;   // carrega a classe que preciso 
use  \Hcode\PageAdmin;
use  \Hcode\Model\User;


$app = new Slim(); // define minha rota

$app->config('debug', true);

$app->get('/', function() {  // rota q estou chamando  para pagina 
    
	
		  $page = new Page();

		  $page->setTpl("index");

});

$app->get('/admin', function() {  // rota q estou chamando para admin
    
	User::verifyLogin();
	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {  // rota q estou chamando para loing
    
	
	$page = new PageAdmin([   
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){  // recebendo o post com as inforçãp de senha e login

	User::login($_POST["login"], $_POST["password"]);   /* criacção do metedo statico para validação o metetdo statico recebe login e senha */
	 header("location: /admin");  // redirecionando a pagina
	 
	 exit;

    // lembrando que tem que cria a classe 

});

$app->get('/admin/logout/', function(){

User::logout();
header("Location: /admin/login");
exit;

});




$app->run();  //faz toda a pagina funcionar

 ?>