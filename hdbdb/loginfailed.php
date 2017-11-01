<?php require_once('Connections/Connection.php'); ?>
<?php
mysql_select_db($database_Connection, $Connection);
$query_Recordset1 = "SELECT * FROM account";
$Recordset1 = mysql_query($query_Recordset1, $Connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['textfield2'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "loginfailed.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Connection, $Connection);
  
  $LoginRS__query=sprintf("SELECT username, password FROM account WHERE username='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $Connection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hands Down Book Database</title>
<style type="text/css">
<!--
body {
	background-color: #FFCFB9;
	background-image: url(images/bg_top.GIF);
	background-repeat: repeat-x;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
a:link {
	color: #800000;
	text-decoration: none;
}
a:visited {
	color: #000000;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style4 {
	color: #FFFFFF;
	font-size: 10px;
}


.linksbar a:link {
	color: #FFFFFF;
	text-decoration: none;
}
.linksbar a:visited {
	color: #FFFFFF;
	text-decoration: none;
}
.linksbar a:hover {
	text-decoration: underline;
}
.linksbar a:active {
	text-decoration: none;
}
.style6 {
	font-size: 16px;
	font-weight: bold;
}
.style7 {color: #FF0000}


-->
</style></head>

<body>
<table width="80%" border="1" align="center" cellpadding="2" bordercolor="#000000">
  <tr>
    <td bgcolor="#800000"><img src="images/head.gif" width="900" height="150" /></td>
  </tr>
  <tr>
    <td bgcolor="#000000" class="linksbar"><div align="center" class="style2">&bull;</div>     </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">
      <p>&nbsp;</p>
      <hr align="center" width="80%" />
      <p class="style6">Login</p>
      <table width="400" border="1" cellpadding="2" bordercolor="#000000">
        <tr>
          <td height="292" bgcolor="#800000"><form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
            <p>&nbsp;</p>
            <blockquote>
              <p> <span class="style2">
                <label>Username:
                <input type="text" name="textfield" />
                </label>
              </span></p>
              <p> <span class="style2">
                <label>Password:
                <input type="password" name="textfield2" />
                </label>
              </span></p>
              <p align="center">
                <label>
                <input type="submit" name="Submit" value="Login" />
                </label>
              </p>
            </blockquote>
            <p>&nbsp;</p>
          </form>            </td>
        </tr>
      </table>
      <p class="style7"><strong>Sorry, the username or password is incorrect.</strong></p>
      <p class="style7"><strong>Please try again. </strong></p>
      <hr align="center" width="80%" />
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><div align="center" class="style4">Copyrights &copy; 2009 Hands Down Book's Database (Team   B<strong>O_o</strong>m).</div></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
