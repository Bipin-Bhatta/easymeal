<?php
session_start();
//include('../database.inc.php');
include('function.inc.php');
//include('../constant.inc.php');
unset($_SESSION['FOOD_USER_ID']);
unset($_SESSION['FOOD_USER_NAME']);
redirect('shop');

?>
