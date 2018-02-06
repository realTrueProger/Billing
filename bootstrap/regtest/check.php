<?php 
// Скрипт проверки


# Соединямся с БД

include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';
include '../vendor/autoload.php';



if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))

{   
	
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

        print "Хм, что-то не получилось";

    }

    else

    {

        print "Привет, ".$userdata['user_login'].". Всё работает!";

    }

}

else

{

    print "Включите куки";

}

?>