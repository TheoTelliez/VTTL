<?php

class Difficulte {

    private $db;
    private $select;
    private $insert;
    private $selectByIdDifficulte;
    private $update;
    private $delete;
    private $selectLimit;
    private $selectCount;
    private $rechercher;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into difficulte (libelle)values(:libelle)");
        $this->select = $db->prepare("select id, libelle from difficulte order by id");
        $this->selectByIdDifficulte = $db->prepare("select libelle, id from difficulte where id=:id");
        $this->update = $db->prepare("update difficulte set libelle=:libelle where id=:id");
        $this->delete = $db->prepare("delete from difficulte where id=:id");
        $this->selectLimit = $db->prepare("select id, libelle from difficulte order by id limit :inf,:limite");
        $this->selectCount = $db->prepare("select count(*) as nb from difficulte");
        $this->rechercher = $db->prepare("select id, libelle from difficulte where difficulte.libelle like :recherche order by id");
    }

    public function insert($inputDifficulte) {
        $r = true;
        $this->insert->execute(array(':libelle' => $inputDifficulte));
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

    public function selectByIdDifficulte($id) {
        $this->selectByIdDifficulte->execute(array(':id' => $id));
        if ($this->selectByIdDifficulte->errorCode() != 0) {
            print_r($this->selectByIdDifficulte->errorInfo());
        }
        return $this->selectByIdDifficulte->fetch();
    }

    public function update($id, $libelle) {
        $r = true;
        $this->update->execute(array(':id' => $id, ':libelle' => $libelle));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
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

    public function rechercher($recherche) {
        $listerecherchedifficulte = $this->rechercher->execute(array(':recherche' => '%' . $recherche . '%'));
        if ($this->rechercher->errorCode() != 0) {
            print_r($this->rechercher->errorInfo());
        }
        return $this->rechercher->fetchAll();
    }

}

?>