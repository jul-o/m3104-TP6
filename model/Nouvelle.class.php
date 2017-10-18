<?php
  class Nouvelle {
    private $titre;   // Le titre
    private $date;    // Date de publication
    private $description; // Contenu de la nouvelle
    private $url;         // Le lien vers la ressource associée à la nouvelle
    private $urlImage;    // URL vers l'image
    private $nomLocalImage;  //Nom local de l'image
    //constructeur
    function __construct(){}

    // Fonctions getter

    function titre() {
        return $this->titre;
    }

    function date() {
        return $this->date;
    }

    function description() {
        return $this->description;
    }

    function url() {
        return $this->url;
    }

    function urlImage() {
        return $this->urlImage;
    }

    function nomLocalImage(){
        return $this->nomLocalImage;
    }

    function downloadImage($node, $nomLocal){
      $this->urlImage = $node->attributes->getNamedItem('url')->textContent;

      $this->nomLocalImage = $nomLocal.".jpg";
      file_put_contents("../images/".$this->nomLocalImage, file_get_contents($this->urlImage));
    }

    // Charge les attributs de la nouvelle avec les informations du noeud XML
    function update(DOMElement $item){
      $this->titre = $item->getElementsByTagName('title')->item(0)->textContent;
      $this->date = $item->getElementsByTagName('pubDate')->item(0)->textContent;
      $this->description = $item->getElementsByTagName('description')->item(0)->textContent;
      $this->url = $item->getElementsByTagName('link')->item(0)->textContent;
      $nodeList = $item->getElementsByTagName('enclosure');
      if($nodeList->length != 0){
        $node = $nodeList->item(0);
        $this->downloadImage($node, $this->titre);

      }else{
        $this->urlImage = "";
      }
    }
  }
