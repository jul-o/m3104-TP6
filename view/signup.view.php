<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
  </head>
  <body>
    <h1>Créez vos identifiants</h1>
    <?php if($data['idIncorrect']):?>
      <div class="idIncorrect">
          <p>Le login ou le mot de passe est absent</p>
      </div>
    <?php endif; ?>

    <?php if($data['mdplong']):?>
      <div class="mdplong">
          <p>Le mot de passe est trop long (limité à 8 caractères)</p>
      </div>
    <?php endif; ?>

    <?php if($data['loginExist']):?>
      <div class="loginExist">
          <p>Ce nom d'utilisateur existe déjà</p>
      </div>
    <?php endif; ?>
    <form class="signup" action="testSignup.ctrl.php" method="post">
      <p>Login</p>
      <input type="text" name="login">
      <p>Mot de passe</p>
      <input type="password" name="psswd">
      <input type="submit" name="submit" value="Valider">
    </form>
  </body>
</html>
