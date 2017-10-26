<?php
  $data['idIncorrect'] = $_GET['idIncorrect'] ?? 0;
  $data['mdplong'] = $_GET['mdplong'] ?? 0;
  $data['loginExist'] = $_GET['loginExist'] ?? 0;
  require_once("../view/signup.view.php");
 ?>
