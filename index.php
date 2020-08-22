<?php 

require_once("vendor/autoload.php"); // tras minhas dependecias do composer
use  \Slim\Slim;   // caraga a classe que preciso
use \Hcode\Page;   // carrega a classe que preciso 


$app = new Slim(); // define minha rota

$app->config('debug', true);

$app->get('/', function() {  // rota q estou chamando 
    
	
		  $page = new Page();

		  $page->setTpl("index");

});

$app->run();  //faz toda a pagina funcionar

 ?>