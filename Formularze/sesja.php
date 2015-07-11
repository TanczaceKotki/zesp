<?php
	function logowanie() { 
     
if($_SESSION['logowanie'] == 'poprawne') { 
     
   $string  = '<FORM action="'.getenv(REQUEST_URI).'" method="post">'; 
      $string .= '   <INPUT type="submit" name="wylogowanie" value="Wyloguj">'; 
      $string .= '</FORM>'; 
       
} else { 
   $string = '<FORM action="'.getenv(REQUEST_URI).'" method="post">'; 
      $string .= '<UL style="list-style-type: none; margin: 0; padding: 
0;">'; 
       
      if(isset($_SESSION['logowanie'])) $string .= 
'<LI>'.$_SESSION['logowanie'].'</LI>'; 
       
      $string .= '<LI>Login: <INPUT type="text" name="login"></LI>'; 
      $string .= '<LI>Haslo: <INPUT type="text" name="haslo"></LI>'; 
      $string .= '<LI><INPUT type="submit" name="logowanie" value="Logowanie"></LI>'; 
      $string .= '</UL>'; 
      $string .= '</FORM>'; 
       
} 
return $string; 
}  ?>
	<html>lkjsajd</html>
	

