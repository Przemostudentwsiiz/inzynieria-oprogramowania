
<?php
include 'conect.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    
    $stmt = $pdo->prepare('SELECT * FROM uzytkownicy WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        exit('User doesn\'t exist with that ID!');
    }
    
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
        
            $stmt = $pdo->prepare('DELETE FROM uzytkownicy WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Usunąłeś konto';
        } else {
           
            header('Location: panel.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<div>
	<h2>Usuwanie konta #<?=$user['nazwa']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Czy na pewno chcesz usunąć konto #<?=$user['nazwa']?>?</p>
    <div>
        <a href="deleteaccount.php?id=<?=$user['id']?>&confirm=yes">Tak</a>
        <a href="paneladm.php?id=<?=$user['id']?>&confirm=no">Nie</a>
    </div>
    <?php endif; ?>
</div>

