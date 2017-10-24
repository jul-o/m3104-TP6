<?php
  require_once("../model/DAO.class.php");
  $login = $_POST['login'] ?? NULL;
  $psswd = $_POST['psswd'] ?? NULL;
  if($login != NULL && $psswd != NULL){
    if($dao->userExists($login)){
      if($dao->correctPassword($login, $psswd)){
        //ouvrir une session
        header('Location: home.ctrl.php');s
      }
    }
  }
  header('Location: login.ctrl.php');


 ?>
