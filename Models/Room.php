<?php 
namespace Models;
use Models\Cinema as Cinema;
    
    class Room {

        private $id_room;
        private $name;
        private $capacity;
        private $ticketValue;
        private Cinema $cinema;

        public function __construct($name, $capacity, $ticketValue,Cinema $cinema)
	{
        $this->name = $name;
        $this->capacity = $capacity;
        $this->ticketValue = $ticketValue;
        $this->cinema = $cinema;
    }

        public function getId_room() { return $this->id_room;}
        public function setId_room($id_room){ $this->id_room = $id_room;return $this;}
        public function getName(){ return $this->name;}
        public function setName($name) {  $this->name = $name; return $this;}
        public function getCapacity(){ return $this->capacity;}
        public function setCapacity($capacity){ $this->capacity = $capacity;}
        public function getTicketValue(){ return $this->ticketValue;}
        public function setTicketValue($ticketValue){ $this->ticketValue = $ticketValue;}
        public function getCinema() { return $this->cinema; }
        public function setCinema($cinema) { $this->cinema = $cinema;}
    }



?>