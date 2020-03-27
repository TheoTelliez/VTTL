<?php

class Contactvttl {

    private $db;    // déclaration de la variable en privé (uniquement pour la classe) // $db c'est la variable de connection
    private $insert;
    private $select;
    private $delete;
    private $rechercher;

    public function __construct($db) {  //c'est le constructeur qui s'exécute quand on fait un new Contact ($contact = new Contact($db);) dans le controleur_contact
        $this->db = $db;    //je parle à db dans le private et je lui donne la valeur qui est dans le __construct
        $this->insert = $db->prepare("insert into contactvttl(nom, prenom, email, date, message) values (:nom, :prenom, :email, :date, :message)");
        $this->select = $db->prepare("select id, nom, prenom, email, date, message from contactvttl order by date"); //pas de desc sinon les plus récent apparait et c'est pas logique parce que les plus anciens messages doivent être traités avant les nouveaux !
        $this->delete = $db->prepare("delete from contactvttl where id=:id");
        $this->rechercher = $db->prepare("select id, nom, prenom, email, date, message from contactvttl where message like :recherche order by date");
    }

    public function insert($inputVTTContactNom, $inputVTTContactPrenom, $inputVTTContactEmail, $inputVTTContactDate, $inputVTTContactMessage) {
        $r = true;
        $this->insert->execute(array(':nom' => $inputVTTContactNom, ':prenom' => $inputVTTContactPrenom, ':email' => $inputVTTContactEmail, ':date' => $inputVTTContactDate, ':message' => $inputVTTContactMessage));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
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

    public function delete($id) {
        $r = true;
        $this->delete->execute(array(':id' => $id));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function rechercher($recherche) {
        $listerecherchecontact = $this->rechercher->execute(array(':recherche' => '%' . $recherche . '%'));
        if ($this->rechercher->errorCode() != 0) {
            print_r($this->rechercher->errorInfo());
        }
        return $this->rechercher->fetchAll();
    }

}

?>