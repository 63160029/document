<?php
session_start();

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
require_once("dbconfig.php");


if ($_POST){
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];
    $admin = $_POST['admin'];
    $username = $_POST['username'];
    $password = base64_encode($_POST['password']);
    
    $sql = "INSERT 
            INTO staff (stf_code,stf_name,is_admin,username,passwd) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss",$stf_code,$stf_name,$admin,$username,$password);
    $stmt->execute();

    
    header("location: staff.php");
}
echo "Welcome ".$_SESSION['stf_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>เพิ่มบุคลากร</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
        <h1 align =center style='color:#35589A;'><b>เพิ่มบุคลากร</b></h1>
        <form action="newstaff.php" method="post">
            <div class="form-group">
                <label for="stf_code" style='color:#35589A;'>รหัสพนักงาน</label>
                <input type="text" class="form-control" name="stf_code" id="stf_code">
            </div>
            <div class="form-group">
                <label for="stf_name" style='color:#35589A;'>ชื่อ-นามสกุล</label>
                <input type="text" class="form-control" name="stf_name" id="stf_name">
            </div>
            <div class="form-group">
                <label  for="username" style='color:#35589A;'>Username</label>
                <input type="text" class="form-control" name="username" id="username" >
            </div>
            <div class="form-group">
                <label  for="password" style='color:#35589A;'>Password</label>
                <input  type="password" class="form-control" name="password" id="passwd" >
            </div>
            <div class="form-group">
                <label for="admin"style='color:#35589A;'>ตำแหน่ง</label>
                <br>
                <input type="radio"  name="admin" id="is_admin" value="Y"><b style='color:#35589A;'>ADMIN</b>
                <input type="radio"  name="admin" id="is_admin" value=""> <b style='color:#35589A;'>USER</b>
            </div>
            <br>
            <button type="button" class="btn btn-warning" onclick="history.back();">Back</button>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>