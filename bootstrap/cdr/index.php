<?php 
/////////////////CDR index


include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';






///////////////////
/////Генератор трафика
//////////////////////

if (isset($_GET['generator']))
{	
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/cdr/generator.html.php';
	exit();
}

////////////////////////////////
///Создание cdr для голоса
///////////////////////////////
	
	if(isset($_POST['num']) and isset($_POST['min']) and isset($_POST['iccid']) and isset($_POST['datetime'])  )
	{	
		echo "Тесты!<br/>";
		
		//////////////////////////////////////////
		/////////////////создаём файл
		$filename= str_replace(':' , '-' , $_POST['datetime']); // меняем : на - , потому что нельзя : в имени файла
		
		//проверка наличия папок
		$delt= preg_replace("/(T.*)$/", "", $filename); //убрать все после Т
		$datearray = explode('-', $delt); //кидаем год месяц день в массив
		//если нет папки с годом, то создать
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0]))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0]);
		}
		//если нет папки с месяцем, то создать
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1]))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1]);
		}
		//если нет папки с типом, то создать
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1].'/'.$_POST['type']))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1].'/'.$_POST['type']);
		}
		
		
		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1]. '/' . $_POST['type'] . '/' . $filename . '.txt','w');
		$cdr = 'iccid='.$_POST['iccid'].'%'.'num='.$_POST['num'].'%'.'min='.$_POST['min'].'%'.'datetime='.$_POST['datetime']; //строка в файл
		fwrite($fp, $cdr);
		fclose($fp);
        
		echo "cdr успешно создан";
		echo "А тип равен=". $_POST['type'];
		header('Location: .');
		
	}
////////////////////////////////
///Создание cdr для трафика
///////////////////////////////
	
	if(isset($_POST['port']) and isset($_POST['host']) and isset($_POST['iccid']) and isset($_POST['datetime'])  )
	{	
		echo "Тесты!<br/>";
		
		//////////////////////////////////////////
		/////////////////создаём файл
		$filename= str_replace(':' , '-' , $_POST['datetime']); // меняем : на - , потому что нельзя : в имени файла
		
		//проверка наличия папок
		$delt= preg_replace("/(T.*)$/", "", $filename); //убрать все после Т
		$datearray = explode('-', $delt); //кидаем год месяц день в массив
		//если нет папки с годом, то создать
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0]))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0]);
		}
		//если нет папки с месяцем, то создать
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1]))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1]);
		}
		//если нет папки с типом, то создать
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1].'/'.$_POST['type']))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1].'/'.$_POST['type']);
		}
		
		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$datearray[0].'/'.$datearray[1]. '/' . $_POST['type'] . '/' . $filename . '.txt','w');
		$cdr = 'iccid='.$_POST['iccid'].'%'.'port='.$_POST['port'].'%'.'host='.$_POST['host'].'%'.'mb='.$_POST['mb'].'%'.'datetime='.$_POST['datetime']; //строка в файл
		fwrite($fp, $cdr);
		fclose($fp);
        
		echo "cdr успешно создан";
		echo "А тип равен=". $_POST['type'];
		header('Location: .');
		
	}
		
///////////////////////////////////
/////////Parser
//////////////////////////////////

