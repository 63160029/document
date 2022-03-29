<?php
session_start();

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

require_once("dbconfig.php");


if ($_POST){
    
    $id = $_POST['id'];

    
    $sql = "DELETE 
            FROM staff 
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
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
    <title>ลบข้อมูลบุคลากร</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 align =center style='color:#35589A;'><b>ลบข้อมูลบุคลากร</b></h1>
        <br>
        <br>
        <table class="table table-hover">
            <tr>
                <th style='color:#35589A;'>รหัสพนักงาน</th>
                <td style='color:#35589A;'><?php echo $row->stf_code;?></td>
            </tr>
            <tr>
                <th style='color:#35589A;'>ชื่อ-นามสกุล</th>
                <td style='color:#35589A;'><?php echo $row->stf_name;?></td>
            </tr>
            <tr>
                <th style='color:#35589A;'>Username</th>
                <td style='color:#35589A;'><?php echo $row->username;?></td>
            </tr>
            <tr>
                <th style='color:#35589A;'>Password</th>
                <td style='color:#35589A;'><?php echo base64_decode($row->passwd);?></td>
            </tr>


            
        </table>
        <form action="deletestaff.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <input type="submit" value="Confirm delete" class="btn btn-danger">
            <button type="button" class="btn btn-warning" onClick="window.history.back()">Cancel Delete</button>
        </form>
</body>

</html>