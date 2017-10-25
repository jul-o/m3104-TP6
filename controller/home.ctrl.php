<?php
  session_start();
  echo"Bonjour ".$_SESSION['login'];

  //zone de texte pour ajouter un flux à ses abo
  require_once("../view/abonnement.view.php");

  //affichage mosaïque des abo
  require_once("../view/home.view.php");
  //require_once("../view/home.view.php");
 ?>
