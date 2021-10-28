<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Zadanie</title>
	</head>

	<body> 
		<?php
			$link_db = false;
			require_once "work_db.php";
			require_once "sql_text.php"
		?>
		
		<div><h1>Статистика выполненой работы горничной </h1></div>
		<table border="1">
			<tr>
				<td>
					Дата
				</td>
				<td>
					Начало
				</td>
				<td>
					Конец
				</td>
				<td>
					Генеральная
				</td>
				<td>
					Текущая
				</td>
				<td>
					Заезд
				</td>
				<td>
					Сумма
				</td>
			</tr>

		<?php

			$rows = run_sql($sql1);
			
			foreach ($rows as $row) {
			    print("<tr><td><a href=\"ondate.php?d=" . $row['work_date'] . "\">" . $row['work_date'] . "</a></td><td>" . $row['time_start'] . "</td><td>" . $row['time_end'] . "</td><td>" . $row['gen'] . "</td><td>" . $row['tek'] . "</td><td>" . $row['zaezd'] . "</td><td>" . $row['work_rcost'] + $row['work_bed'] * 30 + $row['work_towels'] * 10 . "</td></tr>");
			}
		?>

		</table>
	</body>
</html>