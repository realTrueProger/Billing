<?php 

////////////////
//invoice index
include $_SERVER['DOCUMENT_ROOT'] . '/includes/login/login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/db.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/billing/magicquotes.inc.php';
include '../vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

///////////////////////////////////////
////////Выставляем счета!
///////////////////////////////////////


//список клиентов юр лиц с трафиком


try
{
  $result = $pdo->query('SELECT DISTINCT clients.id, clients.name, contactemail from clients INNER JOIN terminals ON clients.id = clientid INNER JOIN urdata ON clients.id = urdata.clientid WHERE type = \'u\' AND (terminals.iccid IN (SELECT iccid from cdrdetailedcalls) OR terminals.iccid IN (SELECT iccid from cdrdetailedtraffic) )');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach($result as $row)
{
	$urikstoinvoice[] = array('id' => $row['id'],
	                            'name' => $row['name'],
								'email' => $row['contactemail']);
}

//список клиентов физ лиц с трафиком


try
{
  $result = $pdo->query('SELECT DISTINCT clients.id, clients.name, contactemail from clients INNER JOIN terminals ON clients.id = clientid INNER JOIN fizdata ON clients.id = fizdata.clientid WHERE type = \'f\' AND (terminals.iccid IN (SELECT iccid from cdrdetailedcalls) OR terminals.iccid IN (SELECT iccid from cdrdetailedtraffic) )');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach($result as $row)
{
	$fizikstoinvoice[] = array('id' => $row['id'],
	                            'name' => $row['name'],
								'email' => $row['contactemail']);
}
///ip трафик

try
{
  $result = $pdo->query('SELECT clients.id, cdrdetailedtraffic.iccid, permb, sum(mb) AS mb FROM cdrdetailedtraffic INNER JOIN terminals ON cdrdetailedtraffic.iccid = terminals.iccid INNER JOIN clients on clients.id = clientid INNER JOIN rateplan ON rateplan.rateid = terminals.rateplanid GROUP BY iccid ORDER BY clients.id');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach($result as $row)
{
	$iptraffictotal[] = array('id' => $row['id'],
	                            'iccid' => $row['iccid'],
								'permb' => $row['permb'],
								'mb' => $row['mb']);
}

///voice трафик

try
{
  $result = $pdo->query('SELECT clients.id, cdrdetailedcalls.iccid, permin, sum(min) AS min FROM cdrdetailedcalls INNER JOIN terminals ON cdrdetailedcalls.iccid = terminals.iccid INNER JOIN clients on clients.id = clientid INNER JOIN rateplan ON terminals.rateplanid = rateplan.rateid GROUP BY iccid ORDER BY clients.id');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach($result as $row)
{
	$voicetraffictotal[] = array('id' => $row['id'],
	                            'iccid' => $row['iccid'],
								'permin' => $row['permin'],
								'min' => $row['min']);
}

//////номер счёта

try
{
  $result = $pdo->query('select max(invoiceid) from invoice');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

$row = $result -> fetch();
$invoicenum = $row['0'];
$invoicenum++;

////////дата
$curdate = date('d.m.Y'); //дата




///////////////////////////
//////Выставляем счета
///////////////////////////
if (isset($_GET['action']) and $_GET['action'] == 'Создать счета')
{
	
	
/////////////////////сначала юрики
	foreach($urikstoinvoice as $urik)
	{
	
	/////////////формируем счет
	$html = '
	<!doctype html>
			<html>
			<head>
				<title>Бланк "Счет на оплату"</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<style>
					body { width: 200mm; font-family: DejaVu Sans; margin-left: auto; margin-right: auto; font-size: 9pt;} 
					table.invoice_bank_rekv { border-collapse: collapse; border: 1px solid; }
					table.invoice_bank_rekv > tbody > tr > td, table.invoice_bank_rekv > tr > td { border: 1px solid; }
					table.invoice_items { border: 1px solid; border-collapse: collapse;}
					table.invoice_items td, table.invoice_items th { border: 1px solid;}
				</style>
			</head>
			<body>
			<table width="100%">
				<tr>
					<td><img src="logo.png"></td>
					<td style="width: 155mm;">
						<div style="width:155mm; ">Внимание! Оплата данного счета должна быть произведена в срок, указанный в договоре. </div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="text-align:center;  font-weight:bold;">
							Образец заполнения платежного поручения                                                                                                                                            </div>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
				<tr>
					<td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
							<tr>
								<td valign="top">
									<div>Банк получателя</div>
								</td>
							</tr>
							<tr>
								<td valign="bottom" style="height: 3mm;">
									<div style="font-size:10pt;">ОАО «Банк Надёжный», г. Москва        </div>
								</td>
							</tr>
						</table>
					</td>
					<td style="min-height:7mm;height:auto; width: 25mm;">
						<div>БИK</div>
					</td>
					<td rowspan="2" style="vertical-align: top; width: 60mm;">
						<div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">04580577</div>
						<div>3010100000000000001</div>
					</td>
				</tr>
				<tr>
					<td style="width: 25mm;">
						<div>Сч. №</div>
					</td>
				</tr>
				<tr>
					<td style="min-height:6mm; height:auto; width: 50mm;">
						<div>ИНН 1234567891</div>
					</td>
					<td style="min-height:6mm; height:auto; width: 55mm;">
						<div>КПП 123456789 </div>
					</td>
					<td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
						<div>Сч. №</div>
					</td>
					<td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
						<div>40702810500000000001</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="min-height:13mm; height:auto;">

						<table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
							<tr>
								<td valign="top">
									<div>Получатель</div>
								</td>
							</tr>
							<tr>
								<td valign="bottom" style="height: 3mm;">
									<div style="font-size: 10pt;">ООО "АРС Биллинг"</div>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
			<br/>
			
			<div style="font-weight: bold; font-size: 16pt; padding-left:5px;">
				Счет № '.$invoicenum.' от '.$curdate.'</div>
			<br/>

			<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
			
			<table width="100%">
				<tr>
					<td style="width: 30mm;">
						<div style=" padding-left:2px;">Поставщик:    </div>
					</td>
					<td>
						<div style="font-weight:bold;  padding-left:2px;">
							ООО "АРС Биллинг" г. Москва </div>
					</td>
				</tr>
				<tr>
					<td style="width: 30mm;">
						<div style=" padding-left:2px;">Покупатель:    </div>
					</td>
					<td>
						<div style="font-weight:bold;  padding-left:2px;">
							'.$urik["name"].'            </div>
					</td>
				</tr>
			</table>
			
			<table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
			<thead>
			<tr>
				<th style="width:10mm;">№</th>
				<th>Товары (работы, услуги)</th>
				<th style="width:17mm;">Ед.</th>
				<th style="width:20mm;">Кол-во</th>
				<th style="width:27mm;">Цена</th>
				<th style="width:27mm;">Сумма</th>
			</tr>';
			$num= 1; //номер позиции
			foreach($iptraffictotal as $traffic)
			{
				if($traffic["id"] == $urik["id"])
				{
			$html.='
			<tr>
				<td style="width:10mm;">'.$num;
				$num++;
				$html.='</td>
				<td>ip трафик по карте ICCID = '.$traffic["iccid"].' </td>
				<td style="width:17mm;">Мб</td>
				<td style="width:20mm;">'.$traffic["mb"].'</td>
				<td style="width:27mm;">'.$traffic["permb"].',00</td>
				<td style="width:27mm;">';
				$rowsum = $traffic["mb"] * $traffic["permb"];
				$html.= $rowsum.',00</td>';
				$total[] = $rowsum;
				$html.='</tr>';
				}
			}
			
			
			 foreach($voicetraffictotal as $voice)
			 {
			 if($voice["id"] == $urik["id"])
			 {
			
			$html.='<tr>
				<td style="width:10mm;">'.$num.'</td>';
				$num++;
				$html.='<td>Минуты разговора по карте ICCID = '.$voice["iccid"].' </td>
				<td style="width:17mm;">Мин</td>
				<td style="width:20mm;">'.$voice["min"].'</td>
				<td style="width:27mm;">'.$voice["permin"].',00</td>
				<td style="width:27mm;">';
				$rowsum = $voice["min"] * $voice["permin"];
				$html.=$rowsum.',00</td>';
				$total[] = $rowsum;
			$html.='</tr>';
			
			 }
			 }
			
			$html.='</thead>
			<tbody >
			</tbody>
			</table>';
			$numtotal = $num-1;
			$totalsum = array_sum($total);
			$sumpropis = num2str(array_sum($total));
			
			$html.='
			<table border="0" width="100%" cellpadding="1" cellspacing="1">
			<tr>
				<td></td>
				<td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
				<td style="width:27mm; font-weight:bold;  text-align:right;">'.$totalsum.'.00</td>
			</tr>
		</table>
			';
			$html.='
			<br />
			<div>
			Всего наименований '. $numtotal.' на сумму '.$totalsum.'.00 рублей.<br />
			Сумма прописью: '.$sumpropis.'</div>
			<br /><br />
			<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
			<br/>

			<div>Руководитель ______________________ (Фамилия И.О.)</div>
			<br/>

			<div>Главный бухгалтер ______________________ (Фамилия И.О.)</div>
			<br/>

			<div style="width: 85mm;text-align:center;">М.П.</div>
			<br/>


			<div style="width:800px;text-align:left;font-size:10pt;">Счет действителен к оплате в течении 10 рабочих дней.</div>
			<br/><br/><br/><br/>';
			
		
	/////////////////////////////создаём счёт в PDF
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->render();
	$output = $dompdf->output();
	file_put_contents('invoices/Invoice '.$invoicenum.'.pdf', $output);
	
	/////////////////////////////шлём счёт на почту клиенту
	$mailto = $urik['email'];
		

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

			$mail->addAttachment('invoices/Invoice '.$invoicenum.'.pdf');         // Add attachments
			$mail->Subject = 'Activation complete!';
			$mail->Body    = '<div class="container">
			<p>Добрый день!</p>
			<p>В приложении счёт за услуги связи АРС "Биллинг" для клиента '.$urik['name'].'</p>
			</div>';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} 
	////////добавляем счёт в БД
	$file = 'invoices/Invoice '.$invoicenum.'.pdf';
	try
	  {
		$sql = 'INSERT INTO invoice SET
			invoiceid = :invoiceid,
			clientid = :clientid,
			file = :file,
			sum = :sum,
			status = "не оплачен"';
		$s = $pdo->prepare($sql);
		$s->bindValue(':invoiceid', $invoicenum);
		$s->bindValue(':clientid', $urik['id']);
		$s->bindValue(':file', $file);
		$s->bindValue(':sum', $totalsum);
		$s->execute();
	  }
		catch (PDOException $e)
		  {
			$error = 'Error adding submitted author.';
			include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
			exit();
		  }
	
	
	
	$invoicenum++; //инкремент номера счета
	unset($total); //обнуляем сумму счёта
	}
	
	/////////////////////////////////////////////////////////////////////////////
	///////////физики
	foreach($fizikstoinvoice as $fizik)
	{
	
	/////////////формируем счет
	$html = '
	<!doctype html>
			<html>
			<head>
				<title>Бланк "Счет на оплату"</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<style>
					body { width: 200mm; font-family: DejaVu Sans; margin-left: auto; margin-right: auto; font-size: 9pt;} 
					table.invoice_bank_rekv { border-collapse: collapse; border: 1px solid; }
					table.invoice_bank_rekv > tbody > tr > td, table.invoice_bank_rekv > tr > td { border: 1px solid; }
					table.invoice_items { border: 1px solid; border-collapse: collapse;}
					table.invoice_items td, table.invoice_items th { border: 1px solid;}
				</style>
			</head>
			<body>
			<table width="100%">
				<tr>
					<td><img src="logo.png"></td>
					<td style="width: 155mm;">
						<div style="width:155mm; ">Внимание! Оплата данного счета должна быть произведена в срок, указанный в договоре. </div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="text-align:center;  font-weight:bold;">
							Образец заполнения платежного поручения                                                                                                                                            </div>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
				<tr>
					<td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
							<tr>
								<td valign="top">
									<div>Банк получателя</div>
								</td>
							</tr>
							<tr>
								<td valign="bottom" style="height: 3mm;">
									<div style="font-size:10pt;">ОАО «Банк Надёжный», г. Москва        </div>
								</td>
							</tr>
						</table>
					</td>
					<td style="min-height:7mm;height:auto; width: 25mm;">
						<div>БИK</div>
					</td>
					<td rowspan="2" style="vertical-align: top; width: 60mm;">
						<div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">04580577</div>
						<div>3010100000000000001</div>
					</td>
				</tr>
				<tr>
					<td style="width: 25mm;">
						<div>Сч. №</div>
					</td>
				</tr>
				<tr>
					<td style="min-height:6mm; height:auto; width: 50mm;">
						<div>ИНН 1234567891</div>
					</td>
					<td style="min-height:6mm; height:auto; width: 55mm;">
						<div>КПП 123456789 </div>
					</td>
					<td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
						<div>Сч. №</div>
					</td>
					<td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
						<div>40702810500000000001</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="min-height:13mm; height:auto;">

						<table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
							<tr>
								<td valign="top">
									<div>Получатель</div>
								</td>
							</tr>
							<tr>
								<td valign="bottom" style="height: 3mm;">
									<div style="font-size: 10pt;">ООО "АРС Биллинг"</div>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
			<br/>
			
			<div style="font-weight: bold; font-size: 16pt; padding-left:5px;">
				Счет № '.$invoicenum.' от '.$curdate.'</div>
			<br/>

			<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
			
			<table width="100%">
				<tr>
					<td style="width: 30mm;">
						<div style=" padding-left:2px;">Поставщик:    </div>
					</td>
					<td>
						<div style="font-weight:bold;  padding-left:2px;">
							ООО "АРС Биллинг" г. Москва </div>
					</td>
				</tr>
				<tr>
					<td style="width: 30mm;">
						<div style=" padding-left:2px;">Покупатель:    </div>
					</td>
					<td>
						<div style="font-weight:bold;  padding-left:2px;">
							'.$fizik["name"].'            </div>
					</td>
				</tr>
			</table>
			
			<table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
			<thead>
			<tr>
				<th style="width:10mm;">№</th>
				<th>Товары (работы, услуги)</th>
				<th style="width:17mm;">Ед.</th>
				<th style="width:20mm;">Кол-во</th>
				<th style="width:27mm;">Цена</th>
				<th style="width:27mm;">Сумма</th>
			</tr>';
			$num= 1; //номер позиции
			foreach($iptraffictotal as $traffic)
			{
				if($traffic["id"] == $fizik["id"])
				{
			$html.='
			<tr>
				<td style="width:10mm;">'.$num;
				$num++;
				$html.='</td>
				<td>ip трафик по карте ICCID = '.$traffic["iccid"].' </td>
				<td style="width:17mm;">Мб</td>
				<td style="width:20mm;">'.$traffic["mb"].'</td>
				<td style="width:27mm;">'.$traffic["permb"].',00</td>
				<td style="width:27mm;">';
				$rowsum = $traffic["mb"] * $traffic["permb"];
				$html.= $rowsum.',00</td>';
				$total[] = $rowsum;
				$html.='</tr>';
				}
			}
			
			
			 foreach($voicetraffictotal as $voice)
			 {
			 if($voice["id"] == $fizik["id"])
			 {
			
			$html.='<tr>
				<td style="width:10mm;">'.$num.'</td>';
				$num++;
				$html.='<td>Минуты разговора по карте ICCID = '.$voice["iccid"].' </td>
				<td style="width:17mm;">Мин</td>
				<td style="width:20mm;">'.$voice["min"].'</td>
				<td style="width:27mm;">'.$voice["permin"].',00</td>
				<td style="width:27mm;">';
				$rowsum = $voice["min"] * $voice["permin"];
				$html.=$rowsum.',00</td>';
				$total[] = $rowsum;
			$html.='</tr>';
			
			 }
			 }
			
			$html.='</thead>
			<tbody >
			</tbody>
			</table>';
			$numtotal = $num-1;
			$totalsum = array_sum($total);
			$sumpropis = num2str(array_sum($total));
			
			$html.='
			<table border="0" width="100%" cellpadding="1" cellspacing="1">
			<tr>
				<td></td>
				<td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
				<td style="width:27mm; font-weight:bold;  text-align:right;">'.$totalsum.'.00</td>
			</tr>
		</table>
			';
			$html.='
			<br />
			<div>
			Всего наименований '. $numtotal.' на сумму '.$totalsum.'.00 рублей.<br />
			Сумма прописью: '.$sumpropis.'</div>
			<br /><br />
			<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
			<br/>

			<div>Руководитель ______________________ (Фамилия И.О.)</div>
			<br/>

			<div>Главный бухгалтер ______________________ (Фамилия И.О.)</div>
			<br/>

			<div style="width: 85mm;text-align:center;">М.П.</div>
			<br/>


			<div style="width:800px;text-align:left;font-size:10pt;">Счет действителен к оплате в течении 10 рабочих дней.</div>
			<br/><br/><br/><br/>';
			
		
	/////////////////////////////создаём счёт в PDF
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->render();
	$output = $dompdf->output();
	file_put_contents('invoices/Invoice '.$invoicenum.'.pdf', $output);
	
	/////////////////////////////шлём счёт на почту клиенту
	$mailto = $fizik['email'];
		

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
			$mail->addAttachment('invoices/Invoice '.$invoicenum.'.pdf');         // Add attachments
			$mail->Subject = 'Activation complete!';
			$mail->Body    = '<div class="container">
			<p>Добрый день!</p>
			<p>В приложении счёт за услуги связи АРС "Биллинг" для клиента '.$fizik['name'].'</p>
			</div>';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} 
	
	////////добавляем счёт в БД
	$file = 'invoices/Invoice '.$invoicenum.'.pdf';
	try
	  {
		$sql = 'INSERT INTO invoice SET
			invoiceid = :invoiceid,
			clientid = :clientid,
			file = :file,
			sum = :sum,
			status = "не оплачен"';
		$s = $pdo->prepare($sql);
		$s->bindValue(':invoiceid', $invoicenum);
		$s->bindValue(':clientid', $fizik['id']);
		$s->bindValue(':file', $file);
		$s->bindValue(':sum', $totalsum);
		$s->execute();
	  }
		catch (PDOException $e)
		  {
			$error = 'Error adding submitted author.';
			include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
			exit();
		  }
	
	
	$invoicenum++; //инкремент номера счета
	unset($total); //обнуляем сумму счёта
	}
	
	
	
	header('Location: ./');
	exit();
}













/////////////////////
//Оплата счёта
/////////////////////


if(isset($_GET['pay']))
{
	echo 'оплачено!! <br>
Номер счёта'.$_GET['pay'];

try
	  {
		$sql = 'UPDATE invoice SET status = "Оплачен", payday = CURDATE() WHERE invoiceid = :invoiceid';
		$s = $pdo->prepare($sql);
		$s->bindValue(':invoiceid', $_GET['pay']);
		$s->execute();
	  }
		catch (PDOException $e)
		  {
			$error = 'Error adding submitted author.';
			include $_SERVER['DOCUMENT_ROOT'] .'/includes/main/error.html.php';
			exit();
		  }
	
	exit();
}





////////////////////
//Запрос вывода всех счетов на главную
///////////////////

try
{
  $result = $pdo->query('SELECT invoiceid, name, file, sum, status, payday FROM invoice INNER JOIN clients ON clientid = id ORDER BY invoiceid');
}
catch (PDOException $e)
{
  $error = 'Error fetching authors from the database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $invoicelist[] = array('invoiceid' => $row['invoiceid'],
					'name' => $row['name'],
					'file' => $row['file'],
					'sum' => $row['sum'],
					'payday' => $row['payday'],
					'status' => $row['status']);
}


/////////////////////////////////////////////
//////Главная
///////////////////////////////////////////


include $_SERVER['DOCUMENT_ROOT'] . '/includes/invoice/main.html.php'; 



