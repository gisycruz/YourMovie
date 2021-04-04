<?php
require_once("validate-session.php");
 require_once('nav-bar.php');
 ?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color:rgba(0,0,0,0)">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Add New Cinema</span></h2>
        <form action="<?php echo  FRONT_ROOT."Cinema/AddCinema"?>" method="post" style="padding: 2rem !important;" >
          <table style="max-width: 60%"> 
            <thead>
              <tr >
              <?php  if($message){ echo "<span style='color:red; font-weight: bold;' >". $message ."</span><br><br>";}?>
              </tr>
              <tr>
                <th>Name</th>
                <th>Address</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="width: 50%;">
                  <input type="text" name="name" min="1" max="30" size="30"  placeholder="Name of the cinema" required>
                </td>
                <td style="width: 50%;">
                  <input type="text" name="address" size="20" min="1" max="30" placeholder="Address of the cinema" required>
                </td>        
              </tr>
              </tbody>
          </table>
          <div>
            <br>
            <input type="submit" class="btn" value="Add Cinema" style="background-color:#DC8E47;color:white;"/>
            <button class="btn" style="font-size: 15px"> <a href="<?php echo FRONT_ROOT."Cinema/ShowListCinemaView" ?>" style="color:#f5f3ed;">Show List Cinema</a></button>
            <br>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
</div>