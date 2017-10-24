<?php
require_once("../model/RSS.class.php");
require_once("../model/Nouvelle.class.php");
require_once("../model/DAO.class.php");

$url = 'http://www.lemonde.fr/m-actu/rss_full.xml';
$rss = $dao->createRSS($url);
$nouvelles = $rss->nouvelles();
$titre = $rss->titre();

$data['titre'] = $titre;
$data['nouvelles'] = $nouvelles;
require_once('../view/RSS.view.php');
