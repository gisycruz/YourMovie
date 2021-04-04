<?php
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color: rgba(0,0,0,0);" >
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Modify Room <?php echo $room->getName()." || ". $cinema->getName() . "||" .$cinema->getAddress();?></span></h2>
        <form action="<?php echo  FRONT_ROOT."Room/modify"?>" method="post" style="padding: 2rem !important;">
        <?php if (isset($message)) {echo "<h3>" . $message . "</h3><br>";} ?>
          <table style="width:60%"> 
            <thead>
              <tr>
                <th>New Name</th>
                <th>New Capacity</th>
                <th>New Ticket Value</th>
                
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="width: 25%;">
                  <input type="text" name="name" min="1" max="30" size="30" value="<?php echo $room->getName(); ?>" required>
                </td>
                <td style="width: 30%;">
                  <input type="number" name="capacity"  min="30" max="300" size="20"  value="<?php echo $room->getCapacity(); ?>" required>
                </td> 
                <td style="width: 30%;">
                  <input type="number" name="ticketValue" min="50" max="1500" size="20"  value="<?php echo $room->getTicketValue(); ?>" required>
                </td> 
                        
              </tr>
              </tbody>
              <tfoot>
                
              <td style="background-color: #1a1c20; text-align: center; font-weight: bold;"><?php echo "Old Name:  '".$room->getName()."'"; ?></td>
              <td style="background-color: #1a1c20; text-align: center; font-weight: bold;"><?php echo "Old Capacity:  '".$room->getCapacity()."'"; ?></td>
              <td style="background-color: #1a1c20; text-align: center; font-weight: bold;"><?php echo "Old Ticket Value:  '".$room->getTicketValue()."'"; ?></td>
              </tfoot>
          </table>
          <div>
            <input type="submit" class="btn" value="Modify" style="background-color:#DC8E47;color:white;"/>
            <input id="id_room" name="id_room" type="hidden" value="<?php echo $room->getId_room();?>">
            <br>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
