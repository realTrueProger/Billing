<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap!
	========================================== -->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>
	
	<title><?php htmlout($pagetitle); ?></title>
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
    <h2>Данные по терминалу</h2>
	
	</br>
	</br>
	
	
	<form class="form-horizontal" action="?<?php htmlout($action); ?>" method="post">
	
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">iccid</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="iccid" value="<?php htmlout($iccid); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">msisdn</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="msisdn" value="<?php htmlout($msisdn); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Технология</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="technology" value="<?php htmlout($technology); ?>" >
			</div>
		  </div>
		  
		  
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Тариф</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="ratename" value="<?php htmlout($ratename); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Клиент</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="name" value="<?php htmlout($name); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Статус</label>
			<div class="col-sm-1">
			  <input type="text" class="form-control <?php if($status == 'active') echo 'btn-success'; if($status == 'deactivated') echo 'btn-danger'; ?>" id="input" name ="status" value="<?php htmlout($status); ?>" >
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
			  <button type="submit" class="btn btn-primary" name="action" value="Деактивировать">Деактивация</button>
			</div>
			
		  </div>
		  
</form>
	
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
	
  </body>
</html>