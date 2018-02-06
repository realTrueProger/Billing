<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap!
	========================================== -->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>
	<title>CDR</title>
  </head>

  <body>
  
  
  <!-- NAVBAR
	================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] .
    '/includes/main/navbar.inc.php';?>
	</br></br></br>
	</br></br></br>


	<!-- MAIN
	================================================== -->
	<div class="container">
		<a href="./">назад<<</a>
		<h2>Детализация</h2>
		
		<form method="post">
			  <div class="form-group">
				<label for="1">введите iccid</label>
				<input type="text" class="form-control" id="1" placeholder="iccid" name="iccid">
			  </div>
			  
			  
			  
			  <button type="submit" class="btn btn-primary">детализация</button>
		</form>
		
		<?php if(isset($_POST['iccid'])): ?>
		<br/>
		<h3>Детализация по iccid: <?php echo $_POST['iccid'] ; ?></h3>
		<h4>Голос</h4>
		<hr/>
		<?php if(isset($voice)):?>
		<table class="table table-bordered table-hover table-responsive">
			<tr>
				<th>Номер</th>
				<th>Мин.</th>
				<th>Дата</th>
			</tr>
			<?php foreach($voice as $voicen): ?>
			<tr>
				<td><?php htmlout($voicen['number']); ?></td>
				<td><?php htmlout($voicen['min']); ?></td>
				<td><?php htmlout($voicen['datetime']); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php else:?>
		<h4>Нет данных</h4>
		<?php endif;?>
		<br/>
		<h4>Трафик</h4>
		<hr/>
		<?php if(isset($traffic)):?>
		<table class="table table-bordered table-hover table-responsive">
			<tr>
				<th>Порт</th>
				<th>Хост</th>
				<th>Мб</th>
				<th>дата</th>
			</tr>
			<?php foreach($traffic as $trafficn): ?>
			<tr>
				<td><?php htmlout($trafficn['port']); ?></td>
				<td><?php htmlout($trafficn['host']); ?></td>
				<td><?php htmlout($trafficn['mb']); ?></td>
				<td><?php htmlout($trafficn['datetime']); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php else:?>
		<h4>Нет данных</h4>
		<?php endif; ?>
		<?php endif; ?>
		
	
	
	
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>