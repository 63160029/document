<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
echo "Welcome ".$_SESSION['stf_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>คำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div align =center class="container">
        <h1 align =center><b style='color:#35589A;'>คำสั่งแต่งตั้ง</b> 
        <a href='logout.php'><span class='glyphicon glyphicon-share' style='color:#FF0000;'></span></a>
        </h1>
        <h2 align =center><b style='color:#35589A;'>รายการคำสั่งแต่งตั้ง |</b>
        <a href='newdocument.php'><span class='glyphicon glyphicon-file' style='color:#FF5733;'></span></a>
        <a href='selectdocument.php'><span class='glyphicon glyphicon-search' style='color:#FF5733;'></span></a>
        <a href='staff.php'><span class='glyphicon glyphicon-user' style='color:#FF5733;'></span></a></h2>
        <form action="#" method="post">
            <input type="text" name="kw" placeholder="Enter document name" value="" size=140>
            <button type="submit" class="glyphicon glyphicon-search btn btn-info"></button>
        </form>

        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";


        $sql = "SELECT *
                FROM documents
                WHERE concat(doc_num, doc_title) LIKE ? 
                ORDER BY doc_num";



        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            // สร้างตัวแปรเพื่อเก็บข้อความ html 
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col' style='color:#35589A;'>#</th>
                                <th scope='col' style='color:#35589A;'>เลขที่คำสั่ง</th>
                                <th scope='col' style='color:#35589A;'>ชื่อคำสั่ง</th>
                                <th scope='col' style='color:#35589A;'>วันที่เริ่มต้นคำสั่ง</th>
                                <th scope='col' style='color:#35589A;'>วันที่สิ้นสุด</th>
                                <th scope='col' style='color:#35589A;'>สถานะ</th>
                                <th scope='col' style='color:#35589A;'>ชื่อไฟล์เอกสาร</th>
                                <th scope='col' style='color:#35589A;'>จัดการข้อมูลคำสั่งแต่งตั้ง</th>
                                <th scope='col ' >จัดการข้อมุลบุคลากร</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
            // 
            $i = 1; 

            // ดึงข้อมูลออกมาทีละแถว และกำหนดให้ตัวแปร row 
            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td style='color:#35589A;'>" . $i++ . "</td>";
                $table.= "<td style='color:#35589A;'>$row->doc_num</td>";
                $table.= "<td style='color:#35589A;'>$row->doc_title</td>";
                $table.= "<td style='color:#35589A;'>$row->doc_start_date</td>";
                $table.= "<td style='color:#35589A;'>$row->doc_to_date</td>";
                $table.= "<td style='color:#35589A;'>$row->doc_status</td>";
                $table.= "<td><a href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
                $table.= "<td>";
                $table.= "<a href='editdocument.php?id=$row->id'><span class='glyphicon glyphicon-pencil'style='color:#FF5733;' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='deletedocument.php?id=$row->id'><span class='glyphicon glyphicon-trash' style='color:#FF5733;'aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "<td>";
                $table.= "<a href='addstafftodocument.php?id=$row->id'><span class='glyphicon glyphicon-th-list' aria-hidden='true' style='color:#FF5733;'></span></a>";
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