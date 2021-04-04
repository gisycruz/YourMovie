<?php
 require_once("validate-sessionUser.php");
 require_once('nav-bar.php');
?>      
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
    <div class="content" style="background-color: rgba(0, 0, 0, 0);"> 
    <h2><span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Selection to get a Shopping from :</span></h2>
    <br>
      <div class="scrollable">
      <table style="text-align:center;">
          <thead>
            <tr>
            <th style="width: 20%;">Name Cinema</th>
            <th style="width: 20%;">Address</th>
            <th style="width: 20%;" >Room</th>
            <th style="width: 20%;" >movie</th>
            <th style="width: 20%;" >price</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td><?php echo $screening->getRoom()->getCinema()->getName();?></td>
                <td><?php echo $screening->getRoom()->getCinema()->getAddress();?> </td> 
                <td><?php echo $screening->getRoom()->getName();?></td> 
                <td><?php echo $screening->getMovie()->getTitle();?> </td> 
                <td><?php echo $screening->getRoom()->getTicketValue();?></td>         
            </tr> 
          </tbody>
        </table>
       </div> 
       <br>
      <h2><span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Add number of ticket</span></h2>
	  <form action="<?php echo FRONT_ROOT."Shopping/addQuantityTicket"?>" method="post" style="padding: 2rem !important;" >
          <table style="max-width: 60%"> 
            <thead>
              <tr >
              <?php if(isset($message)){ echo "<h3>". $message ."</h3><br><br>";}?>
              </tr>
              <tr>
                <th>Numeber Ticket</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="width: 50%;">
                <br>
                  <input type="number" name="numberTicket"  min="1" max="30"  placeholder="Numeber Ticket" required>
                <br>
                    <div >
                         <label for="">TOTAL</label>
                         <input type="text"  value="<?php if(isset($total) && isset($ticketQuantity)) echo $total ?>" placeholder="Total" >
                    </div>
                    <br>
                    <div>
                    <button type="submit" name="id_screening" value ="<?php echo $screening->getId_screening(); ?>" class="btn btn-danger ml-3">Calcular Total</button>
                    </div>
                    <br>
               </td>
              </tr>
			 
            </tbody>
        </table>
		</form>
		<?php if(isset($total) && isset($ticketQuantity)){?> 
      <form action="<?php echo FRONT_ROOT."Shopping/ShowAddCardViews"?>" method="post" >
		            <div>
              <input id="id_screenig" name="id_screenig" type="hidden" value="<?php echo $screening->getId_screening()?>">
              <button type="submit" name="tichetQuantity" class="btn" value="<?php echo $ticketQuantity ?>"  class="btn btn-danger ml-3" style="font-size: 20px" >     Add Card   </button>
               </div>
               </form>
					<?php }?>
   <div class="clear"></div>
  </main>


