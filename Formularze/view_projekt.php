<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	top();
	if(isset($_POST['submitted'])){
		$send=False;
		$params=array();
		$sql='UPDATE Projekt SET';
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			$sql.=' nazwa=?';
			$params[]=$_POST['nazwa'];
			$send=True;
		}
		$data=$_POST['data_rozp_rok'];
		if($_POST['data_rozp_miesiac']!==""){
			$data.='-'.$_POST['data_rozp_miesiac'];
			if($_POST['data_rozp_dzien']!=="") $data.='-'.$_POST['data_rozp_dzien'];
		}
		if($data!==$_POST['old_data_rozp']){
			if($send) $sql.=',';
			$sql.=' data_rozp=?';
			$params[]=$data;
			$send=True;
		}
		$data="";
		if($_POST['data_zakoncz_rok']!==""){
			$data=$_POST['data_zakoncz_rok'];
			if($_POST['data_zakoncz_miesiac']!==""){
				$data.='-'.$_POST['data_zakoncz_miesiac'];
				if($_POST['data_zakoncz_dzien']!=="") $data.='-'.$_POST['data_zakoncz_dzien'];
			}
		}
		if($data!==$_POST['old_data_zakoncz']){
			if($send) $sql.=',';
			if($data==="") $sql.=' data_zakoncz=NULL';
			else{
				$sql.=' data_zakoncz=?';
				$params[]=$data;
			}
			$send=True;
		}
		if($_POST['opis']!==$_POST['old_opis']){
			if($send) $sql.=',';
			$sql.=' opis=?';
			$params[]=$_POST['opis'];
			$send=True;
		}
		if($_POST['logo']!==$_POST['old_logo']){
			if($send) $sql.=',';
			$sql.=' logo=?';
			$params[]=$_POST['logo'];
			$send=True;
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)) echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_osoba" value="Usuń" />
				</form>
				<form action="edit_projekt.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" value="Edytuj" />
				</form>
				<br />
				<table>
					<tbody>
						<tr>
							<td>Nazwa</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Data rozpoczęcia</td>
							<td><?php echo $row['data_rozp']; ?></td>
						</tr>
						<tr>
							<td>Data Zakończenia</td>
							<td><?php echo $row['data_zakoncz']; ?></td>
						</tr>
						<tr>
							<td>Opis</td>
							<td><?php echo $row['opis']; ?></td>
						</tr>
						<tr>
							<td>Logo</td>
							<td><img src="<?php echo $row['logo']; ?>" width="200" alt="" /></td>
						</tr>
					</tbody>
				</table><?php
			}
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a href="index.php">Wróć do strony głównej.</a><?php
	bottom();
?>
