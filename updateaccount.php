<?php
include 'conect.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    if (!empty($_POST)) {

        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nazwa = isset($_POST['nazwa']) ? $_POST['nazwa'] : '';
        $haslo = isset($_POST['haslo']) ? $_POST['haslo'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        $stmt = $pdo->prepare('UPDATE uzytkownicy SET id = ?, nazwa = ?, haslo = ?, status = ?, WHERE id = ?');
        $stmt->execute([$id, $nazwa, $haslo, $status, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare('SELECT * FROM uzytkownicy WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<div>
	<h2>Aktualizuj dane konta <?=$user['nazwa']?></h2>
    <form action="updateaccount.php?id=<?=$user['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$user['id']?>" id="id">
        <label for="nazwa">Nazwa</label>
        <input type="text" name="nazwa" placeholder="John Doe" value="<?=$user['nazwa']?>" id="nazwa">
        <label for="haslo">Haslo</label>
        <input type="text" name="haslo" placeholder="johndoe@example" value="<?=$user['haslo']?>" id="haslo">
        <label for="status">Status</label>
        <input type="text" name="status" placeholder="0" value="<?=$user['status']?>" id="status">
        <input type="submit" value="Aktualizuj">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
<a href="paneladm.php">Wróć do panelu</a>
</div>

