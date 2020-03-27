<?php

class Section {

    private $db;
    private $select;
    private $insert;
    private $selectByIdcours;
    private $updatesection;
    private $deletesection;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select s.idsection, s.soustitre, s.contenu, s.idcours from section s, cours c where s.idcours = c.idcours");
        $this->insert = $db->prepare("insert into section(soustitre, contenu, idcours) values (:soustitre, :contenu, :idcours)");
        $this->selectByIdcours = $db->prepare("select idsoustitre, idcours, contenu, soustitre from section where idcours = :idcours");
        $this->updatesection = $db->prepare("update section set contenu=:contenu, soustitre=:soustitre where idsoustitre=:idsoustitre");
        $this->deletesection = $db->prepare("delete from section where idsoustitre=:idsoustitre");
    }

    public function select() {
        $listesections = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($inputSousTitre, $inputContenu, $idcours) { //Pas fini ici attention attention attention attention attention attention
        $r = true;
        $this->insert->execute(array(':soustitre' => $inputSousTitre, ':contenu' => $inputContenu, ':idcours' => $idcours));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectByIdcours($idcours) {
        $this->selectByIdcours->execute(array(':idcours' => $idcours));
        if ($this->selectByIdcours->errorCode() != 0) {
            print_r($this->selectByIdcours->errorInfo());
        }
        return $this->selectByIdcours->fetchAll();
    }

    public function updatesection($idsoustitre, $inputModifSousTitre, $inputModifContenu) { //ATTENTION ICI CE N'EST PAS FINI (MAJ : 11/03/2020) ! 
        $r = true;
        $this->updatesection->execute(array(':idsoustitre' => $idsoustitre, ':soustitre' => $inputModifSousTitre, ':contenu' => $inputModifContenu));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->updatesection->errorCode() != 0) {
            print_r($this->updatesection->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function deletesection($idsoustitre) {
        $r = true;
        $this->deletesection->execute(array(':idsoustitre' => $idsoustitre));
        if ($this->deletesection->errorCode() != 0) {
            print_r($this->deletesection->errorInfo());
            $r = false;
        }
        return $r;
    }

}

?>