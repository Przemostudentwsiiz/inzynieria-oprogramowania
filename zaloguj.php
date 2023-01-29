<?php

	session_start();
	
	if ((!isset($_POST['nazwa'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();

        


	}

	require_once "conect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$nazwa = $_POST['nazwa'];
		$haslo = $_POST['haslo'];
		
		$nazwa = htmlentities($nazwa, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE nazwa='%s' AND haslo='%s'",
		mysqli_real_escape_string($polaczenie,$nazwa),
		mysqli_real_escape_string($polaczenie,$haslo))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['zalogowany'] = true;
				
				$wiersz = $rezultat->fetch_assoc();
				$_SESSION['id'] = $wiersz['id'];
				$_SESSION['nazwa'] = $wiersz['nazwa'];
				$_SESSION['status'] = $wiersz['status'];
				
				unset($_SESSION['blad']);
				$rezultat->free_result();
                if($_SESSION['status']=="1")
                {
                    header('Location: paneladm.php');
                }

                else if($_SESSION['status']=="0")
                {
				header('Location: panel.php');
                }
  
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>