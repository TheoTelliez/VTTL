<?php

class Commentairevttl {

    private $db;    // déclaration de la variable en privé (uniquement pour la classe) // $db c'est la variable de connection
    private $insert;
    private $select;
    private $selectLeDernier;
    private $selectLeDernier1;
    private $selectLeDernier2;
    private $selectLeDernier3;
    private $delete;

    public function __construct($db) {
        $this->db = $db;    //je parle à db dans le private et je lui donne la valeur qui est dans le __construct
        $this->insert = $db->prepare("insert into commentairevttl(titre, message, note, date, idUtilisateurvttl) values (:titre, :message, :note, :date, :idUtilisateurvttl)");
        $this->select = $db->prepare("select u.prenom as prenom, nom, email, titre, id, message, note, date from commentairevttl c, utilisateurvttl u where c.idUtilisateurvttl = u.email order by date desc");
        $this->selectLeDernier = $db->prepare("select u.prenom as prenom, nom, email, titre, id, message, note, date from commentairevttl c, utilisateurvttl u where c.idUtilisateurvttl = u.email order by date desc limit 0,1");
        $this->selectLeDernier1 = $db->prepare("select u.prenom as prenom, nom, email, titre, id, message, note, date from commentairevttl c, utilisateurvttl u where c.idUtilisateurvttl = u.email order by date desc limit 1,1");
        $this->selectLeDernier2 = $db->prepare("select u.prenom as prenom, nom, email, titre, id, message, note, date from commentairevttl c, utilisateurvttl u where c.idUtilisateurvttl = u.email order by date desc limit 2,1");
        $this->selectLeDernier3 = $db->prepare("select u.prenom as prenom, nom, email, titre, id, message, note, date from commentairevttl c, utilisateurvttl u where c.idUtilisateurvttl = u.email order by date desc limit 3,1");
        $this->delete = $db->prepare("delete from commentairevttl where id=:id");
    }

    public function insert($inputVTTCommentaireTitre, $inputVTTCommentaireMessage, $inputVTTCommentaireNote, $inputVTTCommentaireDate, $inputVTTCommentaireidUtilisateur) {
        $r = true;
        $this->insert->execute(array(':titre' => $inputVTTCommentaireTitre, ':message' => $inputVTTCommentaireMessage, ':note' => $inputVTTCommentaireNote, ':date' => $inputVTTCommentaireDate, ':idUtilisateurvttl' => $inputVTTCommentaireidUtilisateur));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectLeDernier() {
        $liste = $this->selectLeDernier->execute();
        if ($this->selectLeDernier->errorCode() != 0) {
            print_r($this->selectLeDernier->errorInfo());
        }
        return $this->selectLeDernier->fetchAll();
    }

    public function selectLeDernier1() {
        $liste = $this->selectLeDernier1->execute();
        if ($this->selectLeDernier1->errorCode() != 0) {
            print_r($this->selectLeDernier1->errorInfo());
        }
        return $this->selectLeDernier1->fetchAll();
    }

    public function selectLeDernier2() {
        $liste = $this->selectLeDernier2->execute();
        if ($this->selectLeDernier2->errorCode() != 0) {
            print_r($this->selectLeDernier2->errorInfo());
        }
        return $this->selectLeDernier2->fetchAll();
    }

    public function selectLeDernier3() {
        $liste = $this->selectLeDernier3->execute();
        if ($this->selectLeDernier3->errorCode() != 0) {
            print_r($this->selectLeDernier3->errorInfo());
        }
        return $this->selectLeDernier3->fetchAll();
    }

    public function delete($id) {
        $r = true;
        $this->delete->execute(array(':id' => $id));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

}

?>