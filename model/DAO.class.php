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

  function rssConnu($url): bool{
    $query = "select url from rss where url = :url";
    $stmt = $this->db->prepare($query);
    $stmt->execute(array(":url" => $url));
    $tab = $stmt->fetchAll(PDO::FETCH_NUM);
    return isset($tab[0]);
  }

  //méthode réadaptée car ne faisait pas ce qu'il fallait
  // Crée un nouveau flux à partir d'une URL et l'insère dans la BD
  // Si le flux existe déjà on ne le crée pas
  function createRSS($url): RSS {
    $rss = $this->readRSSfromURL($url);
    if(!$this->rssConnu($url)){
      $query = "insert into rss (titre, url, date) values (:titre, :url, :date)";
      $stmt = $this->db->prepare($query);
      $stmt->execute(array(":titre" => $rss->titre(),
                           ":url" => $url,
                           ":date" => $rss->date()));

    }
    return $rss;
  }

  // Acces à un objet RSS à partir de son URL
  // renvoi le flux RSS après sa mise à jour
  function readRSSfromURL($url) {
    $rss = new RSS($url);
    $rss->update();
    return $rss;
  }


  // Met à jour un flux RSS donné
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

  function getRSSID($rss): int{
    $req = "select id from rss where url = :url and date = :date";
    $stmt = $this->db->prepare($req);
    $stmt->execute(array(":url" => $rss->url(),
                         ":date" => $rss->date()));
    $tab = $stmt->fetchAll(PDO::FETCH_NUM);
    return $tab[0][0];
  }

  function getRSS($id): RSS{
    $req = "select url from rss where id = :id";
    $stmt = $this->db->prepare($req);
    $stmt->execute(array(":id" => $id));
    $tab = $stmt->fetch(PDO::FETCH_NUM);
    $rss = $this->readRSSfromURL($tab[0]);
    return $rss;
  }

  //////////////////////////////////////////////////////////
  // Methodes CRUD sur Nouvelle
  //////////////////////////////////////////////////////////

  /**
   * Renvoie une nouvelle à partir d'un titre et de l'id RSS
   * @param   $titre  titre de la nouvelle recherchée
   * @param   $RSS_id identifiant du flux RSS où se trouve la nouvelle
   * @return la nouvelle définie précédemment
   */
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

  /**
   * Ajoute une nouvelle dans la BD à partir
   * @param  de l'objet Nouvelle $n
   * @param  et de l'identifiant du flux RSS correspondant
   */
  function createNouvelle(Nouvelle $n, $RSS_id) {
    $titre = $n->titre();
    $date = $n->date();
    $description = $n->description();
    $url = $n->url();
    $image = $n->nomLocalImage();

    $query = "insert into nouvelle values (:date, :titre, :description, :url, :image, :RSS_id)";
    $stmt = $this->db->prepare($query);
    $stmt->execute(array(":date" => $date,
                         ":titre" => $titre,
                         ":RSS_id" => $RSS_id,
                         ":description" => $description,
                         ":url" => $url,
                         ":image" => $image));
  }

  function loginExists($nom){
    $query = "SELECT login from utilisateur where login = :nom";
    $stmt=$this->db->prepare($query);
    $stmt->execute(array(":nom" => $nom));
    $tab = $stmt->fetchAll(PDO::FETCH_NUM);
    return isset($tab[0]);
  }

  /**
   * vérifie que le login est dans les utilisateurs de la BD
   * @param  $nom le login entré
   * @return bool true si il y est, false sinon
   */
  function correctPassword($nom, $psswd){
    $query = "select login from utilisateur where login = :nom and mp = :psswd";
    $stmt = $this->db->prepare($query);
    $stmt->execute(array(":nom" => $nom,
                         ":psswd" => $psswd));
    $tab = $stmt->fetchAll(PDO::FETCH_NUM);
    return (isset($tab[0]));
  }

  function inscription($nom, $mp){
    $query = "INSERT INTO utilisateur VALUES (:login, :mp)";
    $stmt = $this->db->prepare($query);
    $stmt->execute(array(":login" => $nom,
                         ":mp" => $mp));
  }

  /** A ameliorer pour prevenir si l'abonnement est déjà fait
   * Vérifie qu'un flux existe et l'ajoute à la liste des abonnements
   * @param  string $urlRSS url du flux
   * @param  string $login  login
   * @return bool           abo réussi
   */
  function abonnement($urlRSS, $login): bool{
    if($this->urlExists($urlRSS)){
      $rss = $this->createRSS($urlRSS);

      $rssID = $this->getRSSID($rss);
      $titre = $rss->titre();

      $req = "insert into abonnement values (:login, :rssID, :titre, null)";
      $stmt = $this->db->prepare($req);
      $stmt->execute(array(":login" => $login,
                           ":rssID" => $rssID,
                           ":titre" => $titre));

      return true;
    }
    return false;
  }

  /**
   * Vérifie qu'un url existe
   * @param  [string] $urlRSS [url à vérifier]
   * @return [bool]
   */
  function urlExists($urlRSS): bool{
    $F=@fopen($urlRSS,"r");

    if($F){
      fclose($F);
      return true;
    }else {
      return false;
    }
  }

  /**
   * Retourne un tableau d'objects RSS correspondant aux abonnement de $login
   * @param  [string] $login [login de l'utilisateur]
   * @return [array<RSS>]        [RSS correspondant aux abo]
   */
  function getAbonnements($login){
    $req = "select RSS_id from abonnement where utilisateur_login = :login";
    $stmt = $this->db->prepare($req);
    $stmt->execute(array(":login" => $login));
    $tab = $stmt->fetchAll(PDO::FETCH_NUM);
    foreach ($tab as $key => $value) {
      //méthode à créer
      $rss = $this->getRSS($value[0]);
      $tabRSS[] = $rss;
    }
    return $tabRSS ?? array();
  }

  /**
   * désabonne l'utilisateur de login $login du flux d'id $rssID
   * @param  [string] $login [login de l'utilisateur]
   * @param  [string] $rssID [id du RSS duquel se désabonner]
   */
  function unsub($login, $rssID){
    $req = "delete from abonnement where utilisateur_login = :login and RSS_id = :rssID";
    $stmt = $this->db->prepare($req);
    $stmt->execute(array(":login" => $login,
                         ":rssID" => $rssID));

  }
}
