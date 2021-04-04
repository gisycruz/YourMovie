<?php
require_once("validate-session.php");
 require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
    <div class="content" style="background-color: rgba(0, 0, 0, 0);"> 
      <div class="scrollable">
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Cinemas List</span></h2>
      <br>
      <form action="#" method="post">
      <div id="btnImportant" class="" style="position: absolute; right: 15%; top: 21%; color:black;">  
       </div>
        <table style="text-align:center;">
          <thead>
            <tr>
            <?php if ($message) { echo "<h3>" . $message . "</h3><br>";} ?>
            <th style="width: 20%;">Name Cinema</th>
            <th style="width: 20%;">Address</th>
            <th style="width: 20%;" >Action</th>
            </tr>
          </thead>
          <tbody>
          <?php if(is_array($cinemaList)) {foreach($cinemaList as $Cinema){ ?>
            <tr>
                <td><?php echo $Cinema->GetName();?></td>
                <td><?php echo $Cinema->GetAddress();?> </td>         
                <td>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Cinema/RemoveCinemaFromDB?id_cinema=". $Cinema->getId_Cinema();?>" style="color:#f5f3ed;">Remove</a></button>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Cinema/ShowModififyView?id_cinema=". $Cinema->getId_Cinema();?>" style="color:#f5f3ed;">Modify</a></button>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Room/ShowRoomListCinemas?id_cinema=". $Cinema->getId_Cinema();?>"style="color:#f5f3ed;">Show Rooms</a></button>
                </td>  
            </tr> 
          <?php 
        }}
         ?>                
        </tbody></form>
        <tfoot>
          
        </tfoot>
        </table> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>