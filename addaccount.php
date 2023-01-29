<?php
include 'conect.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {

    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

    $nazwa = isset($_POST['nazwa']) ? $_POST['nazwa'] : '';
    $haslo = isset($_POST['haslo']) ? $_POST['haslo'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
 
    $stmt = $pdo->prepare('INSERT INTO uzytkownicy VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $nazwa, $haslo, $status]);

    $msg = 'Created Successfully!';
}
?>



<div>
	<h2>Dodaj Konto</h2>
    <form action="addaccount.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <label for="nazwa">nazwa</label>
        <input type="text" name="nazwa" placeholder="zwykly" id="nazwa">
        <label for="haslo">haslo</label>
        <input type="text" name="haslo" placeholder="qwerty123" id="haslo">
        <label for="status">status</label>
        <input type="text" name="status" placeholder="0" id="status">
        <input type="submit" value="Utwórz">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    <a href="paneladm.php">Wróć do panelu</a>
</div>

