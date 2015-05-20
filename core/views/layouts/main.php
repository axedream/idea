<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<?= $description ?>
		<?= $keywords ?>
		<title><?= $title ?></title>
		<?= $css ?>
		<?= $js ?>
		</head>
<body>
<div class="container boxShadowMain" id="conteiner" >
	<div class="row">
		<?= $header ?>
		<?= $menu ?>
		
		<div class="content">
			<?= $content ?>
		</div>
		
	
		<?= $footer ?>
		
	</div>
</div>	

	
	<?= $modal ?>
	
</body>
</html>
