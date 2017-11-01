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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 5;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_Connection, $Connection);
$query_Recordset1 = "SELECT * FROM book_information";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $Connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
      <p align="center" class="style6">Edit Record </p>
      <p>&nbsp;</p>
      <blockquote>
        <table width="80%" border="2" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td>ISBN</td>
            <td>Title</td>
            <td>Author</td>
            <td>Country</td>
            <td>Language</td>
            <td>Genre</td>
            <td>Publisher</td>
            <td>Publication Date</td>
            <td>Pages</td>
			<td>Edit</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_Recordset1['ISBN']; ?></td>
              <td><?php echo $row_Recordset1['Title']; ?></td>
              <td><?php echo $row_Recordset1['Author']; ?></td>
              <td><?php echo $row_Recordset1['Country']; ?></td>
              <td><?php echo $row_Recordset1['Language']; ?></td>
              <td><?php echo $row_Recordset1['Genre']; ?></td>
              <td><?php echo $row_Recordset1['Publisher']; ?></td>
              <td><?php echo $row_Recordset1['Publication_Date']; ?></td>
              <td><?php echo $row_Recordset1['Pages']; ?></td>
			  <td><form id="form1" name="form1" method="post" action="update.php">
			    <input name="hiddenFieldEDIT" type="hidden" id="hiddenFieldEDIT" value="<?php echo $row_Recordset1['ISBN']; ?>" />
			    <label>
			    <input type="submit" name="Submit" value="Edit" />
			    </label>
                                          </form>
			  </td>
            </tr>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
          <p>&nbsp;</p>
      </blockquote>
      <hr align="center" width="40%" />
      <p>
      <table border="0" width="50%" align="center">
        <tr>
          <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                <?php } // Show if not first page ?>
          </td>
          <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                <?php } // Show if not first page ?>
          </td>
          <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                <?php } // Show if not last page ?>
          </td>
          <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                <?php } // Show if not last page ?>
          </td>
        </tr>
      </table>
      </p>
<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
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
