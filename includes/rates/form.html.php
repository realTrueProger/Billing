<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title><?php htmlout($pageTitle); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="/css/carousel.css" rel="stylesheet">
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
    <h2><?php htmlout($pageTitle); ?></h2>
	
	</br>
	</br>
	<p>Заполните все поля:</p>
	
	<form class="form-horizontal" action="?<?php htmlout($action); ?>" method="post">
	
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Название</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="ratename" value="<?php htmlout($ratename); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Цена за мин</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="permin" value="<?php htmlout($permin); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="input" class="col-sm-2 control-label">Цена за мб</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="input" name ="permb" value="<?php htmlout($permb); ?>" >
			</div>
		  </div>
		  
		  <div class="form-group">
			
			<div class="col-sm-10">
			  <input type="hidden" class="form-control" id="input" name ="rateid" value="<?php htmlout($rateid); ?>" >
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
			  <button type="submit" class="btn btn-primary" name="action" value="Изменить данные"><?php htmlout($button); ?></button>
			</div>
			
		  </div>
		  <?php if(isset($_GET['info'])): ?>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary" name="action" value="Удалить">Удалить</button>
			</div>
		  </div>
		  <?php endif; ?>
</form>
	
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>