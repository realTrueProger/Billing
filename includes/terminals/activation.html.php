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
    <h2>Активация прошла успешно</h2>
	<p style="text-decoration: underline;">Данные активации</p>
	<p>ICCID: <?php echo '1825'.$_POST['iccid']?></p>
	<p>MSISDN: <?php echo $msdn?> </p>
	<p>Технология: <?php echo $_POST['tech']?></p>
	<p>Статус: active</p>
	<p>Тариф: <?php echo $rates['ratename']?></p>
	<p>Клиент: <?php echo $cname['name']?></p>
	<p>Данные отправлены на почтовый ящик клиента: <?php echo $mailto ;?></p>
	</br>
	<a href="/bootstrap/terminals"><-- Продолжить</a>
	
	
	
	</br>
	</br>
	
	
	
	
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
	
  </body>
</html>