<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Flux</title>
  </head>
  <body>
    <?php foreach ($data['abonnements'] as $key => $value): ?>
      <?php var_dump("../images/".$value->nouvelles()[0]->nomLocalImage()); ?>
      <a href="RSS.ctrl.php?id=<?=$dao->getRSSID($value)?>"><img src="../images/<?=$value->nouvelles()[0]->nomLocalImage()?>" alt="<?=$value->titre()?>">
      <h2><?=$value->titre()?></h2></a>
      <hr>
    <?php endforeach ?>
  </body>
</html>
