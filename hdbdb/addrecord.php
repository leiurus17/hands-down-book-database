<?php require_once('Connections/Connection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "accessdenied.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO book_information (ISBN, Title, Author, Country, `Language`, Genre, Publisher, Publication_Date, Pages) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ISBN'], "text"),
                       GetSQLValueString($_POST['Title'], "text"),
                       GetSQLValueString($_POST['Author'], "text"),
                       GetSQLValueString($_POST['Country'], "text"),
                       GetSQLValueString($_POST['Language'], "text"),
                       GetSQLValueString($_POST['Genre'], "text"),
                       GetSQLValueString($_POST['Publisher'], "text"),
                       GetSQLValueString($_POST['Publication_Date'], "text"),
                       GetSQLValueString($_POST['Pages'], "text"));

  mysql_select_db($database_Connection, $Connection);
  $Result1 = mysql_query($insertSQL, $Connection) or die(mysql_error());

  $insertGoTo = "addrecord.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Connection, $Connection);
$query_Recordset1 = "SELECT * FROM book_information";
$Recordset1 = mysql_query($query_Recordset1, $Connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
.style7 {
	color: #F4F4F4;
	font-weight: bold;
}


-->
</style></head>

<body>
<table width="80%" border="1" align="center" cellpadding="2" bordercolor="#000000">
  <tr>
    <td bgcolor="#800000"><img src="images/head.gif" width="900" height="150" /></td>
  </tr>
  <tr>
    <td bgcolor="#000000" class="linksbar"><div align="center" class="style2">&bull; <a href="home.php">Home</a> &bull; <a href="viewdatabase.php">View Database</a> &bull; <a href="addrecord.php">Add Record</a> &bull; <a href="editrecord.php">Edit Record</a> &bull; <a href="deleterecord.php">Delete Record</a> &bull; <a href="aboutus.php">About Us</a> &bull;</div>     </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">
      <p>&nbsp;</p>
      <blockquote>
        <p align="right">&nbsp;<a href="<?php echo $logoutAction ?>" class="style7">Log out</a></p>
      </blockquote>
      <hr align="center" width="80%" />
      <p align="center" class="style6">Add Record </p>
      <p>&nbsp;</p>
      <blockquote>
        <table width="50%" border="1" cellpadding="2">
          <tr>
            <td>&nbsp;
              <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap align="right">ISBN:</td>
                    <td><input type="text" name="ISBN" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Title:</td>
                    <td><input type="text" name="Title" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Author:</td>
                    <td><input type="text" name="Author" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Country:</td>
                    <td><input type="text" name="Country" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Language:</td>
                    <td><input type="text" name="Language" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Genre:</td>
                    <td><input type="text" name="Genre" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Publisher:</td>
                    <td><input type="text" name="Publisher" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right"><p>Publication Date:</p>
                      <p>(YYY-MM-DD)</p></td>
                    <td><input type="text" name="Publication_Date" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Pages:</td>
                    <td><input type="text" name="Pages" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">&nbsp;</td>
                    <td><input type="submit" value="Insert record" onclick="return confirm('Are you sure you want to add this record?')"></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1">
              </form>
              </td>
          </tr>
        </table>
        <p align="center">&nbsp;</p>
      </blockquote>
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
