<?php 
//////////////Terminals index
include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';




////////////////////
///Активация терминала
///////////////////

if (isset($_GET['add']))
{
	$action = 'activation';
	try
	{
	  $result = $pdo->query('SELECT rateid, ratename FROM rateplan');
	}
	catch (PDOException $e)
	{
	  $error = 'Error fetching from the database!';
	  include 'error.html.php';
	  exit();
	}

	foreach ($result as $row)
	{
	  $rates[] = array('rateid' => $row['rateid'],
						'ratename' => $row['ratename'],
						);
	}
	
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/terminals/form.html.php';
	exit();
}

if (isset($_GET['activation']))
{
	//проверка iccid
	$trim = (int)ltrim($_POST['iccid'], '0'); //убираем нули слева
	if ($trim < 0 or $trim > 9999 )
    {
		echo "Ошибка. Неверное значение iccid- укажите 4-х значный номер в промежутке от 0000 до 9999 </br>";
		$fail=1;
		
	}
	else 
	{
		$_POST['iccid'] = str_pad($_POST['iccid'], 4, "0", STR_PAD_LEFT);
		
	}
	
	//проверка договора
	try
    {
    $sql = 'SELECT id, name, type FROM clients WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
    }
    catch (PDOException $e)
    {
    $error = 'Error adding submitted author.';
    include 'error.html.php';
    exit();
    }
	$cname = $s -> fetch();
	if(!$cname)
	{	
	 echo 'Ошибка. Договор не найден </br>'.$cname['id'];
	 $fail = 1;
	}
	
	//если нет ошибок активируем
	if(isset($fail)) echo 'есть ошибки';
	
	else
	{
		$icd = '1825'.$_POST['iccid'];
		
		try
		{
			$sql = 'SELECT MAX(msisdn) FROM terminals limit 1';
			$s = $pdo->prepare($sql);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error adding submitted author.';
			include 'error.html.php';
			exit();
		}
		$msisdn = $s -> fetch();
		$msdn = $msisdn['MAX(msisdn)'] + 1;
		$sts = 'active';
		try
	  {
		$sql = 'INSERT INTO terminals SET
			iccid = :iccid,
			msisdn = :msisdn,
			technology = :tech,
			status = :status,
			rateplanid = :rateplanid,
			clientid = :clientid';
		$s = $pdo->prepare($sql);
		$s->bindValue(':iccid', $icd);
		$s->bindValue(':msisdn', $msdn);
		$s->bindValue(':tech', $_POST['tech']);
		$s->bindValue(':status', $sts);
		$s->bindValue(':rateplanid', $_POST['rateplan']);
		$s->bindValue(':clientid', $_POST['id']);
		$s->execute();
	  }
		catch (PDOException $e)
		  {
			$error = 'Error adding submitted author.';
			include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
			exit();
		  }

		try
		{
		  $sql = 'SELECT rateid, ratename FROM rateplan WHERE rateid = :rate';
		  $s = $pdo->prepare($sql);
		  $s->bindValue(':rate', $_POST['rateplan']);
		  $s->execute();
		  
		}
		catch (PDOException $e)
		{
		  $error = 'Error fetching from the database!';
		  include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
		  exit();
		}
		$rates = $s -> fetch(PDO::FETCH_ASSOC);

		try
		{
		  $sql = 'SELECT contactemail from fizdata WHERE clientid = :id';
		  $s = $pdo->prepare($sql);
		  $s->bindValue(':id', $_POST['id']);
		  $s->execute();
		  
		}
		catch (PDOException $e)
		{
		  $error = 'Error fetching from the database!';
		  include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
		  exit();
		}
		while($result = $s->fetch())
		{
			$a = $result['contactemail'];
		}
		
		
		try
		{
		  $sql = 'SELECT contactemail from urdata WHERE clientid = :id';
		  $s = $pdo->prepare($sql);
		  $s->bindValue(':id', $_POST['id']);
		  $s->execute();
		  
		}
		catch (PDOException $e)
		{
		  $error = 'Error fetching from the database!';
		  include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
		  exit();
		}
		while($result = $s->fetch())
		{
			$a = $result['contactemail'];
		}
		///////////////////////// шлём письмо
		//echo $mail['contactemail'];
		$mailto = $a;
		echo '<br>';
		require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;

			//$mail->SMTPDebug = 3;                               // Enable verbose debug output
			$mail->CharSet = "UTF-8";
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'billrobot';                 // SMTP username
			$mail->Password = 'qwert123';                           // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465;                                    // TCP port to connect to

			$mail->setFrom('billrobot@yandex.ru');
			$mail->addAddress($mailto);     // Add a recipient

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Activation complete!';
			$mail->Body    = '<div class="container">
    <h2>Активация прошла успешно</h2>
	<p style="text-decoration: underline;">Данные активации</p>
	<p>ICCID:'.'1825'.$_POST["iccid"].' </p>
	<p>MSISDN: '.$msdn.'  </p>
	<p>Технология: '.$_POST['tech'].' </p>
	<p>Статус: active</p>
	<p>Тариф: '.$rates['ratename'].' </p>
	<p>Клиент: '.$cname['name'].' </p>
	<p>Данные отправлены на почтовый ящик клиента: '.$mailto.' </p>	
	</br>
	</br>	
</div>';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} 
		
			
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/terminals/activation.html.php'; ;
		}
	
	exit();
}

