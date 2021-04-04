<?php
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);">
    <div class="content" style="background-color: rgba(0, 0, 0, 0);">
      <div class="scrollable">
        <br>
        <form action="#" method="post">
          <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px"> Room from <a href="#"><?php echo $cinema->getName() ." Address :" .$cinema->getAddress(); ?></a> </span></h2>
          <table style="text-align:center;">
            <thead>
              <tr>
                <?php if (isset($message)) {echo "<h3>" . $message . "</h3><br>";} ?>
                <th style="width: 20%;">Name Room</th>
                <th style="width: 20%;">Capacity</th>
                <th style="width: 20%;">ticketValue</th>
                <th style="width: 30%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($roomList)) {foreach ($roomList as $Room) {?>
                  <tr>
                    <td> <?php echo $Room->GetName(); ?></td>
                    <td> <?php echo $Room->GetCapacity(); ?></td>
                    <td> <?php echo " $ " . $Room->GetTicketValue(); ?></td>
                    <td>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Room/RemoveRoomFromDB?id_cinema=".$Room->getCinema()->getId_Cinema()."&id_room=".$Room->getId_room();?>" style="color:#f5f3ed;">Remove</a></button>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Room/ShowModififyView?id_room=".$Room->getId_room();?>" style="color:#f5f3ed;">Modify</a></button>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Screening/ShowScreeningsOfRoom?message=". $message = "" ."&id_cinema=".$Room->getCinema()->getId_Cinema()."&id_room=".$Room->getId_room();?>" style="color:#f5f3ed;">Show Screenig </a></button>
                
                    </td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
        </form>
        </table>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>