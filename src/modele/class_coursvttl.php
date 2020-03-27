<?php

class Cours {

    private $db;
    private $select;
    private $insert;
    private $selectLimit;
    private $selectCount;
    private $selectByIdcours;
    private $updatecours;
    private $rechercher;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select c.idcours, c.titre, c.iddifficulte, c.dateajout, c.datedernieremodif, c.photo, d.libelle as libelledifficulte,"
                . " c.auteur as auteur, u.nom as nom, u.prenom from cours c, difficulte d, utilisateurvttl u where d.id = c.iddifficulte "
                . "and c.auteur = u.email order by c.iddifficulte");
        $this->insert = $db->prepare("insert into cours(titre, iddifficulte, dateajout, datedernieremodif, auteur) values (:titre, :iddifficulte, :dateajout, :datedernieremodif, :auteur)");
        $this->selectLimit = $db->prepare("select c.idcours, c.titre, c.iddifficulte, c.dateajout, c.datedernieremodif, c.photo, d.libelle as libelledifficulte,"
                . " c.auteur as auteur, u.nom as nom, u.prenom from cours c, difficulte d, utilisateurvttl u where d.id = c.iddifficulte "
                . "and c.auteur = u.email order by c.iddifficulte limit :inf,:limite");
        $this->selectCount = $db->prepare("select count(*) as nb from cours");
        $this->deletecours = $db->prepare("delete from cours where idcours=:id");
        $this->deletesection = $db->prepare("delete from section where idcours=:id");
        $this->selectByIdcours = $db->prepare("select c.idcours, c.titre, c.iddifficulte, c.dateajout, c.datedernieremodif, c.photo, d.libelle as libelledifficulte, c.auteur as auteur, u.nom as nom, u.prenom from cours c, difficulte d, utilisateurvttl u where idcours = :idcours and d.id = c.iddifficulte and c.auteur = u.email order by c.iddifficulte");
        $this->updatecours = $db->prepare("update cours set titre=:titre, iddifficulte=:iddifficulte, datedernieremodif=:datedernieremodif where idcours=:idcours");
        $this->rechercher = $db->prepare("select c.idcours, c.titre, c.iddifficulte, c.dateajout, c.datedernieremodif, c.photo, d.libelle as libelledifficulte, c.auteur as auteur, u.nom as nom, u.prenom from cours c, difficulte d, utilisateurvttl u where c.titre like :recherche and d.id = c.iddifficulte and c.auteur = u.email order by c.iddifficulte");
    }

    public function select() {
        $listecours = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($inputTitre, $difficultecours, $dateajout, $datedernieremodif, $auteur) {
        $r = true;
        $this->insert->execute(array(':titre' => $inputTitre, ':iddifficulte' => $difficultecours, ':dateajout' => $dateajout, ':datedernieremodif' => $datedernieremodif, ':auteur' => $auteur));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectLimit($inf, $limite) {
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode() != 0) {
            print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }

    public function selectCount() {
        $this->selectCount->execute();
        if ($this->selectCount->errorCode() != 0) {
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    }

    public function deletecours($id) {
        $r = true;
        $this->deletecours->execute(array(':id' => $id));
        if ($this->deletecours->errorCode() != 0) {
            print_r($this->deletecours->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function deletesection($id) {
        $r = true;
        $this->deletesection->execute(array(':id' => $id));
        if ($this->deletesection->errorCode() != 0) {
            print_r($this->deletesection->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectByIdcours($idcours) {
        $this->selectByIdcours->execute(array(':idcours' => $idcours));
        if ($this->selectByIdcours->errorCode() != 0) {
            print_r($this->selectByIdcours->errorInfo());
        }
        return $this->selectByIdcours->fetch();
    }

    public function updatecours($inputModifTitre, $modifdifficultecours, $datedernieremodif, $idcours) {
        $r = true;
        $this->updatecours->execute(array(':titre' => $inputModifTitre, ':iddifficulte' => $modifdifficultecours, ':datedernieremodif' => $datedernieremodif, ':idcours' => $idcours));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->updatecours->errorCode() != 0) {
            print_r($this->updatecours->errorInfo());
            $r = false;
        }
        return $r; 
    }

    public function rechercher($recherche) {
        $listerecherchecours = $this->rechercher->execute(array(':recherche' => '%' . $recherche . '%'));
        if ($this->rechercher->errorCode() != 0) {
            print_r($this->rechercher->errorInfo());
        }
        return $this->rechercher->fetchAll();
    }

}

?>