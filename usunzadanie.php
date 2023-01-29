<?php
include 'conect.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['Id'])) {

    $stmt = $pdo->prepare('SELECT * FROM zadania WHERE Id = ?');
    $stmt->execute([$_GET['Id']]);
    $zadanie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$zadanie) {
        exit('User doesn\'t exist with that ID!');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
    
            $stmt = $pdo->prepare('DELETE FROM zadania WHERE Id = ?');
            $stmt->execute([$_GET['Id']]);
            $msg = 'You have deleted the Account!';
        } else {

            header('Location: paneladm.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<div>
	<h2>Usuwanie zadania #<?=$zadanie['Id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Czy na pewno chcesz usunąć zadanie #<?=$zadanie['Id']?>?</p>
    <div>
        <a href="usunzadanie.php?Id=<?=$zadanie['Id']?>&confirm=yes">Tak</a>
        <a href="paneladm.php?Id=<?=$zadanie['Id']?>&confirm=no">Nie</a>
    </div>
    <?php endif; ?>
</div>

