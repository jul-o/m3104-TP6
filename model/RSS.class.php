<?php
require_once("Nouvelle.class.php");
class RSS {
  private $titre; // Titre du flux
  private $url;   // Chemin URL pour télécharger un nouvel état du flux
  private $date;  // Date du dernier téléchargement du flux
  private $nouvelles; // Liste des nouvelles du flux dans un tableau d'objets Nouvelle

  // Contructeur
  function __construct($url) {
    $this->url = $url;
  }

  // Fonctions getter

  function titre() {
    return $this->titre;
  }

  function url() {
    return $this->url;
  }

  function date() {
    return $this->date;
  }

  function nouvelles() {
    return $this->nouvelles;
  }

  // Récupère un flux RSS à partir de son URL
  function update(){
    // Crée un document XML pour accueillir le contenu du RSS
    $doc = new DOMDocument;

    //Telecharge le fichier XML dans $rss
    $doc->load($this->url);

    // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
    $nodeList = $doc->getElementsByTagName('title');

    // Met à jour le titre dans l'objet
    $this->titre = $nodeList->item(0)->textContent;

    //Met à jour de la Date de mise à jour du flux
    $this->date = date('Y-m-d');

    //Mise à jour des nouvelles du flux
    $items = $doc->getElementsByTagName("item");
    $this->nouvelles = array();

    //supprime les images local du précédant flux
    /*$mask = "../images/*";
    array_map("unlink", glob($mask));*/

  //Crée et met à jour les nouvelles à partir du flux
    foreach ($items as $key => $value) {
      $nouvelle = new Nouvelle();
      $nouvelle->update($value);
      $this->nouvelles[] = $nouvelle;
    }
  }
}
