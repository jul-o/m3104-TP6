<?php
require_once("../model/RSS.class.php");
require_once("../model/Nouvelle.class.php");
require_once("../model/DAO.class.php");

$id = $_GET['id'] ?? 0;
if ($id){
  $rss = $dao->getRSS($id);
  $rss->fullUpdate();
  $nouvelles = $rss->nouvelles();
  $titre = $rss->titre();

  $data['titre'] = $titre;
  $data['nouvelles'] = $nouvelles;
  require_once('../view/RSS.view.php');
}
else{
  echo"pas de flux trouvé";
}
