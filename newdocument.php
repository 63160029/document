<?php
session_start();


if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
require_once("dbconfig.php");


if ($_POST){
    $doc_num = $_POST['doc_num'];
    $doc_title = $_POST['doc_title'];
    $doc_start_date = $_POST['doc_start_date'];
    $doc_to_date = $_POST['doc_to_date'];
    $doc_status = $_POST['doc_status'];
    $doc_file_name = $_FILES["doc_file_name"]["name"];

    
    $sql = "INSERT 
            INTO documents (doc_num,doc_title,doc_start_date,doc_to_date,doc_status,doc_file_name) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss",$doc_num,$doc_title,$doc_start_date,$doc_to_date,$doc_status,$doc_file_name);
    $stmt->execute();

    //uploadpart
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["doc_file_name"]["name"]);
    $fileType="pdf";
    $realname="a.pdf";
    if (move_uploaded_file($_FILES["doc_file_name"]["tmp_name"], $target_file)) {
      //echo "The file ". htmlspecialchars( basename( $_FILES["doc_file_name"]["name"])). " has been uploaded.";
    } else {
      //echo "Sorry, there was an error uploading your file.";
    }
    //

    // redirect ไปยัง document.php
    header("location: document.php");
}
echo "Welcome ".$_SESSION['stf_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>เพิ่มคำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        function checkdocnum() {
        var doc_num = document.getElementById("doc_num").value;
        //document.getElementById("disp").innerHTML = doc_num;
        var xhttp = new XMLHttpRequest();
        console.log("hello");
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status ==200 ) {
                // document.getElementByid("disp").innerHTML = this.responseText;
                if (this.responseText != ""){
                    document.getElementById("submit").disabled = true;
                    document.getElementById("disp").innerHTML = "<a href='addstafftodocument.php?id=" + 
                    this.responseText + "'>จัดการกรรมการ</a>";
                }else{
                    document.getElementById("submit").disabled = false;
                    document.getElementById("disp").innerHTML = "";
                }
            }
        };
        //console.log("hello");
        xhttp.open("GET", "checkdocnum.php?docnum=" + doc_num, true);
        //console.log("hello");
        xhttp.send();
    }
    </script>
</head>

<body>
    <div class="container">
        <h1><b style='color:#35589A;'>เพิ่มคำสั่งแต่งตั้ง</b></h1>
        <form action="newdocument.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="doc_num" style='color:#35589A;'>เลขที่คำสั่ง</label>
                <input type="text" class="form-control" name="doc_num" id="doc_num" onkeyup="checkdocnum()">
                <h3><div id = "disp"></div></h3>
            </div>
            <div class="form-group">
                <label for="doc_title" style='color:#35589A;'>ชื่อคำสั่ง</label>
                <input type="text" class="form-control" name="doc_title" id="doc_title">
            </div>
            <div class="form-group">
                <label for="doc_start_date" style='color:#35589A;'>วันที่เริ่มต้นคำสั่ง</label>
                <input type="date" class="form-control" name="doc_start_date" id="doc_start_date">
            </div>
            <div class="form-group">
                <label for="doc_to_date" style='color:#35589A;'>วันที่สิ้นสุด</label>
                <input type="date" class="form-control" name="doc_to_date" id="doc_to_date">
            </div>
            <div class="form-group">
                <label for="doc_status" style='color:#35589A;'>สถานะ</label>
                <input type="radio" name="doc_status" id="doc_status" value="Active"><b style='color:#35589A;'>Active</b>
                <br>&emsp;&emsp;&nbsp;&nbsp;
                &nbsp;<input type="radio" name="doc_status" id="doc_status" value="Expire"><b style='color:#35589A;'>Expire</b>
            </div>

            <div class="form-group" style='color:#35589A;'>
                <label for="doc_file_name">อัพโหลดไฟล์</label>
                <input type="file" class="form-control" name="doc_file_name" id="doc_file_name">
            </div>
            
            <button type="button" class="btn btn-warning" onclick="history.back();"><b>Back</b></button>
            <button type="submit" class="btn btn-success" id="submit"><b>Save</b></button>
        </form>
</body>

</html>