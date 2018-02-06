<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Styles
	========================================== -->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>
	
	<title>Активация терминала</title>
  </head>

  <body>
  
  
  <!-- NAVBAR
================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] .
    '/includes/main/navbar.inc.php';?>
</br></br></br>
</br></br></br>


<!-- MAIN форма
================================================== -->
<div class="container">
    <h2>Активация нового терминала</h2>
	
	</br>
	</br>
	
	
	<form class="form-horizontal" action="?<?php htmlout($action); ?>" method="post">
	
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Введите iccid терминала для активации (4-х значный номер с карточки после 1825-)</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="iccid" pattern="[0-9]{4}" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Введите номер клиентского договора</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="id"   >
			</div>
		  </div>
		  <div class="form-group">
			<label for="select" class="col-sm-2 control-label">Выбор технологии</label>
			  <div class="col-sm-10">
			  <select id="select" class="form-control" name="tech">
				  
				  <option>Inmarsat IsatPhone</option>
				  <option>Inmarsat FleetBroadBand</option>
				  <option>Inmarsat Bgan M2M</option>
				  <option>Iridium Phone</option>
				  <option>Iridium OpenPort</option>
			  </select>
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label for="select" class="col-sm-2 control-label">Установка тарифа</label>
			  <div class="col-sm-10">
			  <select id="select" name="rateplan" class="form-control">
			  <?php foreach($rates as $rate): ?>
				  <option value="<?php echo $rate['rateid'] ; ?>"><?php echo $rate['ratename'] ; ?></option>
			  <?php endforeach; ?>	  
			  </select>
			  </div>
		  </div>
		  
		  
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="checkbox">
				<label>
				  <input type="checkbox"> Подтверждаю
				</label>
			  </div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary" name="action" value="Активация">Активация</button>
			</div>
		  </div>
		  
</form>
	
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
	
  </body>
</html>