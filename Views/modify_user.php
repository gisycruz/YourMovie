<?php
require_once("validate-sessionUser.php");
require_once('nav-bar.php');
?>
<div class="wrapper row4 portada" >
  <main class="container clear" style="color:black;">
    <div class="content">
      <div id="comments">
        <span style="font-weight: bold;">
          <h1>Modify User</h1>
        </span>
        <span style="color:#ec0101; font-weight: bold;" ><?php if ($message) {echo  "ERROR: " . $message ;} ?></span>
      </div>
      <div id="comments">
        <form class="login-form" id="mainav" method="post" action="<?php echo FRONT_ROOT . "Session/modifyUser" ?>">
          <div class="form-group content-align: inline;">
            <label style="font-weight: bold;">E-mail</label>
            <input name="email" type="email" value ="<?php echo $user->getUserName();?>" style="max-width: 20%;" required />
          </div>
          <div class="form-group ">
            <label style="font-weight: bold;">Password</label>
            <input name="password" type="password"  value ="<?php echo $user->getPassword();?>" style="max-width: 20%;" required />
          </div>
          <div class="form-group ">
            <label style="font-weight: bold;">FirstName</label>
            <input name="firstName" type="text"  value ="<?php echo $user->getFirstName();?>" style="max-width: 20%;" required />
          </div>
          <div class="form-group ">
            <label style="font-weight: bold;">LastName</label>
            <input name="lastName" type="text"  value ="<?php echo $user->getLastName();?>" style="max-width: 20%;" required />
          </div>
          <div class="form-group ">
            <label style="font-weight: bold;">Dni</label>
            <input name="dni" type="text"  value ="<?php echo $user->getDni();?>" maxlength="8" style="max-width: 20%;" required />
          </div>
          <div class="form-group ">
            <label style="font-weight: bold;">Birth Date</label>
            <input name="birthDate" type="date" min="1947-01-01" max="1999-12-31"  value ="<?php echo $user->getBirthDate();?>"  style="max-width: 20%;" required />
          </div>
          <br>
          <button type="submit" name="id_user" value ="<?php echo $user->getUserId();?>" style="font-size: 15px" class="btn">Send</button>
        </form>
      </div>
  </main>
</div>

</div>