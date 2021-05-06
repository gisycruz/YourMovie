<?php
 require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
    <div class="content" style="background-color: rgba(0, 0, 0, 0);"> 
      <div class="scrollable">
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Screenings List From <a href="#" style="font-size: 16px;"><?php echo $cinema->getName()  ?></a></span></h2>
      <br>
      <div>
          <?php  if(isset($message)){ echo "<span style='color:red; font-weight: bold;' >". $message ."</span><br><br>";}?>
      </div>
      <form action="#" method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
            <th style="width: 20%;">Cinema/Room</th>
            <th style="width: 25%;">Movie</th>
            <th style="width: 15%;" >Date</th>
            <th style="width: 15%;" >Hour</th>
            <th style="width: 25%;" >Action</th>
            </tr>
          </thead>
          <tbody>
          <?php if(is_array($screeningList)){ foreach($screeningList as $Screening){
               ?>
            <tr>
                <td> <?php echo $Screening->GetRoom()->getCinema()->getName()."/".$Screening->GetRoom()->getName(); ?> </td>
                <td> <?php echo $Screening->GetMovie()->getTitle(); ?> </td>
                <td> <?php echo date("d/m/Y", strtotime($Screening->GetDate_screening())); ?> </td>
                <td> <?php echo $Screening->GetHour_screening(); ?> </td>          
                <td>
                &nbsp;
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Screening/ShowModififyView?id_screening=".$Screening->getId_screening(); ?>" style="color:#f5f3ed;">Modify</a></button>
                <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Screening/RemoveScreeningFromDB?id_screening=".$Screening->getId_screening()."&id_room=".$Screening->GetRoom()->getId_room(); ?>" style="color:#f5f3ed;">Remover</a></button>
                </td>
            </tr> 
          <?php 
            }}
         ?>                
        </tbody></form>
        </table> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>