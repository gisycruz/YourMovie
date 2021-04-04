<?php
 require_once("validate-sessionUser.php");
 require_once('nav-bar.php');
?>    
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
	<div class="contenedor">
	<?php if( $total) {echo "<h3> total de la compra " .  $total ."</h3><br>"; }?>
	<?php if ($message) { echo "<h3>" . $message . "</h3><br>";} ?>
		<!-- Tarjeta -->
		<section class="tarjeta" id="tarjeta">
			<div class="delantera">
				<div class="logo-marca" id="logo-marca">
				<!--<img src="<?php# echo IMG_CARD;?>visa.png" alt="">-->
				</div>
				<img src="<?php echo IMG;?>chip-tarjeta.png" class="chip" alt="">
				<div class="datos">
					<div class="grupo" id="numero">
						<p class="label">Número Tarjeta</p>
						<p class="numero">#### #### #### ####</p>
					</div>
					<div class="flexbox">
						<div class="grupo" id="nombre">
							<p class="label">Nombre Tarjeta</p>
							<p class="nombre"></p>
						</div>

						<div class="grupo" id="expiracion">
							<p class="label">Expiracion</p>
							<p class="expiracion"><span class="mes">MM</span> / <span class="year">AA</span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="trasera">
				<div class="barra-magnetica"></div>
				<div class="datos">
					<div class="grupo" id="firma">
						<p class="label">Firma</p>
						<div class="firma"><p></p></div>
					</div>
					<div class="grupo" id="ccv">
						<p class="label">CCV</p>
						<p class="ccv"></p>
					</div>
				</div>
				<p class="leyenda">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus exercitationem, voluptates illo.</p>
				<a href="#" class="link-banco">www.tubanco.com</a>
			</div>
		</section>
		<!-- Contenedor Boton Abrir Formulario -->
		<div class="contenedor-btn">
			<button class="btn-abrir-formulario" id="btn-abrir-formulario">
            <i class="far fa-id-card"></i>
			</button>
		</div>
		<!-- Formulario -->
		<form action="<?php echo FRONT_ROOT."Shopping/validateCard"?>" id="formulario-tarjeta" method = "get" class="formulario-tarjeta" >
			<div class="grupo">
			
				<label for="inputNumero">Card Number</label>
				<input type="text" id="inputNumero" name ="inputNumero"  maxlength="19"  autocomplete="off"  required/>
			</div>
			<div class="grupo">
				<label for="inputNombre">Name and Surname</label>
				<input type="text" id="inputNombre" maxlength="19" autocomplete="off" required>
			</div>
			<div class="flexbox">
				<div class="grupo expira">
					<label for="selectMes">Expired</label>
					<div class="flexbox">
						<div class="grupo-select">
						<label for="selectMes">Month</label>
							<select name="mes" id="selectMes" required>
								<option></option>
							</select>
							<i class="fas fa-angle-down"></i>
						</div>
						<div class="grupo-select">
						<label for="slectYear">Year</label>
							<select name="year" id="selectYear" required>
								<option></option>
							</select>
							<i class="fas fa-angle-down"></i>
						</div>
					</div>
				</div>
				<div class="grupo ccv">
					<label for="inputCCV">CCV</label>
					<input type="text" id="inputCCV" name ="inputCCV" maxlength="3" autocomplete="off" required>
					<br>
			<br>
			</div>
			</div>
			<input name="id_screening" type="hidden" value="<?php echo $id_screening ;?>">
			<input name="ticketQuantity" type="hidden" value="<?php echo $ticketQuantity;?>">
			<button type="submit" class="btn-enviar">Sent</button>
		</form>
	</div>
	<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	<script src="<?php echo JS_PATH;?>main.js"></script>
    <div class="clear"></div>
  </main>
</div>
</div> 
