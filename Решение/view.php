<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		* {
			margin: 0;
			padding: 0;
		}
		html, body {
			/* width: 1085px;
			height: 100%; */
			color: #000200;
			background-color: #edefeb;
			font-family: Verdana, Geneva, sans-serif; /* Не пойму, может и Verdana + font-weight: 400; */
		}
		p, a {
			padding: 10px;
		}
		h2 {
			padding: 10px;
			padding-top: 25px;
			padding-bottom: 5px;
			font-weight: 400;
		}
		.line_top {
			margin: 0 10px 10px 10px;
			border-bottom: 1px dotted #832b5b;
		}
		.link {
			padding-bottom: 20px;
		}
		a {
			color: #58198a;
			padding: 10px;
			display: flex;
		}
		.text {
		}
		.arrow {
			font-size: 0.9rem;
			line-height: 1.3rem;
		}
		.line_bottom {
			margin: 5px 20px 0 10px; /* Почему-то у нижней полосы такой справа отступ :/ */
			border-top: 1px dotted #832b5b;
		}
		main {
			width: 1000px;
			/* height: 100%; */
			background-color: #fefffc;
			border: 1px solid #caccc9;
			margin-top: 25px;
			margin-right: 35px;
			margin-bottom: 85px;
			margin-left: 45px;
		}
	</style>
</head>
<body>
	<main>
		<?php
		if (isset($_GET['id'])) {
			$post_id = str_replace(['<', '>'], '', $_GET['id']);
			
			$link = mysqli_connect("localhost", "root", "", "news");

			$query = "SELECT `title`, `content` FROM `news` WHERE `id` LIKE '$post_id';";
			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo '<h2>' . $row['title'] . '</h2><div class="line_top"></div>' . $row['content'];

			mysqli_free_result($result);
			mysqli_close($link);
		}
		?>
		<div class="line_bottom"></div>
		<div class="link">
			<a href="./news.php"><div class="text">Все новости&nbsp;</div><div class="arrow">>></div></a>
			<!-- Стрелки по высоте как маленькие буквы! -->
		</div>
	</main>
</body>
</html>
