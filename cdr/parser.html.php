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
		<h2>Парсер</h2>
		<p>Парсер проводит обработку нового трафика за текущий месяц.</p>
		<p>Для постоянного обновления трафика парсер должен запускаться каждый час через CRON или планировщик Windows.</p>
		<form action="" method="post">
			<button type="submit" class="btn btn-primary" name="parser" value="start">Запуск парсера</button>
		</form>
		</br>
		</br>
		<?php 
			if (isset($message)) echo $message;
		?>
	
	
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>