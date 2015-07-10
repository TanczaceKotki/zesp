<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li class="active">Wyniki wyszukiwania</li>
</ol>
<?php
	if(isset($_GET['category'])){
		if(isset($_GET['keyword'])){
			if(preg_match("/^[ \w\s\d@]*$/", $_GET['keyword'])){
				$category=$_GET['category'];
				$keyword=$_GET['keyword'];
				?>
				<table class="table table-striped">
					<thead>
						<?php
							switch($_GET['category']){
								case 'Osoba':
									?>
									<tr>
										<th>ID</th>
										<th>Imię</th>
										<th>Nazwisko</th>
										<th>Adres email</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id,imie,nazwisko,email FROM Osoba WHERE imie LIKE ? OR nazwisko LIKE ? OR email LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC)){
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['imie'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item_3"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwisko'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item_4"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Sprzet':
									?>
									<tr>
										<th>ID</th>
										<th>Nazwa</th>
										<th>Opis</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id,nazwa,SUBSTR(opis, 1, 160) AS opis FROM Sprzet WHERE nazwa LIKE ? OR opis LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%','%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC))
											{
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>" class="item_3"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Laboratorium':
									?>
									<tr>
										<th>ID</th>
										<th>Nazwa</th>
										<th>Zespół</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id,nazwa,zespol FROM Laboratorium WHERE nazwa LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC)){
												if($row['zespol']!==""){
													if($result=$DB->prepare('SELECT nazwa FROM Zespol WHERE id=?')){
														if($result->execute(array($row['zespol']))){
															if($row2=$result->fetch(PDO::FETCH_ASSOC)) $zespol=$row2['nazwa'];
														}
													}
												}
												else $zespol="";
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=57&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=57&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<?php
															if($zespol!=="") echo '<a href="index.php?menu=58&amp;id='.$row['zespol'].'">'.htmlspecialchars($zespol,ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
															else echo htmlspecialchars($zespol,ENT_QUOTES|ENT_HTML5,'UTF-8',false);
														?>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Tag':
									?>
									<tr>
										<th>ID</th>
										<th>Nazwa</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id,nazwa FROM Tag WHERE nazwa LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC))
											{
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=64&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=64&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Zespol':
									?>
									<tr>
										<th>ID</th>
										<th>Nazwa</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id,nazwa FROM Zespol WHERE nazwa LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC))
											{
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=58&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=58&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Zaklad':
									?>
									<tr>
										<th>ID</th>
										<th>Nazwa</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id,nazwa FROM Zaklad WHERE nazwa LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC))
											{
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=63&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=63&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Projekt':
									?>
									<tr>
										<th>ID</th>
										<th>Nazwa</th>
										<th>Opis</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($st=$DB->prepare('SELECT id, nazwa, SUBSTR(opis, 1, 120) AS opis FROM Projekt WHERE nazwa LIKE ? OR opis LIKE ? ORDER BY id')){
										if($st->execute(array('%'.$keyword.'%','%'.$keyword.'%'))){
											while($row=$st->fetch(PDO::FETCH_ASSOC))
											{
												?>
												<tr class="item">
													<td>
														<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>" class="item_3"><?php echo str_replace($keyword,"<span class=\"highlight\">$keyword</span>",htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
							}
						?>
					</tbody>
				</table>
				<?php
			}
			else echo "Niepoprawne znaki w zapytaniu.<br />Dozwolone znaki a-z, A-Z, 0-9, '@'.";
		}
		else echo "Niepoprawne zapytanie.<br />Spróbuj jeszcze raz.";
	}
	else echo "Niepoprawna kategoria";
?>
<script src="js/items.js" type="text/javascript"></script>
