<?php
function connect_db()
{
	global $link_db;
	
	if(!$link_db)
			{
				$host_db = ""; //��� ����� ��� ����� ��
				$user_db = ""; //��� ������������
				$pasword_db = ""; //������
				$name_db = ""; //��� ��
				
				$link_db = mysqli_connect($host_db, $user_db, $pasword_db, $name_db);
			}
}

function run_sql($sql)
{
	global $link_db;
	
	if(!$link_db)
	{
		connect_db();
	}
	
	$result = mysqli_query($link_db, $sql);
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
