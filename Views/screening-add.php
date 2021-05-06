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
                <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Choose a cinema to add screening <a href="#" style="font-size: 16px;"></a></span></h2>
                <form action="<?php echo FRONT_ROOT."Screening/ShowAddScreeningView" ?>" method="post" style="padding: 2rem !important;">
                 <select name="Cinema" id="Cinema" style=" width: 30%; padding: 10px; background-color:rgba(0,0,0,.55); color:#FFFFFF; "required>
                    <option value="" disable_selected>--Choose a Cinema--</option>
                    <?php if(isset( $listCinema)){ foreach($listCinema as $cinema) {?>
                    <option value="<?php echo $cinema->getId_cinema(); ?>"><?php echo $cinema->getName(); ?></option>
                     <?php } }?>
                     </select>
                     <div>
                        <br>
                        <input type="submit" class="btn" value="search Room" style="background-color:#DC8E47;color:white;" />
                        <br>
                    </div>
                    </form>
                    <?php }?>
             <?php if(isset($roomList)) { ?>
                <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Add Sscreening to cinema :<?php echo  $cinema->getName() ." Address : ". $cinema->getAddress()  ?><a href="#" style="font-size: 16px;"></a></span></h2>
                    <form action="<?php echo  FRONT_ROOT ."Screening/AddScreening"?>" method="post" style="padding: 2rem !important;">
                    
                    <table style="width: 75%;">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Movie</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>    
                                <td style="max-width: 10%; align-items: center; vertical-align: middle;">
                                    <select name="room" id="room" style="width: 100%;" required>
                                        <option value="" disable_selected>--Choose a Room--</option>
                                         <?php foreach($roomList as $room) {?>
                                        <option value="<?php echo $room->getId_room(); ?>"><?php echo $room->getName(); ?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td style="max-width: 10%; align-items: center; vertical-align: middle;">
                                    <select name="movie" id="movie" style="width: 100%;" required>
                                        <option value="" disable_selected>--Choose a Movie--</option>
                                        <?php foreach($movieList as $movie){?>
                                        <option value="<?php echo $movie->getId_Movie();?>"><?php echo $movie->getTitle(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="max-width: 25%; align-items: center; vertical-align: middle;">
                                <input type="date" name ="date" min="<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"));?>"  required >
                                </td>
                                <td style="max-width: 25%; align-items: center; vertical-align: middle;">
                                <input type="time"  min="<?php date_default_timezone_set('America/Argentina/Ushuaia'); echo date("Y-m-d(H:i)",time()) ;?>" name ="Time" required >
                                </td>  
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <br>
                        <button type="submit" name="id_cinema" class="btn" value="<?php echo $cinema->GetId_Cinema() ?>" style="font-size: 12px"> add Scrrening </button>
                        <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Screening/ShowScreeningsOfCinema?id_cinema=". $cinema->GetId_Cinema();?>" style="color:#f5f3ed;">Screenig Cinema</a></button>
                        <br>
                    </div>
                </form>
                <?php }?>
            </div>
        </div>
    </main>
</div>
<?php
include('footer.php');
?>