<?php  
/*DOCU: fetching queries
    connecting through MySQL
    password: NO
    
    author: Kei Kishimoto*/
$connect = mysqli_connect("localhost", "root", "", "testing");  
if(isset($_POST["pets_id"]))  
{  
    $query = "SELECT * FROM tbl_crud WHERE id = '".$_POST["pets_id"]."'";  
    $result = mysqli_query($connect, $query);  
    $row = mysqli_fetch_array($result);  
    echo json_encode($row);  
}  
?>