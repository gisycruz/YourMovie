<?php 
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color:rgba(0,0,0,0)">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
       <?php if($id_cinema == null){?>
                    <?php if ($message) { echo "<h3>" . $message . "</h3><br>";} ?>
                <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Choose a cinema to add screening <a href="#" style="font-size: 16px;"></a></span></h2>
                <form action="<?php echo FRONT_ROOT."Room/ShowAddRoomView" ?>" method="get" style="padding: 2rem !important;">
                 <select name="Cinema" id="Cinema" style=" width: 30%; padding: 10px; background-color:rgba(0,0,0,.55); color:#FFFFFF; "required>
                    <option value="" disable_selected>--Choose a Cinema--</option>
                    <?php if(isset( $listCinema)){ foreach($listCinema as $cinemaList) {?>
                    <option value="<?php echo $cinemaList->getId_cinema(); ?>"><?php echo $cinemaList->getName(); ?></option>
                     <?php } }?>
                     </select>
                     <br>
                     <div>
                        <br>
                        <input type="submit" class="btn" value="search Cinema" style="background-color:#DC8E47;color:white;" />
                        <br>
                    </div>
                   
                    </form>
                    <?php }?>

         <?php if(!empty($cinema)){?>
        <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Add New Room for <a href="#"><?php echo $cinema->getName() ." Address :" .$cinema->getAddress(); ?></a></h2>
        <form action="<?php echo  FRONT_ROOT."Room/AddRoom"?>" method="post" style="padding: 2rem !important;" >
          <table style="max-width: 60%"> 
            <thead>
              <tr>
                <th>Name Room</th>
                <th>Capacity</th>
                <th>ticketValue</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="width: 30%;">
                  <input type="text" name="name" min="1" max="30" size="30"  placeholder="Name of the Room" required>
                </td>
                <td style="width: 30%;">
                  <input type="number" name="capacity"  min="3" max="300" size="20" placeholder="Capacity of the room" required>
                </td> 
                <td style="width: 30%;">
                  <input type="number" name="ticketValue" min="50" max="1500" size="20"  placeholder="Ticket Value" required>
                </td>           
              </tr>
              </tbody>
          </table>
          <div>
            <br>
            <button type="submit" name="id_cinema" class="btn" value="<?php echo $cinema->GetId_Cinema() ?>" style="font-size: 12px"> add Room </button>
            <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Room/ShowRoomListCinemas?id_cinema=". $cinema->getId_Cinema();?>"style="color:#f5f3ed;">Show Rooms</a></button>
            <br>
          </div>
        </form> 
        <?php }
        ?>
      </div>
    </div>
  </main>
</div>
</div>