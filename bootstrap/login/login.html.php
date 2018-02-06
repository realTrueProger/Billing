<!DOCTYPE html>
<html lang="en">
  <head>
    

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
	

    
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method='post'>
        <h2 class="form-signin-heading">Авторизация</h2>
        
        <input class="form-control" placeholder="Логин" name='login' required autofocus>
        
        <input class="form-control" placeholder="Пароль" name='password' required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Запомнить
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name='trylogin'>Войти</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
