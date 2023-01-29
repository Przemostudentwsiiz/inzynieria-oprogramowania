
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
     
        $stmt = $pdo->prepare('UPDATE zadania SET Id = ?, Zadanie = ?, Os_przypisana = ?, Etap = ?, data =?  WHERE Id = ?');
        $stmt->execute([$Id, $Zadanie, $Os_przypisana, $Etap, $data, $_GET['Id']]);
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

require_once "conect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
$quer = "SELECT * FROM uzytkownicy";
$res= mysqli_query($polaczenie, $quer) or die (mysqli_error($polaczenie));
?>

<div>
	<h2>Aktualizuj zadanie <?=$zadanie['Id']?></h2>
    <form action="aktualizujzadanie.php?Id=<?=$zadanie['Id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="Id" placeholder="1" value="<?=$zadanie['Id']?>" id="Id">
        <label for="Zadanie">Zadanie</label>
        <input type="text" name="Zadanie" placeholder="Zrob..." value="<?=$zadanie['Zadanie']?>" id="Zadanie">
        <label for="Os_przypisana">Os_przypisana</label>
        <select name="Os_przypisana" id="Os_przypisana">
            <?php while ($row1 = mysqli_fetch_array($res)):;?>
            <option><?php echo $row1[1];?></option>
            <?php endwhile;?>
        </select>
        
        <label for="phone">Status</label>
        <input type="text" name="Etap" placeholder="0" value="<?=$zadanie['Etap']?>" id="Etap" list="opcje">
        <datalist id="opcje">
            <option>do zrobienia</option>
            <option>w trakcie</option>
            <option>zakończono</option>
        </datalist>
        <label for="phone">Data</label>
        <input type="date" name="data" value="<?=date('YYYY-MM-DD', strtotime($zadanie['data']))?>" id="data">
        <input type="submit" value="Aktualizuj">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    <a href="paneladm.php">Wróć do panelu</a>
</div>

