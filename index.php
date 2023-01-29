<?php

session_start();
if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) 
{
    header('Location:panel.php');
    exit();
}

?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
</head>

<body>

<form action="zaloguj.php" method="post">
Login:<input type="text" name="nazwa"><br /><br />
Haslo:<input type="password" name="haslo"><br /><br />
<input type="submit" value="Zaloguj się" />
</form>
<?php
if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
?>
</body>
</html>