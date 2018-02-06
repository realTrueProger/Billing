<?php

include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';

// 1. Парсим голосовой трафик
		
		// Парсим за текущий месяц, так что нужен год/месяц и список файлов из папки
		
		// testing
		
		echo $_SERVER['DOCUMENT_ROOT'];
		
		
		
		
		
		//год, месяц
		$curmonth = date('m'); // текущий месяц
		$curyear = date('Y'); // год
		
		//файлы из папки
		$cdrdoted = scandir($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'); //список файлов
		$cdrs = array_diff($cdrdoted, array('.','..','parsed')); //убираем лишние . и ..
		
		
		
		
		
		
		
		
		
		
		
		//Теперь нужно отпарсить все эти файлы и перекинуть их в другую папку
		$cdrcalls = array(); //массив данных cdr для загрузки в базу
		
		foreach ($cdrs as $cdr) //для каждого файла
		{
			
			$cdrfile = fopen($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.$cdr,'r');//открываем файл
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
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.'parsed'))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.'parsed');
			}
			
			rename($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.$cdr , $_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 'c' . '/'.'parsed'.'/'.$cdr );			
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
		$cdrdoted = scandir($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'); //список файлов
		$cdrs = array_diff($cdrdoted, array('.','..','parsed')); //убираем лишние . и ..
		
		//Теперь нужно отпарсить все эти файлы и перекинуть их в другую папку
		$cdrtraffic = array(); //массив данных cdr для загрузки в базу
		
		foreach ($cdrs as $cdr) //для каждого файла
		{
			
			$cdrfile = fopen($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.$cdr,'r');//открываем файл
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
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.'parsed'))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.'parsed');
			}
			
			rename($_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.$cdr , $_SERVER['DOCUMENT_ROOT'] . 'cdr/'.$curyear.'/'.$curmonth. '/' . 't' . '/'.'parsed'.'/'.$cdr );			
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
		
		
	
	
	echo "Parsing complete";
	exit();
