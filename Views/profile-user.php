<?php
//FALTA c) Consultar las entradas adquiridas, ordenadas por película ó por fecha.
require_once("validate-sessionUser.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);">
    <div class="content" style="background-color: rgba(0, 0, 0, 0);">
      <div class="scrollable">
        <br>
        <form action="" method="get">
          <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px"> Your Profile </h2>
          <table style="text-align:center;">
            <thead>
              <tr>
                <td style="width: 15%;">Email</td>
                <td style="width: 15%;">Password</td>
                <td style="width: 15%;">firstName</td>
                <td style="width: 15%;">LastName</td>
                <td style="width: 15%;">Dni</td>
                <td style="width: 15%;">birthDate</td>
              </tr>
            </thead>
            <tbody>
                  <tr>
                    <th> <?php echo $user->getUserName(); ?></th>
                    <th> <?php echo $user->GetPassword(); ?></th>
                    <th> <?php echo $user->getFirstName(); ?></th>
                    <th> <?php echo $user->getLastName(); ?></th>
                    <th> <?php echo $user->getDni(); ?></th>
                    <th> <?php echo $user->getBirthDate(); ?></th>
                  </tr>
              <?php
              ?>
            </tbody>
       
        </table>
        <div>
        <button class="btn" style="font-size: 12px"> <a href="<?php echo FRONT_ROOT."Session/ShowModifyUserViews?id_user=".$user->getUserId();?>" style="color:#f5f3ed;">Modify</a></button>
        <button class ="btn" style="font-size: 12px" name="id_user"  value ="<?php echo $user->getUserId(); ?>">Delete account </button>
        </div>
        </form>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>