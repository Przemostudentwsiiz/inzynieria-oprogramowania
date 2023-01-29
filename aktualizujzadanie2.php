<?php
include 'conect.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['Id'])) {
    if (!empty($_POST)) {
       
        $Id = isset($_POST['Id']) ? $_POST['Id'] : NULL;
        $Zadanie = isset($_POST['Zadanie']) ? $_POST['Zadanie'] : '';
        $Os_przypisana = isset($_POST['Os_przypisana']) ? $_POST['Os_przypisana'] : '';
        $Etap = isset($_POST['Etap']) ? $_POST['Etap'] : '';
        $data = isset($_POST['data']) ? $_POST['data'] : date('YYYY-MM-DD');
     
        $stmt = $pdo->prepare('UPDATE zadania SET Id = ?, Etap = ? WHERE Id = ?');
        $stmt->execute([$Id, $Etap, $_GET['Id']]);
        $msg = 'Updated Successfully!';
    }
    
    $stmt = $pdo->prepare('SELECT * FROM zadania WHERE Id = ?');
    $stmt->execute([$_GET['Id']]);
    $zadanie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$zadanie) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}

?>

<div>
	<h2>Aktualizuj zadanie <?=$zadanie['Id']?></h2>
    <form action="aktualizujzadanie2.php?Id=<?=$zadanie['Id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="Id" placeholder="1" value="<?=$zadanie['Id']?>" id="Id" readonly>
        <label for="zadanie">Zadanie</label>
        <input type="text" name="zadanie" placeholder="Zrob..." value="<?=$zadanie['Zadanie']?>" id="Zadanie" readonly>
        <label for="Os_przypisana">Os_przypisana</label>
        <input type="text" name="Os_przypisana" placeholder="zwykly" value="<?=$zadanie['Os_przypisana']?>" id="Os_przypisana">
        <label for="Etap">Status</label>
        <input type="text" name="Etap" placeholder="do zrobienia" id="Etap" list="opcje">
        <datalist id="opcje">
            <option>do zrobienia</option>
            <option>w trakcie</option>
            <option>zakończono</option>
        </datalist>
        <label for="data">Data</label>
        <input type="date" name="data" value="<?=date('YYYY-MM-DD', strtotime($zadanie['data']))?>" id="data" readonly>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    <a href="panel.php">Wróć do panelu</a>
</div>

