<?php
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color: rgba(0,0,0,0);">
    <main class="container clear centrado" >
        <div class="content">
            <div id="comments">
                <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Modify Screening to cinema :<?php echo  $screening->getRoom()->getCinema()->getName() ." || Room : ". $screening->getRoom()->getName(); ?></span></h2>
                    <form action="<?php echo  FRONT_ROOT ."Screening/modify"?>" method="post" style="padding: 2rem !important;">
                    <table style="width: 75%;">
                        <thead>
                            <tr>
                                <th>Movie</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>    
                                <td style="max-width: 10%; align-items: center; vertical-align: middle;">
                                    <select name="movie" id="movie" style="width: 100%;" required>
                                        <option value="" disable_selected>--Choose a Movie--</option>
                                        <?php foreach($movieList as $movie){?>
                                        <option value="<?php echo $movie->getId_Movie();?>"><?php echo $movie->getTitle(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="max-width: 25%; align-items: center; vertical-align: middle;">
                                <input type="date" name ="date" min="2021-01-01" max="2024-01-01" required >
                                </td>
                                </td>
                                <td style="max-width: 25%; align-items: center; vertical-align: middle;">
                                <input type="time" name ="Time" required >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <br>
                        <input id="id_room" name="id_room" type="hidden" value="<?php echo $screening->getRoom()->getId_room();?>">
                        <button type="submit" name="id_screening" class="btn" value="<?php echo $screening->getId_screening()?>" style="font-size: 12px"> Modify Scrrening </button>
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<?php
include('footer.php');
?>