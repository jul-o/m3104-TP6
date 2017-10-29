<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?=$data['titre']?></title>
    <link rel="stylesheet" href="../css/RSS.view.css">
  </head>
  <body>
    <header>
      <a href="home.ctrl.php"><img src="../model/data/images/home.png"></a>
    </header>
    <h1><?=$data['titre']?></h1>
    <section class = "nouvelles">
      <?php foreach ($data['nouvelles'] as $key => $value): ?>
        <a href="<?=$value->url()?>">
          <div class="nouvelle">
            <h2><?=$value->titre()?></h2>
            <img src="<?="../model/data/images/".$value->nomLocalImage()?>" alt="Image non disponible">
          </div>
        </a>
      <?php endforeach; ?>
    </section>
  </body>
</html>
