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

    function fileExists($url){
      $F=@fopen($urlRSS,"r");
      if($F){
        fclose($F);
        return true;
      }else {
        return false;
      }
    }

    /**
     * Télécharge sur le serveur l'image d'une nouvelle à partir
     * @param  du noeud père $node
     * @param  et du nom local donné à l'image $nomLocal
     */
    function downloadImage($node, $nomLocal){
      $this->urlImage = $node->attributes->getNamedItem('url')->textContent;
      $this->nomLocalImage = $nomLocal.".jpg";

      //obligé de télécharger l'image dans tous les cas, pas d'update sinon
      if(!file_exists("../images/".$this->nomLocalImage)){
        file_put_contents("../images/".$this->nomLocalImage, file_get_contents($this->urlImage));
      }
    }

    function update(DOMElement $item){
      $this->titre = $item->getElementsByTagName('title')->item(0)->textContent;               //titre mis à jour
      $this->date = $item->getElementsByTagName('pubDate')->item(0)->textContent;              //date de publication mise à jour
      $this->description = $item->getElementsByTagName('description')->item(0)->textContent;   //description mis à jour
      $this->url = $item->getElementsByTagName('link')->item(0)->textContent;                  //lien de la nouvelle mis à jour
      $nodeList = $item->getElementsByTagName('enclosure');
    }

    // Charge les attributs de la nouvelle avec les informations du noeud XML
    /**
     * Met à jour les attributs de la nouvelle à partir
     * @param  du noeud XML DOMElement $item
     * et télécharge les images localement
     */
    function fullUpdate(DOMElement $item, $titreRSS, $numImage){
      $this->titre = $item->getElementsByTagName('title')->item(0)->textContent;               //titre mis à jour
      $this->date = $item->getElementsByTagName('pubDate')->item(0)->textContent;              //date de publication mise à jour
      $this->description = $item->getElementsByTagName('description')->item(0)->textContent;   //description mis à jour
      $this->url = $item->getElementsByTagName('link')->item(0)->textContent;                  //lien de la nouvelle mis à jour
      $nodeList = $item->getElementsByTagName('enclosure');                                    //
      if($nodeList->length != 0){                                                              //si il y a une "feuille"
        $node = $nodeList->item(0);
        //$nomLocal = $titreRSS.$numImage;
        $nomLocal = $this->titre;
                                                                  //télécharge une image et met à jour l'url image
        $this->downloadImage($node, $nomLocal);                                             //

      }else{                                                                                   //
        $this->urlImage = "";                                                                  //sinon met l'url image à vide
      }
    }
  }
