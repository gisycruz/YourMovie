<?php require_once('nav-bar.php');?>
<div style="text-align: -webkit-center">
    <div class="wrapper row4 diseño" style="background-color: rgba(0,0,0,0);">
        <div style="margin: 5%">
            <div style="display: inline-block;">
            <div >
            <?php if (isset($message)) {echo "<span style='color: #321f28 ; font-weight: bold;' >" . $message . "</span><br><br>"; } ?>
        </div>
                <img src="<?php echo MOVIE_POSTER . $movie->getUrlImage(); ?>" alt="<?php echo $movie->getTitle(); ?>">
            </div>
            <div style="width:60%;  vertical-align: top; display:inline-block; background-color: rgba(115, 64, 70, 0.9); padding: 1%; text-align: left;">
                <h3 style="font-weight: bold; -webkit-text-stroke: 1.25px rgba(50, 31, 40, 1); padding-left: 4%;"><?php echo $movie->getTitle(); ?></h3>
                <p style="background-color:rgba(50, 31, 40, 0.9); padding: 4%">
                    <?php echo "Overview: " . "<br>" . $movie->getOverview() .
                        "<br> Duration: " . $movie->getduration() . " min." .
                        "<br> Language: " . $movie->getLanguage().
                        "<br> Genre: " . $movie->getGenre()->getGenreName(); ?>
               
                <div>
                    <?php foreach($screeningList as $screening) { ?> 
                       <p> <?php echo "Date: " . $screening->getDate_screening() . " || " . "Hour: " . $screening->getHour_screening() . " || Cinema: " . 
                            $screening->getRoom()->getCinema()->getName() . " (Address: ". $screening->getRoom()->getCinema()->getAddress() .") || Room: " . $screening->getRoom()->getName()."<p> || ticket value : ". $screening->getRoom()->getTicketValue() ."</p>";
                         ?> 

                        &nbsp;<b><a href="<?php echo FRONT_ROOT. "Shopping/GetShopping/?id_screening=". $screening->getId_screening() ?>"><h3>Get ticket!</h3></a></b>
                       </p>
                    <?php } ?>
                        <br>
                 </div>
              
            </div>
        </div>
    </div>

</div>