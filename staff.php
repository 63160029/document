<?php
session_start();
echo "Welcome ".$_SESSION['stf_name'];

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>บุคลากร</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div align =center class="container">
    <h1 align =center style='color:#35589A;'><b>คณะกรรมการ |</b>
    <a href='document.php'><span class='glyphicon glyphicon-home' style='color:#FF5733;'></span></a></h1>
    <h2 align =center style='color:#35589A;'><b>รายชื่อบุคลากร</b> &nbsp;</h2>
    <h3 align =center style='color:#35589A;'><b>เพิ่มรายชื่อ | </b><a href='newstaff.php'><span class='glyphicon glyphicon-plus' style='color:#FF5733;'></span></a></h3>
        <form align =center action="#" method="post">
            <input type="text" name="kw" placeholder="Enter staff name"  value="" size=140 >
            <input type="submit"  class="glyphicon glyphicon-search btn btn-info">
        </form>

        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";

        $sql = "SELECT *
                FROM staff
                WHERE concat(stf_code, stf_name) LIKE ? 
                ORDER BY stf_code";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s)."; 
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col' style='color:#35589A;'>#</th>
                                <th scope='col' style='color:#35589A;'>รหัสพนักงาน</th>
                                <th scope='col' style='color:#35589A;'>ชื่อ-นามสกุล</th>
                                <th scope='col' style='color:#35589A;'></th></b>
                            </tr>
                        </thead>
                        <tbody>";
                        
            
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td >" . $i++ . "</td>";
                $table.= "<td style='color:#35589A;'>$row->stf_code</td>";
                $table.= "<td style='color:#35589A;'>$row->stf_name</td>";
                $table.= "<td>";
                $table.= "<a href='editstaff.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='deletestaff.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
    
</body>

</html>