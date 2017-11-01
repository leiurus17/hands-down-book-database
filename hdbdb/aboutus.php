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
.style8 {font-size: 14px}
.style14 {font-size: 36ex}
.style15 {font-size: 36px}


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
      <p align="center" class="style6">About Us</p>
      <p class="style6">&nbsp;</p>
      <blockquote> 
        <div align="left">We are Team Boom 1st Battalion, File Org Company. 2nd Platoon.</div>
        <p align="left" class="style6 style8">&nbsp;</p>
        <table width="80%" border="1" align="center" cellpadding="2" bordercolor="#000000">
          <tr>
            <td><div align="left"><img src="images/weightlifter.jpg" width="400" height="400" /></div></td>
            <td><p align="center" class="style6">Name: Mark Harris &quot;Shaq&quot; J.</p>
              <p align="center"><strong>Rank: General</strong></p>
              <p align="center"><strong>Role: Defense Specialist</strong></p></td>
          </tr>
          <tr>
            <td><div align="left"><img src="images/efgthr6456t54.png" width="400" height="400" /></div></td>
            <td><p align="center" class="style6">Name: Marlon &quot;Hands&quot; M.</p>
              <p align="center"><strong>Rank: Commander</strong></p>
              <p align="center"><strong>Role: Special Ops. </strong></p></td>
          </tr>
          <tr>
            <td><img src="images/gir.png" width="400" height="400" /></td>
            <td><p align="center" class="style6">Name: Daniel &quot;Gir&quot; R.</p>
              <p align="center"><strong>Rank: General </strong></p>
              <p align="center"><strong>Role: Logistics / Super Computer </strong></p></td>
          </tr>
          <tr>
            <td><img src="images/020909121934gameBig_farmville.jpg" width="400" height="400" /></td>
            <td><p align="center" class="style6">Name: Shirley &quot;Marian&quot; T.</p>
              <p align="center"><strong>Rank: Captain</strong></p>
              <p align="center"><strong>Role: Recon (Reconnaissance) </strong></p></td>
          </tr>
          <tr>
            <td><img src="images/2295097664_2bba54a586.jpg" width="400" height="400" /></td>
            <td><p align="center" class="style6">Name: Neil &quot;Kips&quot; Y.</p>
              <p align="center"><strong>Rank: General</strong></p>
              <p align="center"><strong>Role: Black Ops. </strong></p></td>
          </tr>
          <tr>
            <td><img src="images/9512407-9512410-slarge.jpg" width="400" height="400" /></td>
            <td><p align="center" class="style6">Name: Chris &quot;Ender&quot; Carrabba </p>
              <p align="center"><strong>Rank: Commander in Chief </strong></p>
              <p align="center"><strong>Role: Hands Down </strong></p></td>
          </tr>
		  <tr>
            <td><img src="images/bumblebee_tmu_mini.jpg" width="400" height="400" /></td>
            <td><p align="center" class="style6">Name: Charles Jasper &quot;Bumblebee&quot; J. </p>
              <p align="center"><strong>Rank: Chief Intelligence Officer </strong></p>
              <p align="center"><strong>Role: Retrieval of Delete and Edit Functions </strong></p></td>
          </tr>
		  <tr>
            <td><div align="center"><span class="style14">?</span></div></td>
            <td><p align="center" class="style6">Name: ? </p>
              <p align="center"><strong>Rank: Scout </strong></p>
              <p align="center"><strong>Role: Hidden Member </strong></p></td>
          </tr>
		   <tr>
            <td><div align="center"><img src="images/51EtLJCSkML.jpg" width="400" height="400" /></div></td>
            <td><p align="center" class="style6">Name: Calumet </p>
              <p align="center"><strong>Rank: Design Planner </strong></p>
              <p align="center"><strong>Role: Double Acting Baking Powder </strong></p></td>
          </tr>
        </table>
        </blockquote>
      <p>&nbsp;</p>
      <p class="style15">We would like to thank:</p>
      <p class="style15"><strong>Mr. Bryan Dadiz  </strong></p>
      <p>&nbsp;</p>
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
