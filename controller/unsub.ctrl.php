<?php
  require_once("../model/DAO.class.php");
  session_start();
  $login = $_SESSION['login'];
  $rssID = $_GET['id'] ?? 0;

  $dao->unsub($login, $rssID);

  header("Location: home.ctrl.php");
