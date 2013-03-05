<?php

	use Reinink\Buster\Buster;
	use Reinink\Utils\Config;

	$this->buster = new Buster(PUBLIC_PATH);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$this->title?> | Admin</title>
	<?=$this->buster->css('/css/admin.css')?>
</head>
<body id="<?=$this->id?>">

<div class="container">

	<div class="header">
		<h1><?=Config::get('admin::company')?></h1>
		<ul>
			<?php

				if (isset(Config::$values['admin::menu']))
				{
					// Sort the array by name
					usort(Config::$values['admin::menu'], function($a, $b)
					{
						return strnatcasecmp($a['name'], $b['name']);
					});

					// Display each menu item
					foreach (Config::get('admin::menu') as $item)
					{
						echo (strpos($_SERVER['REQUEST_URI'], $item['url']) === 0) ? '<li class="selected">' : '<li>';
						echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';
						echo '</li>';
					}
				}
			?>
			<li><a href="/">Visit Website</a></li>
			<li><a href="/admin/logout">Logout</a></li>
		</ul>
	</div>