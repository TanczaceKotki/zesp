<?php breadcrumbs('Wyniki wyszukiwania'); ?>
<h1 class="font20">Wyniki wyszukiwania</h1>
<?php
	if(isset($_GET['category'])){
		if(isset($_GET['keyword'])){
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
												<tr class="items">
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['imie'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwisko'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
									break;
								case 'Aparatura':
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
												<tr class="items">
													<td>
														<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
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
												<tr class="items">
													<td>
														<a href="index.php?menu=57&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=57&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
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
								case 'Słowo_Kluczowe':
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
												<tr class="items">
													<td>
														<a href="index.php?menu=64&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=64&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
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
												<tr class="items">
													<td>
														<a href="index.php?menu=58&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=58&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
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
												<tr class="items">
													<td>
														<a href="index.php?menu=63&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=63&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
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
												<tr class="items">
													<td>
														<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo $row['id']; ?></a>
													</td>
													<td>
														<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
													<td>
														<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo str_replace($keyword,"<mark class=\"highlight\">$keyword</mark>",htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false)); ?></a>
													</td>
												</tr>
												<?php
											}
										}
									}
							}
						?>
					</tbody>
				</table>
				<?php
		}
		else echo '<p>Niepoprawne zapytanie.<br />Spróbuj jeszcze raz.</p>';
	}
	else echo '<p>Niepoprawna kategoria</p>';
?>
<script src="js/items.js" type="text/javascript"></script>
