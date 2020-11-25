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
		.post {
			padding: 10px;
		}
		.date {
			width: 80px;
			height: 20px;
			border: none;
			border: 0;
			outline: none;
			cursor: default;
			user-select: none; /* можно использовать как запрос на вывод новостей по дате */
			background-color: #832b5b;
			color: #fefffc;
		}
		a {
			color: #0006f2;
		}
		h2 {
			padding: 10px;
			padding-top: 25px;
			padding-bottom: 5px;
			font-weight: 400;
		}
		.line_top {
			margin: 0 10px 15px 10px;
			border-bottom: 1px dotted #832b5b;
		}
		.line_bottom {
			margin: 15px 10px 0 10px; 
			border-top: 1px dotted #832b5b;
		}
		h4 {
			padding: 10px;
			padding-bottom: 0;
		}
		form {
			padding: 10px;
			padding-bottom: 15px;
		}
		button {
			width: 31px;
			height: 17px;
			border: 1px solid #caccc9;
			background-color: #edefeb;
			color: #434542;
			cursor: pointer;
			margin: 2px;
		}
		.visited {
			border: 1px solid #caccc9;
			background-color: #832b5b;
			color: #fefffc;
		}
		main {
			width: 1000px;
			/* height: 100%; */
			background-color: #fefffc;
			border: 1px solid #caccc9;
			margin-top: 25px;
			margin-right: 35px;
			margin-bottom: 95px;
			margin-left: 45px;
		}
	</style>
</head>
<body>
	<main>
		<h2>Новости</h2>
		<div class="line_top"></div>
		<?php
		$link = mysqli_connect("localhost", "root", "", "news"); // Да-да, root без пароля.

		$query = "SELECT `id` FROM `news`;";
		$result = mysqli_query($link, $query);
		$row_count = mysqli_num_rows($result);
		$max_page = ceil($row_count / 5);

		if (isset($_GET['page'])) {
			$page_number = str_replace(['<', '>'], '', $_GET['page']); // Наверное я слишком буквально про скобки понял.
			if ($page_number < 1) {
				$page_number = 1;
			}
			if ($page_number > $max_page) {
				$page_number = $max_page;
			}
			$string_number = ($page_number - 1) * 5;
		} else {
			$page_number = 1;
			$string_number = 0;
		}

		$query = "SELECT `id`, `idate`, `title`, `announce` FROM `news` ORDER BY `idate` DESC LIMIT " . $string_number . ", 5;";
		$result = mysqli_query($link, $query);

		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$timestamp = $row['idate'];
			//$date = gmdate("d.m.Y", $timestamp); // Почему у меня дата минус день?! Из-за того, что возвращает время по Гринвичу (GMT)?
			$date = date("d.m.Y", $timestamp);
			echo '<div class="post"><button class="date">' . $date . '</button>&nbsp;<a href="./view.php?id=<' . $row['id'] . '>">' . $row['title'] . '</a><br />' . $row['announce'] . '</div>'; // А почему бы и не так, GET-ссылки тем и удобны, что можно без формы использовать. 
		}
		?>
		<div class="line_bottom"></div>
		<h4>Страницы:</h4>
		<?php
		echo '<form action="news.php" method="get">';

		for ($i = 1; $i <= $max_page; $i++) {
			if ($i == $page_number) {
				echo '<button type="submit" name="page" value="<' . $i . '>" class="visited">' . $i . '</button>';
			} else {
				echo '<button type="submit" name="page" value="<' . $i . '>">' . $i . '</button>';
			}
		}

		echo '</form>';

		mysqli_free_result($result);
		mysqli_close($link);
		?>
	</main>
</body>
</html>