<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=17">Zarządzaj projektami</a></li>
	<li class="active">Szczegóły projekt</li>
</ol>
<?php
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
				if($st->execute($params)) echo 'Projekt został pomyślnie zmodyfikowany.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu projektu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu projektu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<br />
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Nazwa:</th>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<th>Data rozpoczęcia:</th>
							<td><?php echo $row['data_rozp']; ?></td>
						</tr>
						<tr>
							<th>Data Zakończenia:</th>
							<td><?php echo $row['data_zakoncz']; ?></td>
						</tr>
						<tr>
							<th>Opis:</th>
							<td><?php echo htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Logo:</th>
							<td><a href="<?php echo $row['logo']; ?>"><img src="<?php echo $row['logo']; ?>" width="200" alt="" /></a></td>
						</tr>
					</tbody>
				</table><?php
			}
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?>
<a class="btn btn-warning" href="index.php?menu=17">Wróć do strony zarządzania projektami</a>
<?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
