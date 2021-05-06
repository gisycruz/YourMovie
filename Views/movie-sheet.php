<?php require_once('nav-bar.php');?>
<div style="text-align: -webkit-center">
    <div class="wrapper row4 diseño" style="background-color: rgba(0,0,0,0);">
    <br>
    <div>
    <?php if (isset($message)  && $message != 1 && $message !="") {echo "<span style='color: #321f28 ; font-weight: bold;' >" . $message . "</span><br><br>"; } ?>
   </div>
           <br>
        <div style="margin: 5%">
        <div style="display: inline-block;">
        <img src="<?php echo MOVIE_POSTER . $movie->getUrlImage(); ?>" alt="<?php echo $movie->getTitle(); ?>">
        </div>
            <div style="width:60%;  vertical-align: top; display:inline-block; background-color: rgba(115, 64, 70, 0.9); padding: 2%; text-align: left;">
                <h3 style="font-weight: bold; -webkit-text-stroke: 1.25px rgba(50, 31, 40, 1); padding-left: 3%;"><?php echo $movie->getTitle(); ?></h3>
                <p style="background-color:rgba(50, 31, 40, 0.9); padding: 4%">
                    <?php echo "Overview: " . "<br>" . $movie->getOverview() .
                        "<br> Duration: " . $movie->getduration() . " min." .
                        "<br> Language: " . $movie->getLanguage().
                        "<br> Genre: " . $movie->getGenre()->getGenreName();?>
           
        <table style="text-align:center;">
          <thead>
            <tr>
            <th style="width: 15%;">Cinema</th>
            <th style="width: 15%;">Room</th>
            <th style="width: 15%;" >Date</th>
            <th style="width: 15%;" >Hour</th>
            <th style="width: 15%;" >Ticket Value</th>
            <?php if(isset($_SESSION['loginAdmid'])){?>
                <th style="width: 15%;">Sold</th>
                <th style="width: 15%;">Remnants</th>
               
                    <?php }else{ ?>
            <th style="width: 25%;" >Action</th>
            <?php }?>
            </tr>
          </thead>
          <tbody>
          <?php
           $sumaSold = 0;
           $sumaRemnants =0;
           $sumaMoney =0.00;
          if(is_array($screeningList) ){ foreach($screeningList as $Screening){
            ?>  
            <tr>
                <td> <?php echo $Screening->GetRoom()->getCinema()->getName();?> </td>
                <td> <?php echo $Screening->GetRoom()->getName(); ?> </td>
                <td> <?php echo  date("d/m/Y", strtotime($Screening->GetDate_screening()));?> </td>
                <td> <?php echo $Screening->GetHour_screening(); ?> </td> 
                <td> <?php echo "$". $Screening->GetRoom()->getTicketValue(); ?> </td> 
                <?php if(isset($_SESSION['loginAdmid'])){
                $sold = $Screening->soldScreening($Screening->getId_screening());
                $remnants = $Screening->RemnantsScrrening($Screening->getId_screening());
                if($var == true){
                   
                $totalMoney = $Screening->GetRoom()->getTicketValue() * $sold;
                $sumaSold = $sumaSold + $sold ;
                $sumaRemnants = $sumaRemnants + $remnants;
                $sumaMoney = $sumaMoney +  $totalMoney;
                }
                ?>
                    <td> <?php echo $sold ?> </td>
                    <td> <?php echo $remnants?></td> 
                    <?php }else{ ?>
                <td>
                <b><a href="<?php echo FRONT_ROOT. "Shopping/GetShopping/?id_screening=". $Screening->getId_screening() ?>"><h3>Get ticket!</h3></a></b>
                </td>
                    <?php }?>
            </tr> 
            <?php }?>
            </div>
            <br>  
        </tbody>
        <div>
        <?php if(isset($_SESSION['loginAdmid']) && $var == true ){?>
           <table style="text-align:center;">
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
        <?php }}?>
        </table> 
        </div>
        </div>
    </div>   
</div>