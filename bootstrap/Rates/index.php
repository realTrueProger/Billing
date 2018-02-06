<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';


//////////// rates index



////////////////////
///Добавление тарифа
///////////////////


if (isset($_GET['add']))
{
	$pageTitle = 'Создание тарифа';
	$action = 'addtarif';
	$rateid = '';
	$ratename = '';
	$permin = '';
	$permb = '';
	
	$button = 'Создать тариф';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/rates/form.html.php';
	exit();
}

if (isset($_GET['addtarif']))
{

  
  try
  {
    $sql = 'INSERT INTO rateplan SET
        rateid = :rateid,
        ratename = :ratename,
        permin = :permin,
        permb = :permb';
    $s = $pdo->prepare($sql);
    $s->bindValue(':rateid', $_POST['rateid']);
    $s->bindValue(':ratename', $_POST['ratename']);
    $s->bindValue(':permin', $_POST['permin']);
    $s->bindValue(':permb', $_POST['permb']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted author.';
    include 'error.html.php';
    exit();
  }
  
  header('Location: .');
  exit();
}




////////////////////
///Карточка тарифа
/////////////////////////


if (isset($_GET['info']))
{
		
		try
		  {
			$sql = 'SELECT rateid, ratename, permin, permb FROM rateplan WHERE rateid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_GET['rateid']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error fetching author details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }

	
	$row = $s->fetch();
	$pageTitle = 'Информация по тарифу';
	$action = 'editform';
	$rateid = $row['rateid'];
	$ratename = $row['ratename'];
	$permin = $row['permin'];
	$permb = $row['permb'];
	$button = 'Изменить данные';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/rates/form.html.php';
	exit();
	
	
	
}

//////////////////////
//Удаление
//////////////////////



if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
{
	
	try
  {
    $sql = 'DELETE FROM rateplan WHERE rateid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['rateid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting author.';
    include 'error.html.php';
    exit();
  }
  
  
  header('Location: .');
  exit();
}

//////////////////////
//////редактирование
//////////////////////

if (isset($_GET['editform']) and $_POST['action'] == 'Изменить данные')
{
		try
		  {
			$sql = 'UPDATE rateplan SET
				rateid = :rateid,
				ratename = :ratename,
				permin = :permin,
				permb = :permb
				WHERE rateid = :rateid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':rateid', $_POST['rateid']);
			$s->bindValue(':ratename', $_POST['ratename']);
			$s->bindValue(':permin', $_POST['permin']);
			$s->bindValue(':permb', $_POST['permb']);
		
			$s->execute();
		  }
	  catch (PDOException $e)
	  {
		$error = 'Error adding submitted author.';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
		exit();
	  }
	  
	
	header('Location: .');
    exit();
}

////////////////////
//Запрос вывода на главную
///////////////////

try
{
  $result = $pdo->query('SELECT rateid, ratename, permin, permb FROM rateplan');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $rates[] = array('rateid' => $row['rateid'],
					'ratename' => $row['ratename'],
					'permin' => $row['permin'],
					'permb' => $row['permb']);
}



include $_SERVER['DOCUMENT_ROOT'] . '/includes/rates/main.html.php';
