<?php 

session_start();


require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;  

$app = new Slim();

$app->config('debug', true);

//rota raiz
$app->get('/', function() {
    
    $page = new Page();
    $page->setTpl("index");
});

//rota da pagina admin
$app->get('/admin', function() {
    
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});

//rota da página login
$app->get('/admin/login', function(){

    User::verifySession();

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl("login");
});

//rota POST login
$app->post('/admin/login', function(){
   
    User::login($_POST["login"], $_POST["password"]);

    header("location: /admin");
    exit;
});

$app->get('/admin/logout', function(){
    User::logout();
    header("Location: /admin/login");
    exit;
});


$app->run();

 ?>