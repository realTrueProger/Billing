<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';


///////////////////
//Добавление клиента- выбор типа
//////////////////

if (isset($_GET['add']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/formtype.html.php';
	exit();
}


////////////////////
///Добавление клиента физ лицо
///////////////////


if (isset($_GET['addfiz']))
{
	$pageTitle = 'Добавить клиента';
	$action = 'addformfiz';
	$clientid = '';
	$name = '';
	$surname = '';
	$patronymic = '';
	$passportid = '';
	$passportreceivedin = '';
	$passportreceivedate = '';
	$contactnumber = '';
	$contactemail = '';
	$button = 'Добавить клиента';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/formfiz.html.php';
	exit();
}

if (isset($_GET['addformfiz']))
{

  
  try
  {
    $sql = 'INSERT INTO fizdata SET
        clientid = :clientid,
        name = :name,
        surname = :surname,
        patronymic = :patronymic,
        passportid = :passportid,
        passportreceivedin = :passportreceivedin,
        passportreceivedate = :passportreceivedate,
        contactnumber = :contactnumber,
        contactemail = :contactemail';
    $s = $pdo->prepare($sql);
    $s->bindValue(':clientid', $_POST['clientid']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':surname', $_POST['surname']);
    $s->bindValue(':patronymic', $_POST['patronymic']);
    $s->bindValue(':passportid', $_POST['passportid']);
    $s->bindValue(':passportreceivedin', $_POST['passportreceivedin']);
    $s->bindValue(':passportreceivedate', $_POST['passportreceivedate']);
    $s->bindValue(':contactnumber', $_POST['contactnumber']);
    $s->bindValue(':contactemail', $_POST['contactemail']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted author.';
    include 'error.html.php';
    exit();
  }

  try
  {
	$type = 'f';  
    $sql = 'INSERT INTO clients SET
        id = :clientid,
        name = :name,
        type = :type';
    $s = $pdo->prepare($sql);
    $s->bindValue(':clientid', $_POST['clientid']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':type', $type);
    $s->execute();
	unset($type);
  }
  catch (PDOException $e)
  {
    $error = 'Error adding ';
    include 'error.html.php';
    exit();
  }
  
  header('Location: .');
  exit();
}

////////////////////
///Добавление клиента юр лицо
///////////////////


if (isset($_GET['addur']))
{
	$pageTitle = 'Добавить клиента';
	$action = 'addformur';
	$clientid = '';
	$companyname = '';
	$legaladdress = '';
	$postaladdress = '';
	$bank = '';
	$currentaccount = '';
	$corraccount = '';
	$bik = '';
	$inn = '';
	$kpp = '';
	$contact = '';
	$contactnumber = '';
	$contactemail = '';
	$button = 'Добавить клиента';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/formur.html.php';
	exit();
}

if (isset($_GET['addformur']))
{

  
  try
  {
    $sql = 'INSERT INTO urdata SET
        clientid = :clientid,
        companyname = :companyname,
        legaladdress = :legaladdress,
        postaladdress = :postaladdress,
        bank = :bank,
        currentaccount = :currentaccount,
        corraccount = :corraccount,
        bik = :bik,
        inn = :inn,
        kpp = :kpp,
        contact = :contact,
        contactnumber = :contactnumber,
        contactemail = :contactemail';
    $s = $pdo->prepare($sql);
    $s->bindValue(':clientid', $_POST['clientid']);
    $s->bindValue(':companyname', $_POST['companyname']);
    $s->bindValue(':legaladdress', $_POST['legaladdress']);
    $s->bindValue(':postaladdress', $_POST['postaladdress']);
    $s->bindValue(':bank', $_POST['bank']);
    $s->bindValue(':currentaccount', $_POST['currentaccount']);
    $s->bindValue(':corraccount', $_POST['corraccount']);
    $s->bindValue(':bik', $_POST['bik']);
    $s->bindValue(':inn', $_POST['inn']);
    $s->bindValue(':kpp', $_POST['kpp']);
    $s->bindValue(':contact', $_POST['contact']);
    $s->bindValue(':contactnumber', $_POST['contactnumber']);
    $s->bindValue(':contactemail', $_POST['contactemail']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted author.';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
    exit();
  }

  try
  {
	$type = 'u';  
    $sql = 'INSERT INTO clients SET
        id = :clientid,
        name = :companyname,
        type = :type';
    $s = $pdo->prepare($sql);
    $s->bindValue(':clientid', $_POST['clientid']);
    $s->bindValue(':companyname', $_POST['companyname']);
    $s->bindValue(':type', $type);
    $s->execute();
	unset($type);
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
///Карточка клиента
/////////////////////////


if (isset($_GET['info']))
{
	//Физ лицо
	if($_GET['type'] == 'f')
	{
		try
		  {
			$sql = 'SELECT clientid, name, surname, patronymic, passportid, passportreceivedin, passportreceivedate, contactnumber, contactemail FROM `fizdata` WHERE clientid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_GET['id']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error fetching author details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }

	
	$row = $s->fetch();
	$pageTitle = 'Карточка клиента физ. лица';
	$action = 'editform';
	$clientid = $row['clientid'];
	$name = $row['name'];
	$surname = $row['surname'];
	$patronymic = $row['patronymic'];
	$passportid = $row['passportid'];
	$passportreceivedin = $row['passportreceivedin'];
	$passportreceivedate = $row['passportreceivedate'];
	$contactnumber = $row['contactnumber'];
	$contactemail = $row['contactemail'];
	$button = 'Изменить данные';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/formfiz.html.php';
	exit();
	}
	
	//юр лицо
	
	
	if($_GET['type'] == 'u')
	{
		try
		  {
			$sql = 'SELECT clientid,companyname,legaladdress,postaladdress,bank,currentaccount,corraccount,bik,inn,kpp,contact,contactnumber,contactemail FROM urdata WHERE clientid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_GET['id']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error fetching author details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }

	
	$row = $s->fetch();
	$pageTitle = 'Карточка клиента юр. лица';
	$action = 'editform';
	$clientid = $row['clientid'];
	$companyname = $row['companyname'];
	$legaladdress = $row['legaladdress'];
	$postaladdress = $row['postaladdress'];
	$bank = $row['bank'];
	$currentaccount = $row['currentaccount'];
	$corraccount = $row['corraccount'];
	$bik = $row['bik'];
	$inn = $row['inn'];
	$kpp = $row['kpp'];
	$contact = $row['contact'];
	$contactnumber = $row['contactnumber'];
	$contactemail = $row['contactemail'];
	$button = 'Изменить данные';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/formur.html.php';
	exit();
	}
}

//////////////////////
//////редактирование
//////////////////////

if (isset($_GET['editform']) and $_POST['action'] == 'Изменить данные')
{
	//проверка на физ/юр лицо, если указан банк то юр!
	if(isset($_POST['bank']))
		{
		try
		  {
			$sql = 'UPDATE urdata SET
				clientid = :clientid,
				companyname = :companyname,
				legaladdress = :legaladdress,
				postaladdress = :postaladdress,
				bank = :bank,
				currentaccount = :currentaccount,
				corraccount = :corraccount,
				bik = :bik,
				inn = :inn,
				kpp = :kpp,
				contact = :contact,
				contactnumber = :contactnumber,
				contactemail = :contactemail
				WHERE clientid = :clientid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':clientid', $_POST['clientid']);
			$s->bindValue(':companyname', $_POST['companyname']);
			$s->bindValue(':legaladdress', $_POST['legaladdress']);
			$s->bindValue(':postaladdress', $_POST['postaladdress']);
			$s->bindValue(':bank', $_POST['bank']);
			$s->bindValue(':currentaccount', $_POST['currentaccount']);
			$s->bindValue(':corraccount', $_POST['corraccount']);
			$s->bindValue(':bik', $_POST['bik']);
			$s->bindValue(':inn', $_POST['inn']);
			$s->bindValue(':kpp', $_POST['kpp']);
			$s->bindValue(':contact', $_POST['contact']);
			$s->bindValue(':contactnumber', $_POST['contactnumber']);
			$s->bindValue(':contactemail', $_POST['contactemail']);
			$s->execute();
		  }
	  catch (PDOException $e)
	  {
		$error = 'Error adding submitted author.';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
		exit();
	  }
	  
	  try
	  {
			$type = 'u';  
			$sql = 'UPDATE clients SET
				id = :clientid,
				name = :companyname,
				type = :type
				WHERE id = :clientid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':clientid', $_POST['clientid']);
			$s->bindValue(':companyname', $_POST['companyname']);
			$s->bindValue(':type', $type);
			$s->execute();
			unset($type);
		  }
	  catch (PDOException $e)
		  {
			$error = 'Error adding submitted author.';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }
			
	}	
	// Для физ лиц
	else
	{
		try
  {
    $sql = 'UPDATE fizdata SET
        clientid = :clientid,
        name = :name,
        surname = :surname,
        patronymic = :patronymic,
        passportid = :passportid,
        passportreceivedin = :passportreceivedin,
        passportreceivedate = :passportreceivedate,
        contactnumber = :contactnumber,
        contactemail = :contactemail
		WHERE clientid = :clientid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':clientid', $_POST['clientid']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':surname', $_POST['surname']);
    $s->bindValue(':patronymic', $_POST['patronymic']);
    $s->bindValue(':passportid', $_POST['passportid']);
    $s->bindValue(':passportreceivedin', $_POST['passportreceivedin']);
    $s->bindValue(':passportreceivedate', $_POST['passportreceivedate']);
    $s->bindValue(':contactnumber', $_POST['contactnumber']);
    $s->bindValue(':contactemail', $_POST['contactemail']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted author.';
    include 'error.html.php';
    exit();
  }

  try
  {
	$type = 'f';  
    $sql = 'UPDATE clients SET
        id = :clientid,
        name = :name,
        type = :type
		WHERE id = :clientid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':clientid', $_POST['clientid']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':type', $type);
    $s->execute();
	unset($type);
  }
  catch (PDOException $e)
  {
    $error = 'Error adding ';
    include 'error.html.php';
    exit();
  }
	} 
	
	
	header('Location: .');
    exit();
}



//////////////////////
//Удаление
//////////////////////



if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
{
	echo "тест!!";
	try
  {
    $sql = 'DELETE FROM clients WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['clientid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting author.';
    include 'error.html.php';
    exit();
  }
  
  try
  {
    $sql = 'DELETE FROM urdata WHERE clientid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['clientid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting author.';
    include 'error.html.php';
    exit();
  }
  
  try
  {
    $sql = 'DELETE FROM fizdata WHERE clientid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['clientid']);
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

//////////////////////////////
////////Поиск
/////////////////////////////////

if (isset($_GET['action']) and $_GET['action'] == "search")
{
	try
  {
    $sql = 'SELECT id, name, type FROM clients WHERE id LIKE :text OR name LIKE :text ';
    $s = $pdo->prepare($sql);
	$text = '%'.$_GET['text'].'%';
    $s->bindValue(':text', $text);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting author.';
    include 'error.html.php';
    exit();
  }
  
  foreach ($s as $row)
	{
	  $clients[] = array('id' => $row['id'],
						'name' => $row['name'],
						'type' => $row['type']);
	}


	include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/main.html.php';
	exit();
}



////////////////////
//Запрос вывода на главную
///////////////////

try
{
  $result = $pdo->query('SELECT id, name, type FROM clients');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $clients[] = array('id' => $row['id'],
					'name' => $row['name'],
					'type' => $row['type']);
}



include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/main.html.php';
