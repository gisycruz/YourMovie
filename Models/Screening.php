<?php 

    namespace Models;
    use Models\Room as Room ;
    use Models\Movie as Movie ;
    use DAO\ShoppingBdDAO as ShoppingBdDAO;

    class Screening {

        private $id_screening; 
        private $room; 
        private $movie;
        private $date_screening; 
        private $hour_screening; 
        private $shoppingBdDAO;
        
        public function __construct(Room $room, Movie $movie ,$date_screening,$hour_screening) 
        {
           $this->date_screening = $date_screening;
            $this->hour_screening = $hour_screening;
            $this->room = $room;
            $this->movie = $movie;
            $this->shoppingBdDAO = new ShoppingBdDAO();
        }

    public function getId_screening(){return $this->id_screening;}
    public function setId_screening($id_screening) {  $this->id_screening = $id_screening;}
    public function getDate_screening() { return $this->date_screening; }
    public function setDate_screening($date_screening){$this->date_screening = $date_screening;}
    public function getHour_screening(){ return $this->hour_screening;}
    public function setHour_screening($hour_screening){  $this->hour_screening = $hour_screening;}
    public function getMovie(){ return $this->movie;}
    public function setMovie($movie) { $this->movie = $movie;}
    public function getRoom() { return $this->room; }
    public function setRoom($room){ $this->room = $room;}
    public function getCinema() { return $this->cinema;}
    public function setCinema($cinema) { $this->cinema = $cinema;}
    public function soldScreening($id_screening){
        return   $this->shoppingBdDAO->sumNumberOfPurchasesOfaScreening($id_screening);
    }
    public function RemnantsScrrening($id_screening){
      return  $this->getRoom()->getCapacity() - $this->soldScreening($id_screening);
       
    }
}





?>