if (isset($_GET['parser']))
{
	if(isset($_POST['parser']))
	{
		
		$message = "Новый трафик успешно добавлен в систему."; //сообщение на экран
		
		// 1. Парсим голосовой трафик
		
		// Парсим за текущий месяц, так что нужен год/месяц и список файлов из папки
		
		//год, месяц
		$curmonth = date('m'); // текущий месяц
		$curyear = date('Y'); // год
		
		//файлы из папки
		$cdrdoted = scandir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'); //список файлов
		$cdrs = array_diff($cdrdoted, array('.','..','parsed')); //убираем лишние . и ..
		
		
		//Теперь нужно отпарсить все эти файлы и перекинуть их в другую папку
		$cdrcalls = array(); //массив данных cdr для загрузки в базу
		
		foreach ($cdrs as $cdr) //для каждого файла
		{
			
			$cdrfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.$cdr,'r');//открываем файл
			$cdrdata = fgets($cdrfile); // строка с содержимым
			
			$cdrarr = explode('%',$cdrdata); //рубим по проценту и создаём массив со значениями вида iccid=n и тд
			
			
			$xtemp = array();
			
			foreach($cdrarr as $cdrarr1) // для каждой пары, например iccid=n
			{
				list($key, $value) = explode('=', $cdrarr1);
				$xtemp[$key] = $value;
				
			}
			
			$cdrcalls[] = $xtemp;
			fclose($cdrfile); // закрыть файл
			//копируем файл в папку parsed
			
			//если нет папки парсера, то создать
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.'parsed'))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.'parsed');
			}
			
			rename($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.$cdr , $_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.'parsed'.'/'.$cdr );			
		}
		
			
		// загрузка в БД
			
			foreach($cdrcalls as $uploadcdrcalls)
			{
			try
			  {
				$sql = 'INSERT INTO cdrdetailedcalls SET
					iccid = :iccid,
					number = :num,
					min = :min,
					datetime = :datetime';
				$s = $pdo->prepare($sql);
				$s->bindValue(':iccid', $uploadcdrcalls['iccid']);
				$s->bindValue(':num', $uploadcdrcalls['num']);
				$s->bindValue(':min', $uploadcdrcalls['min']);
				$s->bindValue(':datetime', $uploadcdrcalls['datetime']);
				$s->execute();
			  }
			  catch (PDOException $e)
			  {
				$error = 'Error adding submitted author.';
				include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
				exit();
			  }
			}
		
		
		// 2. Парсим ip трафик
		//файлы из папки
		$cdrdoted = scandir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'); //список файлов
		$cdrs = array_diff($cdrdoted, array('.','..','parsed')); //убираем лишние . и ..
		
		//Теперь нужно отпарсить все эти файлы и перекинуть их в другую папку
		$cdrtraffic = array(); //массив данных cdr для загрузки в базу
		
		foreach ($cdrs as $cdr) //для каждого файла
		{
			
			$cdrfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.$cdr,'r');//открываем файл
			$cdrdata = fgets($cdrfile); // строка с содержимым
			
			$cdrarr = explode('%',$cdrdata); //рубим по проценту и создаём массив со значениями вида iccid=n и тд
			
			
			$xtemp = array();
			
			foreach($cdrarr as $cdrarr1) // для каждой пары, например iccid=n
			{
				list($key, $value) = explode('=', $cdrarr1);
				$xtemp[$key] = $value;
				
			}
			
			$cdrtraffic[] = $xtemp;
			fclose($cdrfile); // закрыть файл
			//копируем файл в папку parsed
			
			//если нет папки парсера, то создать
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.'parsed'))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.'parsed');
			}
			
			rename($_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.$cdr , $_SERVER['DOCUMENT_ROOT'] . '/cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.'parsed'.'/'.$cdr );			
		}
		
			
		// загрузка в БД
			
			foreach($cdrtraffic as $uploadcdrtraffic)
			{
			try
			  {
				$sql = 'INSERT INTO cdrdetailedtraffic SET
					iccid = :iccid,
					port = :port,
					host = :host,
					mb = :mb,
					datetime = :datetime';
				$s = $pdo->prepare($sql);
				$s->bindValue(':iccid', $uploadcdrtraffic['iccid']);
				$s->bindValue(':port', $uploadcdrtraffic['port']);
				$s->bindValue(':host', $uploadcdrtraffic['host']);
				$s->bindValue(':mb', $uploadcdrtraffic['mb']);
				$s->bindValue(':datetime', $uploadcdrtraffic['datetime']);
				$s->execute();
			  }
			  catch (PDOException $e)
			  {
				$error = 'Error adding submitted author.';
				include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
				exit();
			  }
			}
		
		
	}
	
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/cdr/parser.html.php';
	exit();
}



///////////////////////////////////
//////Детализация
/////////////////////////////////////


if (isset($_GET['detailes']))
{
	if (isset($_POST['iccid']))
	{
		try
			  {
				$sql = 'SELECT number, min, datetime FROM `cdrdetailedcalls` WHERE iccid = :iccid';
				$s = $pdo->prepare($sql);
				$s->bindValue(':iccid', $_POST['iccid']);
				$s->execute();
			  }
			  catch (PDOException $e)
			  {
				$error = 'Error adding submitted author.';
				include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
				exit();
			  }
			  
			  foreach($s as $row)
			  {
			  $voice[] = array('number' => $row['number'],
								'min' => $row['min'],
								'datetime' => $row['datetime'],);
			  }	
		
		try
			  {
				$sql = 'SELECT port, host, mb, datetime FROM `cdrdetailedtraffic` WHERE iccid = :iccid';
				$s = $pdo->prepare($sql);
				$s->bindValue(':iccid', $_POST['iccid']);
				$s->execute();
			  }
			  catch (PDOException $e)
			  {
				$error = 'Error adding submitted author.';
				include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
				exit();
			  }
			  
			  foreach($s as $row)
			  {
			  $traffic[] = array('port' => $row['port'],
								'host' => $row['host'],
								'mb' => $row['mb'],
								'datetime' => $row['datetime'],);
			  }			  
			   
	}

	include $_SERVER['DOCUMENT_ROOT'] . '/includes/cdr/detailes.html.php';
	exit();
	
}


//////////////////////////////////
//////главная
/////////////////////////////////


include $_SERVER['DOCUMENT_ROOT'] . '/includes/cdr/main.html.php';