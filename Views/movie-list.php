<?php require_once('nav-bar.php');

?>
<div style="text-align: -webkit-center">
    <br>
        <div >
        <?php if (isset($message) && $message != 1) {echo  $message . "<br><br>"; } ?>
        <?php if (isset($var) && $var != true) { $var =""; } ?>
        </div>
        <div>
        <?php if(!isset($_SESSION["loginAdmid"])){ ?>
        <div style="position: absolute; right: 87%; background-color:;">
            <form action="<?php echo FRONT_ROOT . "Movie/ApplyFilters" ?>" method="post" style="background-color: #321f28; padding: 20px; ">
            <p>Search</p>
                <div>
                    Date
                    <select name="date" id="date">
                        <option value="" disable_selected>--Select a Date--</option>
                        <?php foreach ($datesOfScreenings as $date) { ?>
                            <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                        <?php } ?>
                    </select>
                </div>
                &nbsp;
                <div>
                    Genre
                    <select name="genre" id="genre">
                        <option value="" disable_selected>--Select a Genre--</option>
                        <?php foreach ($genresOfScreenings as $genre) { ?>
                            <option value="<?php echo $genre ; ?>"><?php echo $genre ; ?></option>
                        <?php } ?>
                    </select>
                </div>
                &nbsp;
                <button type="submit" style="width: 50px; height:25px; align-self: flex-end;">Apply</button>
            </form>
        </div>
        <?php } ?>
    </div>
    <?php if (is_array($MovieList) && !empty($MovieList)) { ?>
<table class="homeTable" style="width: 70%; margin-top: 40px">
            <thead>
                <th colspan="6">Screening <?php if (isset($filterMessage)){echo $filterMessage."<br><br>"; } ?></th>
            </thead> 
    <tbody>
        <tr>
         <?php foreach ($MovieList as $movie){if ($count == 6) { echo "</tr><tr>";$count = 0;} ?>
             <td style="text-align: center; padding: 10px; ">
                  <a href="<?php echo FRONT_ROOT . "Movie/ShowMovieSheet/" . "?id_movie=" . $movie->getId_movie()."&message=".$message."&var=".$var; ?>">
                <div class="div-img">
                   <img class="img" src="http://image.tmdb.org/t/p/w200<?php echo $movie->getUrlImage(); ?>" alt="<?php echo $movie->getTitle(); ?>" style="max-width: 200px; max-height:300px">
                </div>
                  </a>
              <br>
                 <a href="#" style="font-weight: bold;"><?php echo $movie->getTitle(); ?></a>
             </td>
           <?php $count++; } }?>
        </tr>
    </tbody>
            <tfoot></tfoot>
</table>
