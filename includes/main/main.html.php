<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Styles
	========================================== -->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapstyles.inc.php';?>
	
	<title>Биллинг</title>
  </head>

  <body>
  
    <!-- NAVBAR
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] .
    '/includes/main/navbar.inc.php';?>


    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <img src="/includes/main/logo.png">
			  <h1>Добро пожаловать в биллинговую систему АРС "Биллинг" !</h1>
              <p>Ниже представлены основные модули программы.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Узнать больше</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Это блок новостей.</h1>
              <p>Здесь будут полезные новости. Например готовность проекта 4/6</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Другие новости</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Поддержка</h1>
              <p>По любым вопросам обращайтесь на почтовый ящик billrobot@yandex.ru</p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->


    <!-- Главная
    ================================================== -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img  src="/img/images.png"  width="200" height="170">
          <h2>Клиенты</h2>
          <p>Модуль управления клиентами.</p>
          <p><a class="btn btn-success" href="clients/" role="button">Войти! &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img  src="/img/rates.png"  width="300" height="170">
          <h2>Тарифы</h2>
          <p>Модуль управления тарифами.</p>
          <p><a class="btn btn-success" href="rates/" role="button">Войти! &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img  src="/img/sat.jpg"  width="170" height="170">
          <h2>Терминалы</h2>
          <p>Модуль управления терминалами.</p>
          <p><a class="btn btn-success" href="terminals/" role="button">Войти! &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
	  
	  <div class="row">
        <div class="col-lg-4">
          <img  src="/img/cdr2.jpg"  width="170" height="170">
          <h2>CDR</h2>
          <p>Генерация и учёт трафика.</p>
          <p><a class="btn btn-success" href="cdr/" role="button">Войти! &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img  src="/img/inv4.png"  width="170" height="170">
          <h2>Счета</h2>
          <p>Модуль управления счетами.</p>
          <p><a class="btn btn-success" href="invoice/" role="button">Войти! &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img  src="/img/cfg3.png"  width="170" height="170">
          <h2>Настройки</h2>
          <p>Панель управления администратора.</p>
          <p><a class="btn btn-success" href="config/" role="button">Войти! &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/main/bootstrapjs.inc.php';?>
  </body>
</html>