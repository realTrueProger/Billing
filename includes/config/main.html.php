<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap!
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
    <h2>Настройки</h2>
	
	</br>
	</br>
	
	<h4>Новый пользователь</h4>
		
		<form class="form-horizontal"  method="post">
	
		  <div class="form-group">
			<label for="login" class="col-sm-2 control-label">Логин</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="login" name ="login"  >
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="password" class="col-sm-2 control-label">Пароль</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="password" name ="password"  >
			</div>
		  </div>
		  
		  
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary" name="submit" value='Зарегистрироваться' >Создать</button>
			</div>
			
		  </div>
		  
		  
		  
</form>
	
	<p>Пользователи:</p>
	
	<table class="table table-bordered table-hover">
		<tr>
			<th>user_id</th>
			<th>user_login</th>
			
			
		</tr>
		<?php foreach($users as $user): ?>
		<tr> 
			<td><?php htmlout($user['id']); ?></td>
			<td><?php htmlout($user['user']); ?></td>
			
		</tr>
		
		<?php endforeach; ?>
		
	</table>
	
	</br>
	</br>
	
	
</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>