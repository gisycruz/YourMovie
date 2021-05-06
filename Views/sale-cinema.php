<?php
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color: rgba(0,0,0,0);">
    <main class="container clear centrado" >
    <div class="content" style="background-color: rgba(0, 0, 0, 0);">
      <div class="scrollable">
            <?php if ($message) { echo "<h3>" . $message . "</h3><br>";} ?>
                <?php if($id_cinema == null){?>
                <h2><span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Choose a Cinema whit Screening <a href="#" style="font-size: 16px;"></a></span></h2>
                <form action="<?php echo FRONT_ROOT."Sales/ShowSalesTicketCinema"?>" method="get" style="padding: 2rem !important;">
                   <select name="cinema" id="cinema" style=" width: 30%; padding: 10px; background-color:rgba(0,0,0,.55); color:#FFFFFF; "required>
                   <option value="" disable_selected>--Choose a Cinema--</option>
                   <?php foreach($listCinemaScreening  as $cinema){?>
                  <option value="<?php echo $cinema->getId_cinema();?>"><?php echo $cinema->getName(); ?></option>
                 <?php } ?>
                    </select>
                     <div>
                        <br>
                        <input type="submit" class="btn" value="search Cinema" style="background-color:#DC8E47;color:white;"/>
                        <br>
                    </div>
                    </form>
                    <?php }else{?>
                        <div class="content" style="background-color: rgba(0, 0, 0, 0);">
      
                <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px"> Cinema :<?php echo $cinema->getName()?><a href="#" style="font-size: 16px;"></a></span></h2><br>
                 <br>
                <table style="text-align:center;  width: 0;">
          <thead>
            <tr>
            <th style="width: 10%;">Room</th>
            <th style="width: 10%;" >Date</th>
            <th style="width: 10%;" >Hour</th>
            <th style="width: 10%;">Ticket Value</th>
                <th style="width:10%;">Sold</th>
                <th style="width:10%;">Remnants</th>
            </tr>
          </thead>
          <tbody>
          <?php
           $sumaSold = 0;
           $sumaRemnants =0;
           $sumaMoney =0.00;
             if(isset($listShopping)){ foreach($listShopping as $shopping){
                 
                 $screening = $shopping->getScreening();?>
            <tr>
                <td> <?php echo $screening->getroom()->getName();?> </td>
                <td> <?php echo  date("d/m/Y", strtotime($screening->GetDate_screening()));?></td>
                <td> <?php echo $screening->GetHour_screening(); ?> </td> 
                <td> <?php echo "$". $shopping->getPriceRoom(); ?> </td> 
                <?php 
                $sold = $shopping->getCountrtiket();
                $remnants = $screening->getroom()->getCapacity() - $sold;
                $totalMoney = $shopping->getPriceRoom() * $sold;
                $sumaSold = $sumaSold + $sold ;
                $sumaRemnants = $sumaRemnants + $remnants;
                $sumaMoney = $sumaMoney +  $totalMoney;
            
                ?>
                    <td> <?php echo $sold ?> </td>
                    <td> <?php echo $remnants?></td> 
                    <?php }}?>   
           
            
            </tr>  
        </tbody>
        </table>
        </div>
      
           <table style="text-align:center;  width: 0;">
          <thead>
            <tr>
            <th style="width: 15%;">Total Sold</th>
            <th style="width: 15%;">Total Remnants</th>
            <th style="width: 15%;" >Total Money</th>
            </tr>
          </thead>
          <tbody>
             <td> <?php echo  $sumaSold?></td> 
             <td> <?php echo  $sumaRemnants ;?> </td>
             <td> <?php echo "$".$sumaMoney ;?></td>    
            </tr> 
        </tbody>
    <?php }?>
        </table> 
                </div>
            </div>
        </div>
    </main>
</div>
<?php
include('footer.php');
?>