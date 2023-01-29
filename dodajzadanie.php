<?php
include 'conect.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    
    $Id = isset($_POST['Id']) && !empty($_POST['Id']) && $_POST['Id'] != 'auto' ? $_POST['Id'] : NULL;
    
    $Zadanie = isset($_POST['Zadanie']) ? $_POST['Zadanie'] : '';
    $Os_przypisana = isset($_POST['Os_przypisana']) ? $_POST['Os_przypisana'] : '';
    $Etap = isset($_POST['Etap']) ? $_POST['Etap'] : '';
    $data = isset($_POST['data']) ? $_POST['data'] : date('YYYY-MM-DD');
    
    $stmt = $pdo->prepare('INSERT INTO zadania VALUES (?, ?, ?, ?,?)');
    $stmt->execute([$Id, $Zadanie, $Os_przypisana, $Etap, $data]);
    
    $msg = 'Created Successfully!';
}

require_once "conect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
$quer = "SELECT * FROM uzytkownicy";
$res= mysqli_query($polaczenie, $quer) or die (mysqli_error($polaczenie));


?>



<div>
	<h2>Utwórz zadanie</h2>
    <form action="dodajzadanie.php" method="post">
        <label for="Id">ID</label>
        <input type="text" name="Id" placeholder="26" value="auto" id="Id">
        <label for="Zadanie">Zadanie</label>
        <input type="text" name="Zadanie" placeholder="Zrob..." id="Zadanie">
        <label for="Os_przypisana">Os_przypisana</label>
        
        <select name="Os_przypisana" id="Os_przypisana">
            <?php while ($row1 = mysqli_fetch_array($res)):;?>
            <option><?php echo $row1[1];?></option>
            <?php endwhile;?>
        </select>
   
        <label for="Etap">Etap</label>
        <input type="text" name="Etap" placeholder="do zrobienia" id="Etap" list="opcje">
        <datalist id="opcje">
            <option>do zrobienia</option>
            <option>w trakcie</option>
            <option>zakończono</option>
        </datalist>
        <label for="Etap">Data</label>
        <input type="date" name="data" value="<?=date('YYYY-MM-DD', strtotime($zadanie['data']))?>" id="data">
        <input type="submit" value="Utwórz">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    <a href="paneladm.php">Wróć do panelu</a>
</div>

