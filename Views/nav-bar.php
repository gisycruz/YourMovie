
<div class="wrapper row1" style="background-color: #321f28;">
  <header id="header" class="hoc clear">
    <div id="logo" class="fl_left">
      <h1><a href="<?php echo FRONT_ROOT . "Home/Index" ?>"><img style="width: 30px; height: 30px" src="https://image.flaticon.com/icons/png/512/120/120603.png" alt="YourMovie"> YourMovie</a></h1>
    </div>
    <!-- Add path routes below -->
    <nav id="mainav" class="fl_right fixed-top">
      <ul class="clear">
        <li class="active"> <a href="<?php echo FRONT_ROOT . "Home/Index"; ?>">Main Menu</a> </li>
        <li>
        <a href="<?php echo FRONT_ROOT . "Movie/listMovies" ?>">Movies</a>
        </li>
        <?php if( !isset($_SESSION['loginAdmid'])  &&  !isset($_SESSION['loginUser'])){?>
        <li>
          <a href="<?php echo FRONT_ROOT ."Session/ShowLogInView"; ?>">Log In</a>
        </li>
        <?php }
        if(!empty($_SESSION) && isset($_SESSION)){

            if(isset($_SESSION["loginAdmid"])){
        ?>
         <li><a class="drop" href="#">Cinemas</a>
            <ul>
              <li><a href="<?php echo FRONT_ROOT."Cinema/ShowAddCinemaView" ?>">add Cinema</a></li>
              <li><a href="<?php echo FRONT_ROOT."Room/ShowAddRoomView" ?>">Add Room </a></li>
              <li><a href="<?php echo FRONT_ROOT."Screening/ShowAddScreeningView" ?>">Add Screening </a></li>
            </ul>
          </li>
          <li><a class="drop" href="#">Consult sales</a>
            <ul>
              <li><a href="<?php# echo FRONT_ROOT."" ?>">Cinema</a></li>
              <li><a href="<?php echo FRONT_ROOT."Shopping/ShowSalesTicketMovie"?>">Movie </a></li>
              <li><a href="<?php# echo FRONT_ROOT."" ?>">Date</a></li>
            </ul>
          </li>
    <?php }?>
    <li><a class="drop" href="#">Session</a>
          <ul>
          <?php if(isset($_SESSION["loginUser"])){?>
              <li><a href="<?php echo FRONT_ROOT. "Session/ShowViewsProfileUser?id_user=".$_SESSION['loginUser']->getUserId();?>">My profile</a></li>
              <li><a href="<?php echo FRONT_ROOT. "Ticket/ShowTicketObtainedUser?id_user=".$_SESSION['loginUser']->getUserId();?>">Ticket Obtained</a></li>
              <?php }?>
              <li><a href="<?php echo FRONT_ROOT . "Session/SessionDestroy" ?>">Log Out</a></li>
          </ul>
    </li>
    <?php }?>
    </ul>
    </nav>
  </header>
</div>