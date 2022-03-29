<?php
session_start();

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}


require_once("dbconfig.php");


if ($_POST){
    $id = $_POST['id'];
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];
    $username = $_POST['username'];
    $password = base64_encode($_POST['password']);

    $sql = "UPDATE staff 
            SET stf_code = ?, 
            stf_name = ?,
            username = ?, 
            passwd = ?                
            WHERE id = ?";    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi",$stf_code,$stf_name,$username,$password,$id);
    $stmt->execute();

    header("location: staff.php");
} else {
    $id = $_GET['id'];
    $sql = "SELECT *
            FROM staff
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
}
echo "Welcome ".$_SESSION['stf_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>แก้ไขคำสั่งบุคลากร</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style>
    <div class="container">
        <h1 align =center ><b style='color:#35589A;'>แก้ไขบุคลากร </b><a href='staff.php'><span class='glyphicon glyphicon-user' style='color:#FF5733;'></span></a></h1>
        <form action="editstaff.php" method="post">
            <div class="form-group">
                <label for="stf_code"><b style='color:#35589A;'>รหัสพนักงาน</b></label>
                <input type="text" class="form-control" name="stf_code" id="stf_code" value="<?php echo $row->stf_code;?>">
            </div>
            <div class="form-group">
                <label for="stf_name"><b style='color:#35589A;'>ชื่อ-นามสกุล</b></label>
                <input type="text" class="form-control" name="stf_name" id="stf_name" value="<?php echo $row->stf_name;?>">
            </div>
            <div class="form-group">
                <label  for="username"><b style='color:#35589A;'>Username</b></label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $row->username;?>">
            </div>
            <div class="form-group">
                <label  for="password"><b style='color:#35589A;'>Password</b></label>
                <input  type="password" class="form-control" name="password" id="passwd" value="<?php echo base64_decode($row->passwd);?>">
                               
            </div>
            <br>
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <button type="button" class="btn btn-warning" onclick="history.back();">Back</button>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
</body>

</html>