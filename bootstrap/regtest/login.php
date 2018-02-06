<?php 

// Страница авторизации

include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';
include '../vendor/autoload.php';






if(isset($_POST['submit']))

{

    # Вытаскиваем из БД запись, у которой логин равняеться введенному

	try
		  {
			$sql = 'SELECT user_id, user_password FROM users WHERE user_login = :user_login';
			$s = $pdo->prepare($sql);
			$s->bindValue(':user_login', $_POST['login']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }

    $data = $s->fetch();

    # Сравниваем пароли
	echo $data['user_password'];
    if($data['user_password'] === md5(md5($_POST['password'])))

    {

        # Генерируем случайное число и шифруем его

        $hash = md5(generateCode(10));
      

        # Записываем в БД новый хеш авторизации и IP
	
		try
		  { 
			$sql = 'UPDATE users SET
				user_hash = :user_hash WHERE user_id = :user_id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':user_hash', $hash);
			$s->bindValue(':user_id', $data['user_id']);
			$s->execute();
		  }
		  catch (PDOException $e)
		  {
			$error = 'Error adding ';
			include 'error.html.php';
			exit();
		  }

        

        # Ставим куки

        setcookie("id", $data['user_id'], time()+60*60*24*30);

        setcookie("hash", $hash, time()+60*60*24*30);

        

        # Переадресовываем браузер на страницу проверки нашего скрипта

        header("Location: check.php"); 
		echo "пароль верный";
		exit();

    }

    else

    {

        print "Вы ввели неправильный логин/пароль";

    }

}

?>

<form method="POST">

Логин <input name="login" type="text"><br>

Пароль <input name="password" type="password"><br>

<input name="submit" type="submit" value="Войти">

</form>