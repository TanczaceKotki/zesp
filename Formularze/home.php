<?php breadcrumbs('O projekcie'); ?>
<h1 class="font20">O projekcie</h1>
<div class="col-lg-8">
	<div id="carousel-example-generic2" class="carousel slide">
		<?php /* Wskaźniki w postaci kropek */ ?>
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic2" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic2" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic2" data-slide-to="2"></li>
		</ol>
		<?php /* Slajdy */ ?>
		<div class="carousel-inner">
			<section class="item active">
				<img src="img1.png" alt="" />
				<?php /* Opis slajdu */ ?>
				<div class="carousel-caption">
					<h2>To jest opis</h2>
					<p>pierwszego slajdu</p>
				</div>
			</section>
			<section class="item">
				<img src="img2.png" alt="" />
				<?php /* Opis slajdu */ ?>
				<div class="carousel-caption">
					<h2>To jest opis</h2>
					<p>drugiego slajdu</p>
				</div>
			</section>
			<section class="item">
				<img src="img3.png" alt="" />
				<?php /* Opis slajdu */ ?>
				<div class="carousel-caption">
					<h2>To jest opis</h2>
					<p>trzeciego slajdu</p>
				</div>
			</section>
		</div>
		<?php /* Strzałki do przewijania */ ?>
		<a class="left carousel-control" href="#carousel-example-generic2" data-slide="prev">
			<span class="icon-prev"></span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic2" data-slide="next">
			<span class="icon-next"></span>
		</a>
	</div>
	<p class="margin_top_20 font15">Celem projektu jest klasyfikacja i organizacja sprzętu wydz. Fizyki, Astronomii i Informatyki Stosowanej UJ.</p>
</div>
<div class="col-lg-4 font15">
	<section>
		<h2 class="row font17">Ogłoszenia</h2>
		<ol class="ls_none pad_left_10">
			<li>Zakupiono nowy sprzęt</li>
		</ol>
	</section>
	<section>
		<h2 class="row font17 margin_top_20">Zarząd projektu</h2>
		<ol class="ls_none pad_left_10">
			<li>Dyrektor katedry</li>
		</ol>
	</section>
</div>
