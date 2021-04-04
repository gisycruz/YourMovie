<?php
require_once("validate-sessionUser.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
<form action="<?php echo FRONT_ROOT."Ticket/addTicket" ?>" method="post" >
<br><br>
<div><h2><span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px"> Ticket Obtained </span></h2></div>
<div><h1 style ="color:rgba(0,0,0,.55);"><?php if ($message){ echo "<br>". $message . "<br>";} ?></h1></div>
<?php

$seat = 0;
if (isset($Listticket)  && !empty($Listticket)){ foreach($Listticket as $ticket ){?>
        <div class="cardWrap">
  
 
   <?php
   
   $shopping = $ticket->getShopping();
   $screening =$shopping->getScreening();
   $movie =$screening->getMovie();
   $room= $screening->getRoom();
   $cinema = $room->getCinema();
   $user = $shopping->getUser()->getUserName();
  
  // a ticket ponerle una  variable para el numero de asiento 
  
   ?>
   <div class="card cardLeft">
    <h1> Cinema <span class ="tnstspan"><?php echo "<br>". $cinema->getName() ." Address :" .$cinema->getAddress();?></span></h1>
    <div class="name">
      <h2 class="tnsth2"><?php echo $room->getName();?></h2>
      <span class ="tnstspan" >Room</span>
    </div>
    <div class="title">
      <h2 class="tnsth2"><?php echo $movie->getTitle();?></h2>
      <span class ="tnstspan"> movie </span>
    </div>
    <div class="time">
      <h2 class="tnsth2"><?php echo $screening->getHour_screening();?></h2>
      <span class ="tnstspan">time</span>
    </div>
    </div>
  <div class="card cardRight">
  <h1> Seat <?php echo $ticket->getSeat(); ?></h1>
    <div class="number">
      <h3 class ="numberh3"><?php echo $screening->getDate_screening();?></h3>
      <span class="numberspan">Date</span>
    </div>
    <div class="barcode"></div>
     <img src="<?php echo $ticket->getQr(); ?>"/>
  </div>
  <br>
  <br>
  </div>
  <?php }?>
  <br>
  <div>
  <input id="id_screenig" name="user" type="hidden" value="<?php echo $user ?>">
  <button type="submit" name="id_shopping" class="btn" value="<?php echo $shopping->getId_shopping();?>"  class="btn btn-danger ml-3" style="font-size: 20px" >Send to Mail </button>
  </div>
  <?php }?>
  </form>
    <!-- / main body -->
    <div class="clear"></div>
</div>
</div>







































