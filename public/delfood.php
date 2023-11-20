<?php
session_start();
require_once("../app/classes/carFood.php");
var_dump($_GET['delcar']);
if($_GET['delfood'] != ""){

$alimento = filter_input(INPUT_GET,"delfood");


$cart = new CarFood();
$cart->remove($alimento);

}

if(isset($_GET['delcar']) ){

$cart = new CarFood();
$cart->clear();

}
header("Location: http://localhost/carfood-3/public/");