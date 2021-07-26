<?php
/*DOCU: connecting queries through MySQL
    password: NO
    
    author: Kei Kishimoto*/
$connect = mysqli_connect("localhost", "root", "", "testing");
$query = "SELECT * FROM tbl_crud ORDER BY id ASC";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Petshelter</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/pet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <h2>PETSHELTER</h2>
                <ul class="navlinks">
                    <li><a href="#" class="active">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Events</a></li>
                    <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn"><i class="fas fa-plus-circle"></i> Add pets to shelter</button>
                </ul>
            </nav>
        </header>
        <div class="shop">
            <img src="./assets/images/1.png">
            <h1>Let's <span class="adopt">Adopt</span><br>Don't <span class="shop_span">Shop</span></h1><!--
            --><p>Lorem ipsum dolor sit amet, consectetur<br>adipiscing elit. Neque id lorem nisi.</p>
        </div>
        <h3>These pets are looking for a good home</h3>
    </div>
        <div id="pets_table">
            <table class="table-borderless">
                <tr>
                    <th>Pet Name</th>
                    <th>Type</th>   
                    <th>Details</th>  
                    <th>Edit</th> 
                </tr>
                <?php
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["type"]; ?></td>
                        <td><i class="fas fa-clipboard-list"><input type="button" name="view" value="Details" id="<?php echo $row["id"]; ?>" class=" view_data" /></td>
                        <td><i class="fas fa-edit"></i><input type="button" name="edit" value="Edit" id="<?php echo $row["id"]; ?>" class=" edit_data" /></td>
                    </tr>
                    <?php
                    }
                    ?>
            </table>
            <footer>Ⓒ2020. <span class="v88">V88Studios.</span> All Rights Reserved</footer>
            </div>
        </div>
    </div>
</body>
</html>
<!--DOCU:
    Launching bootstrap modal

    author: Kei Kishimoto-->
<div id="dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pets</h4>
            </div>
            <div class="modal-body" id="pets_detail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn like" data-dismiss="modal"><i class="fas fa-heart"></i> Like</button>
                <button type="button" class="btn adopt_pet" data-dismiss="modal"><i class="fas fa-home"></i> Adopt</button>
            </div>
        </div>
    </div>
</div>
<div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pet Details</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="insert_form">
                    <label>Pet Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                    <br />
                    <label>Pet Type:</label>
                    <textarea name="type" id="type" class="form-control"></textarea>
                    <br />
                    <input type="hidden" name="pets_id" id="pets_id" /><i class="fas fa-save"></i>
                    <input type="submit" name="insert" id="insert" value="Insert" class="btn insert" />
                </form>
            </div>
        </div>
    </div>
</div>
<!--DOCU:
    Editing Pet Details
    include: fetch.php

        $('#name').val(data.name);
        $('#type').val(data.type);

    author: Kei Kishimoto-->
<script>
    $(document).ready(function() {
        $('#add').click(function() {
            $('#insert').val("Add Pet");
            $('#insert_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function() {
            var pets_id = $(this).attr("id");
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data: {
                    pets_id: pets_id
                },
                dataType: "json",
                success: function(data) {
                    $('#name').val(data.name);
                    $('#type').val(data.type);
                    $('#pets_id').val(data.id);
                    $('#insert').val(" Save Changes");
                    $('#add_data_Modal').modal('show');
                }
            });
        });
/*DOCU: 
    Validating and inserting forms
    include: insert.php
        Pet name: required!
        Pet type: required!
        
    author: Kei Kishimoto*/
        $('#insert_form').on("submit", function(event) {
            event.preventDefault();
            if ($('#name').val() == "") {
                alert("Name is required");
            } else if ($('#type').val() == '') {
                alert("Type is required");
            } else {
                $.ajax({
                    url: "insert.php",
                    method: "POST",
                    data: $('#insert_form').serialize(),
                    beforeSend: function() {
                        $('#insert').val("Updating");
                    },
                    success: function(data) {
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#pets_table').html(data);
                    }
                });
            }
        });
/*DOCU: 
    Viewing details
        including select.php
        
    author: Kei Kishimoto*/
        $(document).on('click', '.view_data', function() {
            var pets_id = $(this).attr("id");
            if (pets_id != '') {
                $.ajax({
                    url: "select.php",
                    method: "POST",
                    data: {
                        pets_id: pets_id
                    },
                    success: function(data) {
                        $('#pets_detail').html(data);
                        $('#dataModal').modal('show');
                    }
                });
            }
        });
    });
</script>