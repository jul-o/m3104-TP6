<?php
  require_once("../model/DAO.class.php");
  session_start();
  $login = $_SESSION['login'];
  $urlRSS = $_POST['rss'];

  if($dao->abonnement($urlRSS, $login)){
    //header("Location: home.ctrl.php?sub-success=1");
  }else{
    //header("Location: home.ctrl.php?sub-success=0");
  }
