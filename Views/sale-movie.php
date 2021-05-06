<?php
require_once("validate-session.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color: rgba(0,0,0,0);">
    <main class="container clear centrado" >
        <div class="content">
            <div id="comments">
            <?php if ($message) { echo "<h3>" . $message . "</h3><br>";} ?>
                <?php if($id_movie == null){?>
                <h2><span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Choose a Movie whit Screening <a href="#" style="font-size: 16px;"></a></span></h2>
                <form action="<?php echo FRONT_ROOT."Movie/ShowSalesTicketMovie"?>" method="get" style="padding: 2rem !important;">
                   <select name="movie" id="movie" style=" width: 30%; padding: 10px; background-color:rgba(0,0,0,.55); color:#FFFFFF; "required>
                   <option value="" disable_selected>--Choose a Movie--</option>
                   <?php foreach($listMovieScreening as $movie){?>
                  <option value="<?php echo $movie->getId_Movie();?>"><?php echo $movie->getTitle(); ?></option>
                 <?php } ?>
                    </select>
                     <div>
                        <br>
                        <input type="submit" class="btn" value="search Movie" style="background-color:#DC8E47;color:white;"/>
                        <br>
                    </div>
                    </form>
                    <br>
                    <?php }?>
                </div>
            </div>
        </div>
    </main>
</div>
<?php
include('footer.php');
?>