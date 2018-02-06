<!DOCTYPE html>
<html lang="en">
  <head>
    

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    
  </head>

  <body>

    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Авторизация</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Логин" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Запомнить
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
