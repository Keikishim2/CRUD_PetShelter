<?php
/*DOCU: inserting through MySQL
     password: NO
     
     $name = mysqli_real_escape_string($connect, $_POST["name"]);  
     $type = mysqli_real_escape_string($connect, $_POST["type"]); 

     author: Kei Kishimoto*/
     $connect = mysqli_connect("localhost", "root", "", "testing");  
     if(!empty($_POST))  
{  
     $output = '';  
     $message = '';  
     $name = mysqli_real_escape_string($connect, $_POST["name"]);  
     $type = mysqli_real_escape_string($connect, $_POST["type"]); 
     if($_POST["pets_id"] != '')  
     {  
          $query = "  
          UPDATE tbl_crud
          SET 
          name='$name',   
          type='$type'  
          WHERE id='".$_POST["pets_id"]."'";  
          $message = 'Data Updated';  
     }  
     else  
     {  
          $query = "  
          INSERT INTO tbl_crud(name, type)  
          VALUES('$name', '$type');  
          ";  
          $message = 'Data Inserted';  
     }
     if(mysqli_query($connect, $query))  
     {  
          $output .= '<label class="text-success">' . $message . '</label>';  
          $select_query = "SELECT * FROM tbl_crud ORDER BY id ASC";  
          $result = mysqli_query($connect, $select_query);  
          $output .= '  
               <table class="table-borderless">  
                    <tr>  
                         <th>Pet Name</th>
                         <th>Type</th>   
                         <th>Details</th>  
                         <th>Edit</th> 
                    </tr>  
          ';  
          while($row = mysqli_fetch_array($result))  
          {  
               $output .= '  
                    <tr>  
                         <td>' . $row["name"] . '</td>
                         <td>' . $row["type"] . '</td> 
                         <td><input type="button" name="view" value="Details" id="' . $row["id"] . '" class="view_data" /></td>
                         <td><input type="button" name="edit" value="Edit" id="'.$row["id"] .'" class="edit_data" /></td> 
                    </tr>  
               ';  
          }  
          $output .= '</table>';  
     }  
     echo $output;  
}  
?>
