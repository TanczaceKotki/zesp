 <?php
	class user {
		public function getData () {
			if(isset($_SESSION['login']) && isset($_SESSION['pass'])){
				$login=$_SESSION['login'];
				$pass=$_SESSION['pass'];
				$DB=dbconnect();
				if($st=$DB->prepare('SELECT * FROM Uzytkownicy WHERE login=?')) {
					if($st->execute(array($login))){
						return $st->fetch(PDO::FETCH_ASSOC);
					}
					else{
						echo 'Nastąpił błąd przy pobieraniu danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
						return NULL;
					}
				}
				else{
					echo 'Nastąpił błąd przy pobieraniu danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
					return NULL;
				}
			}
			else return NULL;
		}

		public function getDataById ($id) {
			$DB=dbconnect();
			if($st=$DB->prepare('SELECT * FROM Uzytkownicy WHERE id=?')){
				if($st->execute(array($id))){
					return $st->fetch(PDO::FETCH_ASSOC);
				}
				else{
					echo 'Nastąpił błąd przy pobieraniu danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
					return NULL;
				}
			}
			else{
				echo 'Nastąpił błąd przy pobieraniu danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				return NULL;
			}
		}

		public function isLogged () {
			if (empty($_SESSION['login']) || empty($_SESSION['pass'])) {
				return false;
			}
			else {
				return true;
			}
		}
	}
?>
