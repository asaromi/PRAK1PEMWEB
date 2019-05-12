<?php 
session_start();

$uname = $_POST["uname"];
$pwd = $_POST["pwd"];

if($uname=="asa" && $pwd=="anu"){
    $_SESSION["user"] = $uname;
    echo "<center>LOGIN SUCCESS. CLICK <a href='index.php'>HERE</a> TO REDIRECT<br></center>";
    setcookie("user", "asa", time()+60);
    header("refresh:5; url=index.php");
} else {
    echo "<center>LOGIN FAILED. PLEASE TRY AGAIN<br></center>";
    echo "<center>CLICK <a href='login.php'>HERE</a> IF THE PAGE CANNOT REDIRECT AFTER 5s.</center>";
    header("refresh:5; url=login.php");
}
    
?>