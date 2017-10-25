<?php
  session_start();
  $login = $_SESSION['login'];
  $urlRSS = $_POST['rss'];

  if($dao->abonnement($urlRSS)){
    //continuer
  }
