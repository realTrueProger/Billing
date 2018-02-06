<?php 
////////////////////
///Скрипт авторизации
////////////////////////
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';

# Функция для генерации случайной строки

function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}


/////////////////////////
//////Авторизация
/////////////////////////

if(isset($_POST['trylogin']))

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

        header("Location: ./"); 
		exit();

    }

    else

    {
		echo 'В доступе отказано';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.html.php';
		exit();

    }

}



//////////////////////////
/////проверка пользователя
//////////////////////////


if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))     //если есть куки

{   
	///
	try
		  {
			$sql = 'SELECT * FROM users WHERE user_id = :user_id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':user_id', $_COOKIE['id']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }

    $userdata = $s->fetch();
	
    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))

    {

        setcookie("id", "", time() - 3600*24*30*12, "/");

        setcookie("hash", "", time() - 3600*24*30*12, "/");

        echo "Хм, что-то не получилось";
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.html.php';
		exit();

    }

    else

    {

        $login = 'ok';

    }

}

else

{

   
   include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.html.php';
   exit();

}