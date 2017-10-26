<?php
  require_once("../model/DAO.class.php");
  $login = $_POST['login'] ?? NULL;
  $mp = $_POST['psswd'] ?? NULL;


  if ($login!=NULL && $mp!=NULL){
    //le mot de passe ne dépasse pas 8 caractères
    if(strlen($mp) <= 8){
      //le login n'existe pas dans la BD
      if(!$dao->loginExists($login)){
        $dao->inscription($login, $mp);

        //on ouvre une session
        session_start();
        $_SESSION['login'] = $login;
        header('Location: home.ctrl.php');
      } else {
        header('Location: signup.ctrl.php?loginExist=1');
      }
    } else {
        header('Location: signup.ctrl.php?mdplong=1');
    }
  } else {
    header('Location: signup.ctrl.php?idIncorrect=1');
  }

 ?>
