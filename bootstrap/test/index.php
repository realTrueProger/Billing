<?php 

try
{
	$dsn = 'mysql:host=localhost;dbname=billing; harset=utf8';
	$opt = array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_PERSISTENT => true);
	$pdo = new PDO($dsn , 'root' , 'root' , $opt);
}

catch (PDOException $e)
{
	echo 'error'.$e->getmessage().'/br';
}



try
{
$query = $pdo->query('SELECT contactemail FROM fizdata WHERE clientid = 2');
}

catch (PDOException $e)
{
	echo 'error'.$e->getmessage().'</br>';
}

while($result = $query->fetch())
{
	$a = $result['contactemail'];
}

try
{
	$query = $pdo->query('SELECT contactemail FROM urdata WHERE clientid = 2');
}

catch (PDOException $e)
{
	echo 'error'.$e->getmessage();
}

while($result = $query->fetch())
{
	$a = $result['contactemail'];
}
echo $a;
/*
foreach($query as $result)
{
	$users[] = array ('email' => $result['contactemail']);
}



print_r($users);
*/