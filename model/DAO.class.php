<?php
require_once("../model/RSS.class.php");

$dao = new DAO();

class DAO {
  private $db; // L'objet de la base de donnée

  // Ouverture de la base de donnée
  function __construct() {
    $dsn = 'sqlite:../model/data/db/rss.db'; // Data source name
    try {
      $this->db = new PDO($dsn);
    } catch (PDOException $e) {
      exit("Erreur ouverture BD : ".$e->getMessage());
    }
  }
  //////////////////////////////////////////////////////////
  // Methodes CRUD sur RSS
  //////////////////////////////////////////////////////////

  // Crée un nouveau flux à partir d'une URL
  // Si le flux existe déjà on ne le crée pas
  function createRSS($url) {
    $rss = $this->readRSSfromURL($url);
    if ($rss == NULL) {
      try {
        $q = "INSERT INTO RSS (url) VALUES ('$url')";
        $r = $this->db->exec($q);
        if ($r == 0) {
          die("createRSS error: no rss inserted\n");
        }
        return $this->readRSSfromURL($url);
      } catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
      }
    } else {
      // Retourne l'objet existant
      return $rss;
    }
  }

  // Acces à un objet RSS à partir de son URL
  function readRSSfromURL($url) {
    $rss = new RSS($url);
    $rss->update();
    return $rss;
  }

  // Met à jour un flux
  function updateRSS(RSS $rss) {
    // Met à jour uniquement le titre et la date
    $titre = $this->db->quote($rss->titre());
    $q = "UPDATE RSS SET titre=$titre, date='".$rss->date()."' WHERE url='".$rss->url()."'";
    try {
      $r = $this->db->exec($q);
      if ($r == 0) {
        die("updateRSS error: no rss updated\n");
      }
    } catch (PDOException $e) {
      die("PDO Error :".$e->getMessage());
    }
  }

  //////////////////////////////////////////////////////////
  // Methodes CRUD sur Nouvelle
  //////////////////////////////////////////////////////////

  // Acces à une nouvelle à partir de son titre et l'ID du flux
  function readNouvellefromTitre($titre,$RSS_id) {
    $query = "select * from RSS where id = :RSS_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(array(":RSS_id" => $RSS_id));
    $rss = $stmt->fetch(PDO::FETCH_CLASS, "RSS");

    $rss->update();
    $this->updateRSS($rss);

    foreach ($rss->nouvelles() as $key => $value) {
      if($value->titre() == $titre){
        return $value;
      }
    }


  }

  // Crée une nouvelle dans la base à partir d'un objet nouvelle
  // et de l'id du flux auquelle elle appartient
  function createNouvelle(Nouvelle $n, $RSS_id) {
    $titre = $n->titre();
    $date = $n->date();
    $description = $n->description();
    $url = $n->url();
    $image = $n->nomLocalImage();

    $query = "insert into nouvelle values :date, :titre, :description, :url, :image, :RSS_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(array(":date" => $date,
                         ":titre" => $titre,
                         ":RSS_id" => $RSS_id,
                         ":description" => $description,
                         ":url" => $url,
                         ":image" => $image));
  }

  /**
   * vérifie que le login est dans les utilisateurs de la BD
   * @param  [type] $nom [description]
   * @return bool        true si il y est, false sinon
   */
  function userExists($nom): bool{

  }
}