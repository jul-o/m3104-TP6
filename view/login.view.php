<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Page de login pour le super site de rss c'est cool poce blô</title>
  </head>
  <body>
    <?php if($data['idIncorrect'] == 1):?>
        <div class = \"idIncorrect\">
          <p>Login ou mot de passe incorrect</p>
        </div>
    <?php endif;?>
    <div class="login">
      <form action="testLogin.ctrl.php" method="post">
        <p>login</p>
        <input type="text" name="login">
        <p>mot de passe</p>
        <!-- limiter à 8 char-->
        <input type="password" name="psswd">
        <input type="submit" name="submit" value="valider">
      </form>
    </div>



    <div class="signup">
      <p>Pas encore inscrit ?
      <a href="signup.ctrl.php">Cliquez ici</a>
      </p>
    </div>
  </body>
</html>
