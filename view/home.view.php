<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Flux</title>
  </head>
  <body>
    <div id = abonnements>
    <?php foreach ($data['abonnements'] as $key => $value): ?>
      <div class="abonnement">
        <a href="RSS.ctrl.php?id=<?=$dao->getRSSID($value)?>"><img src="../images/<?=$value->nouvelles()[0]->nomLocalImage()?>" alt="<?=$value->titre()?>">
        <h2><?=$value->titre()?></h2></a>
        <a href="unsub.ctrl.php?id=<?=$dao->getRSSID($value)?>"><p>Se désabonner</p></a>
        <hr>
      </div>
    <?php endforeach ?>
    </div>
  </body>
</html>
