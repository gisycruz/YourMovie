<?php 
namespace Models;


class Ticket{

   private $id_ticket;
   private $shopping;
   private $seat;
   private $numberTicket;
   private $qr;


   public function getId_ticket()
   {
      return $this->id_ticket;
   }

   public function setId_ticket($id_ticket)
   {
      $this->id_ticket = $id_ticket;

   }

   public function getShopping()
   {
      return $this->shopping;
   }
   
   public function setShopping($shopping)
   {
      $this->shopping = $shopping;

   }


   public function getQr()
   {
      return $this->qr;
   }

   public function setQr($qr)
   {
      $this->qr = $qr;
   }

   
   public function getNumberTicket()
   {
      return $this->numberTicket;
   }

   public function setNumberTicket($numberTicket)
   {
      $this->numberTicket = $numberTicket;

   }

   public function getSeat()
   {
      return $this->seat;
   }


   public function setSeat($seat)
   {
      $this->seat = $seat;

   }
}
  
?>