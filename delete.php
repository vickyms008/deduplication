 <?php
 session_start();
if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	$user = $_SESSION['userName'];
	$uid = $_SESSION['user'];
require_once('dbconnect.php');
$con = dbconnect();
$fid = $_GET['fid'];
$q = mysqli_query($con, "SELECT * from file WHERE  fid= '$fid' and uid='$uid'");
$q = mysqli_fetch_array($q);
$name= $q['name'];
$lid = $q['lid'];
$query = mysqli_query($con,"DELETE FROM file WHERE fid= '$fid' and uid='$uid'");
$q = mysqli_query($con, "SELECT * from file WHERE  lid= '$fid'");
$count = 0;
if($result = mysqli_fetch_assoc($q))
{	
$count = $result['fid'];
$fname = $result['name'];
exec("cp files/".$fid.$name." files/".$count.$fname);
exec("chmod 777 files/".$count.$fname);
mysqli_query($con,"UPDATE file set lid = 0 where fid='$count'");
mysqli_query($con,"UPDATE file set lid ='$count' where lid='$fid'");	
}
//echo $name;
$query = mysqli_query($con,"SELECT * FROM file WHERE name = '$name'and fid='$fid' and uid='$uid'");
$r = mysqli_num_rows($query);
if($r == 0 && $lid == 0)
{
	unlink($_SERVER['DOCUMENT_ROOT'] .'/files/'.$fid.$name);
}
header('location: home.php');
?>


