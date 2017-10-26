<?php
  require_once("../model/DAO.class.php");
  session_start();
  $login = $_SESSION['login'];
  $nomRSS = $_POST['rss'] ?? 0;
  $url = $dao->getURLRSSFromName($nomRSS);
  $dao->abonnement($url, $login);
  header("Location: home.ctrl.php");
