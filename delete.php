<?php



require_once 'core/init.php';

$user = new User();

var_dump($_GET);

if(!$user->hasPermission()->first()->id == 3){
    Redirect::to('index.php');
} else {
    DB::getInstance()->delete("users", array(
       "id", "=", $_GET['id']
    ));
}