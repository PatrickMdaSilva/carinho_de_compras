<?php
session_start();
require_once("../app/classes/carFood.php");

if($_GET['food'] != ""){

$food = filter_input(INPUT_GET,"food");
$range = filter_input(INPUT_GET,"rangeInput");

$values = explode('|',$food);

$id = $values[1];
$alimento = $values[2];
$kcal = ($values[3] != "") ? ($values[3] / 100) * $range : $kcal = (0 / 100) * $range ;
$proteina = ($values[4] != "") ? ($values[4] / 100) * $range : $kcal = (0 / 100) * $range ;
$lipideo = ($values[5] != "") ? ($values[5] / 100) * $range : $kcal = (0 / 100) * $range ;
$carbohidrato = ($values[6] != "") ? ($values[6] / 100) * $range : $kcal = (0 / 100) * $range ;


$cart = new CarFood();
$cart->add($alimento, $kcal, $proteina, $lipideo, $carbohidrato);

}
header("Location: http://localhost/carfood-3/public/");



