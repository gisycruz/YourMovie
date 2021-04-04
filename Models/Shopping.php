<?php 

namespace Models;
use Models\User as User;
use Models\Screening as Screening;

class Shopping{
    
   private  $id_shopping;
   private $user; 
   private $screening;
   private $dateShopping; 
   private $countrtiket;
   private $priceRoom;
   private $total;

    public function __construct()
    {
        
    }
    public function getId_shopping(){return $this->id_shopping; }

    public function setId_shopping($id_shopping){ $this->id_shopping = $id_shopping; }

    public function getUser(){return $this->user; }

   public function setUser(User $user){ $this->user = $user;}

   public function getScreening(){ return $this->screening; }

   public function setScreening($screening) { $this->screening = $screening; }

   public function getDateShopping() { return $this->dateShopping;}

   public function setDateShopping($dateShopping){ $this->dateShopping = $dateShopping;}

   public function getCountrtiket(){ return $this->countrtiket;}

   public function setCountrtiket($countrtiket){ $this->countrtiket = $countrtiket; return $this;}

   public function getPriceRoom(){ return $this->priceRoom;}

   public function setPriceRoom($priceRoom){ $this->priceRoom = $priceRoom; }

   public function getTotal(){return $this->total;}

   public function setTotal($total){ $this->total = $total; }


}



?>