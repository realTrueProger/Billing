<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';






////////////login test

if(isset($_GET['login']))
{
	include '../../includes/config/login.html.php';
	exit();
}










/////////////////////////
/////Регистрация нового пользователя
/////////////////////////


if(isset($_POST['submit']))

{

    $err = array();


    # проверям логин

    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))

    {

        $err[] = "Логин может состоять только из букв английского алфавита и цифр";

    }

    

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)

    {

        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";

    }

    

    # проверяем, не сущестует ли пользователя с таким именем

    
	try
		  {
			$sql = 'SELECT COUNT(user_id) FROM users WHERE user_login = :user_login';
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

	
	$row = $s->fetchColumn();
	echo $row;
	
    if($row > 0)

    {

        $err[] = "Пользователь с таким логином уже существует в базе данных";

    }

    

    # Если нет ошибок, то добавляем в БД нового пользователя

    if(count($err) == 0)

    {

        
        $login = $_POST['login'];

        

        # Убераем лишние пробелы и делаем двойное шифрование

        $password = md5(md5(trim($_POST['password'])));

        try
		  { 
			$sql = 'INSERT INTO users SET
				user_login = :user_login,
				user_password = :user_password';
			$s = $pdo->prepare($sql);
			$s->bindValue(':user_login', $login);
			$s->bindValue(':user_password', $password);
			$s->execute();
		  }
		  catch (PDOException $e)
		  {
			$error = 'Error adding ';
			include 'error.html.php';
			exit();
		  }

        

        header("Location: ./"); exit();

    }

    else

    {

        print "<b>При регистрации произошли следующие ошибки:</b><br>";

        foreach($err AS $error)

        {

            print $error."<br>";

        }

    }

}


/////////////////////////
//////Запрос юзеров
///////////////////////////


try
{
  $result = $pdo->query('SELECT user_id, user_login FROM users');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $users[] = array('user' => $row['user_login'],
					'id' => $row['user_id']);
}

include $_SERVER['DOCUMENT_ROOT'] . '/includes/config/main.html.php';