////////////////////////
//////поиск
////////////////////////

if (isset($_GET['action']) and $_GET['action'] == "search")
{
	try
  {
    $sql = 'SELECT iccid, status FROM terminals WHERE iccid LIKE :text ORDER BY status ';
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
	  $terminals[] = array('iccid' => $row['iccid'],
						'status' => $row['status'],);
	}


	include $_SERVER['DOCUMENT_ROOT'] . '/includes/terminals/main.html.php';
	exit();
}


//////////////
////карточка терминала
//////////////

if (isset($_GET['info']))
{
		
		try
		  {
			$sql = 'SELECT iccid, msisdn, technology, status, ratename, name FROM terminals INNER JOIN clients ON clientid = id INNER JOIN rateplan ON rateplanid = rateid WHERE iccid = :iccid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':iccid', $_GET['iccid']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error fetching author details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }

	
	$row = $s->fetch();
	$pageTitle = 'Информация по терминалу';
	$action = '';
	$iccid = $row['iccid'];
	$msisdn = $row['msisdn'];
	$technology = $row['technology'];
	$status = $row['status'];
	$ratename = $row['ratename'];
	$name = $row['name'];
	$button = 'Ничего не делаю';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/terminals/info.html.php';
	exit();
	
	
	
}

////////////////////////
///Деактивация
//////////////////////////


if (isset($_POST['action']) and $_POST['action'] == 'Деактивировать')
{
	echo "деактивация";
	try
		  {
			$sql = 'UPDATE terminals SET status = "deactivated" WHERE iccid = :iccid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':iccid', $_POST['iccid']);
			$s->execute();
		  }
		catch (PDOException $e)
		  {
			$error = 'Error fetching author details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients/error.html.php';
			exit();
		  }
	echo "терминал деактивирован";	 
	header('Location: .');
	exit();
}




////////////////////
//Запрос вывода на главную
///////////////////

try
{
  $result = $pdo->query('SELECT iccid, status, name FROM terminals INNER JOIN clients ON id = clientid ORDER BY status');
}
catch (PDOException $e)
{
  $error = 'Error fetching from the database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $terminals[] = array('iccid' => $row['iccid'],
					'status' => $row['status'],
					'name' => $row['name'],
					);
}



include $_SERVER['DOCUMENT_ROOT'] . '/includes/terminals/main.html.php';








/*


echo "тест почты!";

require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'billrobot';                 // SMTP username
$mail->Password = 'qwert123';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('billrobot@yandex.ru');
$mail->addAddress('isollo@mail.ru');     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Mail test!';
$mail->Body    = 'MAMA <b>PRIVET!!!!!</b>';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
*/