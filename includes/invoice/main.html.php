<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap!
	========================================== -->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>
	<title>Биллинг</title>
  </head>

  <body>
  
  
  <!-- NAVBAR
================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] .
    '/includes/main/navbar.inc.php';?>
</br></br></br>
</br></br></br>


<!-- MAIN
================================================== -->
<div class="container">
	<a href="../">на главную<<</a>
    <h2>Управление счетами</h2>
	
	</br>
	</br>
	<p>Единый день выставления счетов: 1 число нового месяца.</p>
	<p>В целях демонстрации можно выставить счета прямо сейчас!</p>
	<form>
		<input class="btn btn-success" type="submit" name="action" value="Создать счета">
	</form>
	
	</br>
	</br>
	
	
	
	
	
	
	
	<h3>Все счета: </h3>
	<p>Вывод всех счетов:</p>
	<table class="table table-bordered table-hover">
		<tr>
			<th>Номер счёта</th>
			<th>Клиент</th>
			<th>Скачать счёт</th>
			<th>Сумма счёта</th>
			<th>Статус</th>
			<th>Ручная оплата</th>
			
		</tr>
		<?php foreach($invoicelist as $invlist): ?>
		<tr> 
			<td><?php htmlout($invlist['invoiceid']); ?></td>
			<td><?php htmlout($invlist['name']); ?></td>
			<td><a href="<?php htmlout($invlist['file']) ?>"><?php htmlout($invlist['file']); ?></a></td>
			<td><?php htmlout($invlist['sum']); ?></td>
			<td><?php if($invlist['status'] == 'не оплачен') htmlout($invlist['status']); else { htmlout($invlist['status']) ; echo '/ Дата оплаты: '.$invlist['payday']; } ?></td>
			<td>
			<?php if($invlist['status'] == 'не оплачен'):?>
			<a class="btn btn-success" href="?pay=<?php htmlout($invlist['invoiceid']); ?>" role="button">оплатить</a>
			<?php else:?>
			счёт оплачен
			<?php endif; ?>
			
			</td>
		</tr>
		
		<?php endforeach; ?>
		
	</table>
	
	
	
	
	<!--
	 <?php foreach($urikstoinvoice as $urik): ?>
	
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
    Счет № <?php echo $invoicenum; $invoicenum++; ?> от <?php echo date('d.m.Y'); ?></div>
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
                <?php echo $urik['name'];?>            </div>
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
    </tr>
	<?php $num= 1; ?> 
	<?php foreach($iptraffictotal as $traffic): ?>
	<?php if($traffic['id'] == $urik['id']): ?>
	
	<tr>
        <td style="width:10mm;"><?php echo $num; $num++; ?></td>
        <td>ip трафик по карте ICCID = <?php echo $traffic['iccid']?> </td>
        <td style="width:17mm;">Мб</td>
		<td style="width:20mm;"><?php echo $traffic['mb']?></td>
        <td style="width:27mm;"><?php echo $traffic['permb']?>,00</td>
        <td style="width:27mm;"><?php $rowsum = $traffic['mb'] * $traffic['permb']; echo $rowsum; $total[] = $rowsum; ?>,00</td>
    </tr>
	<?php endif; ?>
	<?php endforeach; ?>
	<?php foreach($voicetraffictotal as $voice): ?>
	<?php if($voice['id'] == $urik['id']): ?>
	
	<tr>
        <td style="width:10mm;"><?php echo $num; $num++; ?></td>
        <td>Минуты разговора по карте ICCID = <?php echo $voice['iccid']?> </td>
        <td style="width:17mm;">Мин</td>
		<td style="width:20mm;"><?php echo $voice['min']?></td>
        <td style="width:27mm;"><?php echo $voice['permin']?>,00</td>
        <td style="width:27mm;"><?php $rowsum = $voice['min'] * $voice['permin']; echo $rowsum; $total[] = $rowsum; ?>,00</td>
    </tr>
	<?php endif; ?>
	<?php endforeach; ?>
	
    </thead>
    <tbody >
    </tbody>
</table>




<table border="0" width="100%" cellpadding="1" cellspacing="1">
    <tr>
        <td></td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;"><?php echo array_sum($total); ?>.00</td>
    </tr>
</table>

<br />
<div>
Всего наименований <?php echo $num - 1; ?> на сумму <?php echo array_sum($total);  ?>.00 рублей.<br />
Сумма прописью: <?php echo num2str(array_sum($total)) ; unset($total); ?></div>
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
<br/><br/><br/><br/>
<?php endforeach; ?>












<?php foreach($fizikstoinvoice as $fizik): ?>
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
    Счет № <?php echo $invoicenum; $invoicenum++; ?> от <?php echo date('d.m.Y'); ?></div>
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
                <?php echo $fizik['name'];?>            </div>
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
    </tr>
	
	<?php foreach($iptraffictotal as $traffic): ?>
	<?php if($traffic['id'] == $fizik['id']): ?>
	
	
	<tr>
        <td style="width:10mm;">1</td>
        <td>ip трафик по карте ICCID = <?php echo $traffic['iccid']?> </td>
        <td style="width:17mm;">Мб</td>
		<td style="width:20mm;"><?php echo $traffic['mb']?></td>
        <td style="width:27mm;"><?php echo $traffic['permb']?>,00</td>
        <td style="width:27mm;"><?php $rowsum = $traffic['mb'] * $traffic['permb']; echo $rowsum; $total[] = $rowsum; ?>,00</td>
    </tr>
	<?php endif; ?>
	<?php endforeach; ?>
	<?php foreach($voicetraffictotal as $voice): ?>
	<?php if($voice['id'] == $fizik['id']): ?>
	
	<tr>
        <td style="width:10mm;"><?php echo $num; $num++; ?></td>
        <td>Минуты разговора по карте ICCID = <?php echo $voice['iccid']?> </td>
        <td style="width:17mm;">Мин</td>
		<td style="width:20mm;"><?php echo $voice['min']?></td>
        <td style="width:27mm;"><?php echo $voice['permin']?>,00</td>
        <td style="width:27mm;"><?php $rowsum = $voice['min'] * $voice['permin']; echo $rowsum; $total[] = $rowsum;  ?>,00</td>
    </tr>
	<?php endif; ?>
	<?php endforeach; ?>
	
    </thead>
    <tbody >
    </tbody>
</table>

<table border="0" width="100%" cellpadding="1" cellspacing="1">
    <tr>
        <td></td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;"><?php echo array_sum($total); ?>.00</td>
    </tr>
</table>

<br />
<div>
Всего наименований 1 на сумму <?php echo array_sum($total); ?>.00 рублей.<br />
Сумма прописью: <?php echo num2str(array_sum($total)) ; unset($total); ?></div>
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
<br/><br/><br/><br/>
<?php endforeach; ?>
</div> */

-->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>