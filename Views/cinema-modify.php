<?php
require_once("validate-session.php");
 require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="position: fixed;top: 23%; background-color: rgba(0,0,0,0);" >
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Modify Cinema</span></h2>
        <form action="<?php echo  FRONT_ROOT."Cinema/modify"?>" method="post" style="padding: 2rem !important;">
          <table style="width:60%"> 
            <thead>
            <?php if(isset($message)){ echo "<h3>" . $message . "</h3><br>";}?>
              <tr>
                <th>New Name</th>
                <th>New Address</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="width: 25%;">
                  <input type="text" name="name" min="1" max="30" size="30"  value = "<?php echo $cinema->getName();?>" >
                </td>
                <td style="width: 25%">
                  <input type="text" name="address" size="20" min="1" max="30" value = "<?php echo $cinema->getAddress();?>" >
                </td>  
              </tr>
              </tbody>
              <tfoot>
              <td style="background-color: #1a1c20; text-align: center; font-weight: bold;"><?php echo "Old Name:  '". $cinema->getName() ."'"; ?></td>
              <td style="background-color: #1a1c20; text-align: center; font-weight: bold;"><?php echo "Old Address:  '".$cinema->getAddress()."'"; ?></td>
              </tfoot>
          </table>
          <div>
          <button type="submit" name="id_cinema" class="btn" value="<?php echo $cinema->GetId_Cinema() ?>"style="font-size: 12px"> Modify </button>
            <br>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
