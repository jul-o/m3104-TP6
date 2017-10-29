<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php if ($data['sub-success'] == 1): ?>
      <p>Abonnement réussi !</p>
    <?php elseif ($data['sub-success'] == 0): ?>
      <p>Echec de l'abonnement</p>
    <?php endif ?>
    <form class="abonnement" action="abonnement.ctrl.php" method="post">
      <p>Entrer l'url d'un flux RSS auquel vous voulez vous abonner...</p>
      <input type="text" name="rss">
      <input type="submit" value="Valider">
    </form>
    <form class="abonnement" action="abonnementListe.ctrl.php" method="post">
      <p>...ou sélectionnez-en un ici</p>
      <select name="rss">
      <?php foreach ($data['fluxConnus'] as $key => $value): ?>
        <option><?=$value[0]?></option>
      <?php endforeach; ?>
      </select>
      <input type="submit" value="Valider">
    </form>
  </body>
</html>
