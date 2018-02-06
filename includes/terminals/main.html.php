<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Styles
	========================================== -->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>
	
	<title>Биллинг</title>
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
	<a href="../">на главную<<</a>
    <h2>Управление терминалами</h2>
	<a class="btn btn-primary" href="?add" role="button">Активировать новый терминал</a>
	</br>
	</br>
	<form class="form-inline" action="" method="GET">
		  
		  <div class="form-group">
			
			<input type="text" class="form-control" name="text" >
		  </div>
		  <button type="submit" class="btn btn-info" name="action" value="search">Поиск</button>
	</form>
	
	<h3>Терминалы:</h3>
	<table class="table table-bordered table-hover">
		<tr>
			
			<th>iccid</th>
			<th>Статус</th>
			<th>Клиент</th>
		</tr>
		<?php foreach($terminals as $terminal): ?>
		<tr onclick="window.location.href='?info&iccid=<?php htmlout($terminal['iccid']); ?>'; return false"> <!--джаваскрипт ссылка на строке -->
			<td><?php htmlout($terminal['iccid']); ?></td>
			<td><button type="button" class="btn <?php if($terminal['status'] == 'active') echo 'btn-success'; if($terminal['status'] == 'deactivated') echo 'btn-danger'; ?>"><?php htmlout($terminal['status']); ?></button></td>
			<td><?php htmlout($terminal['name']); ?></td>
		</tr>
		
		<?php endforeach; ?>
		
	</table>
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>