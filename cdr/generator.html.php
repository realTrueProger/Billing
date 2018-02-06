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
		<h2>Создание голосового трафика</h2>
		<form class="form-inline" action="?cdrcall" method="post">
			
		  
		  <div class="form-group">
			<label for="11">iccid</label>
			<input type="text" class="form-control" id="11" name="iccid" >
		  </div>
		  <br/>
		  <br/>
		  <div class="form-group">
			<label for="1">Куда звонили</label>
			<input type="text" class="form-control" id="1" name="num" >
		  </div>
		  <div class="form-group">
			<label for="2">Время (мин.)</label>
			<input type="text" class="form-control" id="2" name="min" >
		  </div>
		  <div class="form-group">
			<label for="3">Дата и время звонка</label>
			<input type="datetime-local" class="form-control" id="3" name="datetime" >
		  </div>
		  <div class="form-group">
			<input type="hidden" name="type" value="c" >
		  </div>
		  <br/><br/>
		  <button type="submit" class="btn btn-primary">Создать</button>
		</form>
		</br></br></br></br>
		
		<h2>Создание ip трафика</h2>
		<form class="form-inline" action="?cdrip" method="post">
			<div class="form-group">
			<label for="11">iccid</label>
			<input type="text" class="form-control" id="11" name="iccid" >
		  </div>
		  <br/>
		  <br/>
		  <div class="form-group">
			<label for="4">Порт</label>
			<input type="text" class="form-control" id="4" name="port" >
		  </div>
		  <div class="form-group">
			<label for="5">Хост</label>
			<input type="text" class="form-control" id="5" name="host" >
		  </div>
		  <div class="form-group">
			<label for="6">Mb</label>
			<input type="text" class="form-control" id="6" name="mb" >
		  </div>
		  <div class="form-group">
			<label for="7">Дата и время</label>
			<input type="datetime-local" class="form-control" id="7" name="datetime" >
		  </div>
		  <div class="form-group">
			<input type="hidden" name="type" value="t" >
		  </div>
		  <br/>
		  <br/>
		  <button type="submit" class="btn btn-primary">Создать</button>
		</form>
		</br>
		</br>
	
	
	
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>