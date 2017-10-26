<?php
  require_once("../model/DAO.class.php");
  session_start();
  $login = $_SESSION['login'];
  echo"Bonjour ".$login;
  $data['sub-success'] = $_GET['sub-success'] ?? -1;

  //zone de texte pour ajouter un flux à ses abo
  require_once("../view/abonnement.view.php");

  $data['abonnements'] = $dao->getAbonnements($login);
  //affichage mosaïque des abo
  require_once("../view/home.view.php");
  //require_once("../view/home.view.php");
 ?>
