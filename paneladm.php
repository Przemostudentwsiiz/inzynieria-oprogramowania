<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']) || $_SESSION['status']=="0")
	{
		header('Location: index.php');
		exit();
	}
	
?>


<?php
include 'conect.php';

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$records_per_page = 5;


$stmt = $pdo->prepare('SELECT * FROM uzytkownicy ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


$num_users = $pdo->query('SELECT COUNT(*) FROM uzytkownicy')->fetchColumn();



$stmt = $pdo->prepare('SELECT * FROM zadania ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$zadania = $stmt->fetchAll(PDO::FETCH_ASSOC);


$num_zadania = $pdo->query('SELECT COUNT(*) FROM zadania')->fetchColumn();
?>

<?php echo "<p>Witaj ".$_SESSION['nazwa'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';?>

<html>
<head>
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div>
	<h2>Tabela Użytkowników</h2>
	<a href="addaccount.php">Dodaj Konto</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nazwa</td>
                <td>Haslo</td>
                <td>Status</td>
                <td>Akcje</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['nazwa']?></td>
                <td><?=$user['haslo']?></td>
				<td><?=$user['status']?></td>
                <td>
                    <a href="updateaccount.php?id=<?=$user['id']?>"><button>EDYTUJ</button><i></i></a>
                    <a href="deleteaccount.php?id=<?=$user['id']?>"><button>USUŃ</button><i></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div>
		<?php if ($page > 1): ?>
		<a href="paneladm.php?page=<?=$page-1?>"><i>Poprzenia strona</i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_users): ?>
		<a href="paneladm.php?page=<?=$page+1?>"><i>Następna strona</i></a>
		<?php endif; ?>
	</div>
</div>




<div>
	<h2>Tabela zadań</h2>
	<a href="dodajzadanie.php">Utwóż zadanie</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Zadanie</td>
                <td>Os_przypisana</td>
                <td>Etap</td>
				<td>Data</td>
                <td>Akcje</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($zadania as $zadanie): ?>
            <tr>
                <td><?=$zadanie['Id']?></td>
                <td><?=$zadanie['Zadanie']?></td>
                <td><?=$zadanie['Os_przypisana']?></td>
				<td><?=$zadanie['Etap']?></td>
				<td><?=$zadanie['data']?></td>
                <td>
                    <a href="aktualizujzadanie.php?Id=<?=$zadanie['Id']?>"><button>EDYTUJ</button><i ></i></a>
                    <a href="usunzadanie.php?Id=<?=$zadanie['Id']?>" ><button>USUŃ</button><i></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div>
		<?php if ($page > 1): ?>
		<a href="paneladm.php?page=<?=$page-1?>"><i>Poprzednia strona</i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_zadania): ?>
		<a href="paneladm.php?page=<?=$page+1?>"><i>Nastepna strona</i></a>
		<?php endif; ?>
	</div>
</div>
</body>
</html>