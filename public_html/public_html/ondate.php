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
			require_once "sql_text.php";
		
		
			if(isset($_GET['d']))
			{
				$d = $_GET['d'];
			}
		
		
		?>
		
		<div><h1>Выполненная работа горничной за <?php echo $d?> </h1></div>
		<a href="index.php">Назад</a>
		<table border="1">
			<tr>
				<td>
					Номер
				</td>
				<td>
					Категория номера
				</td>
				<td>
					Тип уборки
				</td>
				<td>
					Начало уборки
				</td>
				<td>
					Конец уборки
				</td>
				<td>
					Сумма за уборку
				</td>
			</tr>

		<?php


			$rows = run_sql($sql2 . "'" . $d . "'");
			$salary = 0;
			foreach ($rows as $row) {
			    $r_cat = "";
			    if($row['work'] == 1)
			    {
			    	$r_cat = "Заезд";
			    }
			    elseif($row['work'] == 2)
			    {
			    	$r_cat = "Генеральная";
			    }
			    else
			    {
			    	$r_cat = "Текущая";
			    }
			    
			    $bed_cost = $row['w_bed'] * 30; 
			    $towel_cost = $row['w_towels'] * 10; 
			    
			    $salary += $row['r_cost'] + $bed_cost + $towel_cost;
			    
			    print("<tr><td>" . $row['st_room'] . " Корпус " . $row['build_name'] . "</td><td>" . $row['r_type'] . "</td><td>" . $r_cat . "</td><td>" . $row['w_start'] . "</td><td>" . $row['w_end'] . "</td><td>" . $row['r_cost'] + $bed_cost + $towel_cost . "</td></tr>");
			}
			    print("<tr><td colspan=\"5\">" . "ИТОГО" . "</td><td>" . $salary . "</td></tr>");
		?>
		
		</table>

	</body>
</html>