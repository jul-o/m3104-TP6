<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?=$data['titre']?></title>
  </head>
  <body>
    <h1><?=$data['titre']?></h1>
    <section class = "nouvelles">
      <?php foreach ($data['nouvelles'] as $key => $value): ?>
        <a href="<?=$value->url()?>">
          <div class="nouvelle">
            <h2><?=$value->titre()?></h2>
            <h3><?=$value->description()?></h3>
            <img src="<?="../images/".$value->nomLocalImage()?>" alt="dsl pa dimaj">
          </div>
        </a>
      <?php endforeach; ?>
    </section>
  </body>
</html>
