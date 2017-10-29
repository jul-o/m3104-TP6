<?php
  require_once("../model/DAO.class.php");
  
  $login = $_POST['login'] ?? NULL;
  $psswd = $_POST['psswd'] ?? NULL;
  if($login != NULL && $psswd != NULL){
    //afficher veuillez remplir login/mdp
      if($dao->correctPassword($login, $psswd)){
        //ouvrir une session
        session_start();
        $_SESSION['login'] = $login;

        header('Location: home.ctrl.php');
      }else{
        header('Location: login.ctrl.php?idIncorrect=1');
      }
    }else{
      header('Location: login.ctrl.php?idIncorrect=1');
    }


 ?>
