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

//GET Tela da pagina admin
$app->get('/admin', function() {
    
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});

//GET Tela da página login
$app->get('/admin/login', function(){

    User::verifySession();

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl("login");
});

//POST Login
$app->post('/admin/login', function(){
   
    User::login($_POST["login"], $_POST["password"]);

    header("location: /admin");
    exit;
});

//GET Logout
$app->get('/admin/logout', function(){
    User::logout();
    header("Location: /admin/login");
    exit;
});


//GET QUE Lista todos os usuários
$app->get('/admin/users', function(){

    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("users");
});

//GET que Cria os usuários
$app->get('/admin/users/create', function(){

    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("users-create");
});


//GET QUE Lista todos os usuários
$app->get('/admin/users', function(){

    User::verifyLogin();

    User::listAll();

    $page = new PageAdmin();

    $page->setTpl("users", array(
    	"users"=>$users
    ));
});

//GET Deletar o usuário
$app->get('/admin/users/:iduser/delete', function($iduser){

    User::verifyLogin();

});

//Get Edita Usuário
$app->get('/admin/users/:iduser', function($iduser){

    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("users-update");
});

//POST criar usários
$app->post('/admin/users/create', function($iduser){

    User::verifyLogin();
   
});


//POST Edita Usuário
$app->post('/admin/users/:iduser', function($iduser){

    User::verifyLogin();

});





$app->run();

 ?>