<?php
    namespace Models;

    class Cinema{

        private $id_Cinema;
        private $name;
        private $address;

        public function __construct($name, $address) {
            $this->name = $name;
            $this->address = $address;
        }

        public function getId_Cinema(){ return $this->id_Cinema; }
        public function setId_Cinema($id_Cinema) { $this->id_Cinema = $id_Cinema; }
        public function getName() { return $this->name; }
        public function setName($name) { $this->name = $name; }
        public function getAddress() { return $this->address; }
        public function setAddress($address) { $this->address = $address; }

    }
?>