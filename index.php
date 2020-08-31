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

$app->get("/admin/users", function() {

	User::verifyLogin();

	$users = User::listALL();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));



});

$app->get("/admin/users/create", function(){ 
	
	User::verifyLogin();

	$page = new PageAdmin();
	
	$page->setTpl("users-create");
	
	});

	
	$app->get("/admin/users/:idusers/delete", function($idusers){

        User::verifyLogin();


	}); 

	$app->get("/admin/users/:iduser", function($iduser){ 
	
		User::verifyLogin();
		$user = new User();
 
		$user->get((int)$iduser);
	    $page = new PageAdmin();
		$page ->setTpl("users-update", array(
			"user"=>$user->getValues()
		));

	});

	$app->post("/admin/users/create", function(){

        User::verifyLogin();
		
		$user = new User();
		$_POST["inadmin"]= (isset($_POST["inadmin"]))?1:0;
		
		$user->setData($_POST);

		$user->save();

		header("Location: /admin/users");
		exit;

	}); 


	$app->post("admin/users/:idusers", function($idusers){

        User::verifyLogin();


	}); 






$app->run();  //faz toda a pagina funcionar

 ?>