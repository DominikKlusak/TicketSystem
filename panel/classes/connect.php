<?php

		$host = "localhost";
		$user = "root";
		$pass = "";
		$database = "ticketsystem";
	
	
	@$polaczenie = mysqli_connect ($host, $user, $pass, $database);
	
	$polaczenie->set_charset("utf8");
	
	if (!$polaczenie) {
		echo "Błąd połączenia z baza danych -> ".mysqli_connect_error();

		die();
	}

	

?>