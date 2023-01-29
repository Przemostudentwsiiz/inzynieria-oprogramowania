<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - gra przeglądarkowa</title>
</head>

<body>

<h1> EDYCJA DANYCH</h1>

<?php

$polaczenie=mysqli_connect('localhost','root','', 'bazaprojektowa') or die('Połączenie nieudane');
if(isset($_POST['edit_btn']))
{
    $id = $_POST['editid'];

    $querry = "SELECT * FROM uzytkownicy WHERE id='$id'";
    $querry_name = "SELECT * FROM uzytkownicy WHERE id='$id'";
    $querry_run = mysqli_query($polaczenie, $query);
}


?>

<label>Nazwa</label>
<input type="text" name="nazwa" value="<?php echo $querry_name?>" />
 

</body>
</html>