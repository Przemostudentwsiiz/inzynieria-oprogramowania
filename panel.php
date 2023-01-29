<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
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

$nazwa=$_SESSION['nazwa'];


$stmt = $pdo->prepare('SELECT * FROM zadania WHERE Os_przypisana = "'.$_SESSION['nazwa'].'" ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$zadania = $stmt->fetchAll(PDO::FETCH_ASSOC);


$num_zadania = $pdo->query('SELECT COUNT(*) FROM zadania')->fetchColumn();



?>


<?php echo "<p>Witaj ".$_SESSION['nazwa'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';?>

<div>
	<h2>Tabela zadań</h2>
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
                    <a href="aktualizujzadanie2.php?Id=<?=$zadanie['Id']?>"><button>EDYTUJ</button><i></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div>
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_zadania): ?>
		<a href="read.php?page=<?=$page+1?>"><i></i></a>
		<?php endif; ?>
	</div>
</div>

