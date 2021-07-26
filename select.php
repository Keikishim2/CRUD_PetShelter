
<?php
/*DOCU: selecting through MySQL
     password: NO
     
     $result = mysqli_query($connect, $query); 

     author: Kei Kishimoto*/
     if(isset($_POST["pets_id"]))  
{  
     $output = '';  
     $connect = mysqli_connect("localhost", "root", "", "testing");  
     $query = "SELECT * FROM tbl_crud WHERE id = '".$_POST["pets_id"]."'";  
     $result = mysqli_query($connect, $query);  
     $output .= '  
          <table class="table">';  
     while($row = mysqli_fetch_array($result))  
     {  
          $output .= '  
          <tr>  
               <td><label>Name</label></td>  
               <td>'.$row["name"].'</td>  
          </tr>  
          <tr>  
               <td><label>Type</label></td>  
               <td>'.$row["type"].'</td>  
          </tr>  
          ';  
     }  
     $output .= '  
          </table>  
     </div>  
     ';  
     echo $output;  
     }  
?>
