<?php
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color: rgba(0,0,0,0);">
    <main class="container clear centrado" >
        <div class="content">
            <div id="comments">
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
                    <br>
                    <?php }?>
             <?php if(isset($totalTicket)  && isset($Remnants)  && isset($totalMoneySold)) {?>
                <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px"> Cinema :<?php echo $cinema->getName()?><a href="#" style="font-size: 16px;"></a></span></h2><br>
                <br>
                    <table style="width: 75%;">
                        <thead>
                            <tr>
                                <th>Sold</th>
                                <th>Remnants</th>
                                <th>Total Money</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>    
                                <td><?php echo $totalTicket ?></td>
                                <td><?php echo $Remnants ?></td>
                                <td><?php echo "$" . $totalMoneySold ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <br>
                        <button type="submit" name="id_cinema" class="btn" value="<?php# echo $cinema->GetId_Cinema() ?>" style="font-size: 12px"></button>
                        <br>
                    </div>
               
                <?php  }?>
                </div>
            </div>
        </div>
    </main>
</div>
<?php
include('footer.php');
?>