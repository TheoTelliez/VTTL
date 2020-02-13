<?php

class Utilisateurvttl {

    private $db;    // déclaration de la variable en privé (uniquement pour la classe) // $db c'est la variable de connection
    private $insert;
    private $connect;
    private $select;
    private $delete;
    private $selectByEmail;
    private $update;
    private $updatesansphoto;
    private $updateuniquementphoto;
    private $updateconnect;
    private $updaterecup;
    private $updatemdp;

//    private $selectByEmailPhoto;



    public function __construct($db) {  //c'est le constructeur qui s'exécute quand on fait un new UtilisateurVTTL ($utilisateurVTTL = new UtilisateurVTTL($db);) dans le controleur_utilisateur
        $this->db = $db;    //je parle à db dans le private et je lui donne la valeur qui est dans le __construct
        $this->insert = $db->prepare("insert into utilisateurvttl(email, mdp, nom, prenom, idRole, photo, dateinscription, datedernier) values (:email, :mdp, :nom, :prenom, :role, :photo, :dateinscription, :datedernier)");
        $this->connect = $db->prepare("select email, idRole, mdp from utilisateurvttl where email=:email");
        $this->select = $db->prepare("select email, id, idRole, photo, nom, prenom, dateinscription, datedernier, r.libelle as libellerole from utilisateurvttl u, rolevttl r where u.idRole = r.id order by nom");
        $this->delete = $db->prepare("delete from utilisateurvttl where utilisateurvttl.email=:email"); //requette ok
        $this->selectByEmail = $db->prepare("select email, nom, prenom, idRole, dateinscription, photo, numrecup from utilisateurvttl where email=:email");
        $this->update = $db->prepare("update utilisateurvttl set nom=:nom, prenom=:prenom, mdp=:mdp, idRole=:role, photo=:photo where email=:email");
        $this->updatesansphoto = $db->prepare("update utilisateurvttl set nom=:nom, prenom=:prenom, mdp=:mdp, idRole=:role where email=:email");
        $this->updateuniquementphoto = $db->prepare("update utilisateurvttl set photo=:photo where email=:email");
        $this->updateconnect = $db->prepare("update utilisateurvttl set datedernier=:datedernier where email=:email");
        $this->updaterecup = $db->prepare("update utilisateurvttl set daterecup=:daterecup, numrecup=:numrecup where email=:email");
        $this->updatemdp = $db->prepare("update utilisateurvttl set mdp=:mdp where email=:email");
    }

    public function insert($email, $mdp, $role, $nom, $prenom, $photo, $dateinscription, $datedernier) {
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':photo' => $photo, ':dateinscription' => $dateinscription, ':datedernier' => $datedernier));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function connect($email) {
        $unUtilisateur = $this->connect->execute(array(':email' => $email));
        if ($this->connect->errorCode() != 0) {
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function delete($email) {
        $r = true;
        $this->delete->execute(array(':email' => $email));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectByEmail($email) {
        $this->selectByEmail->execute(array(':email' => $email));
        if ($this->selectByEmail->errorCode() != 0) {
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetch();
    }

    public function update($email, $role, $nom, $prenom, $mdp, $photo) {
        $r = true;
        $this->update->execute(array(':email' => $email, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':mdp' => $mdp, ':photo' => $photo));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updatesansphoto($email, $role, $nom, $prenom, $mdp) {
        $r = true;
        $this->updatesansphoto->execute(array(':email' => $email, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':mdp' => $mdp));
        if ($this->updatesansphoto->errorCode() != 0) {
            print_r($this->updatesansphoto->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateuniquementphoto($email, $photo) {
        $r = true;
        $this->updateuniquementphoto->execute(array(':email' => $email, ':photo' => $photo));
        if ($this->updateuniquementphoto->errorCode() != 0) {
            print_r($this->updateuniquementphoto->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateconnect($email, $datedernier) {
        $r = true;
        $this->updateconnect->execute(array(':email' => $email, ':datedernier' => $datedernier));
        if ($this->updateconnect->errorCode() != 0) {
            print_r($this->updateconnect->errorInfo());
            $r = false;
        }
        return $r;
    }
        public function updaterecup($daterecup, $numrecup, $email) {
        $r = true;
        $this->updaterecup->execute(array(':daterecup' => $daterecup, ':numrecup' => $numrecup, ':email' => $email));
        if ($this->updaterecup->errorCode() != 0) {
            print_r($this->updaterecup->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updatemdp($email, $mdp) {
        $r = true;
        $this->updatemdp->execute(array(':email' => $email, ':mdp' => $mdp));
        if ($this->updatemdp->errorCode() != 0) {
            print_r($this->updatemdp->errorInfo());
            $r = false;
        }
        return $r;
    }

}

?>