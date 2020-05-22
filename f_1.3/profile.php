<!DOCTYPE html>
<?php
// Start the session
session_start();
$desgn=$_SESSION["desgn"];
$branch=$_SESSION["branch"];
$id = $_SESSION['user_id'];
$host="localhost";
$user="root";
$pass="";
$db="college_project";
$conn=new mysqli($host,$user,$pass,$db);
if($desgn==1){$post='Principal';}
elseif($desgn==2){$post='Head of Department';}
else{$post='Teacher';}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3857a76116.js" crossorigin="anonymous"></script>
    <style>
        .fa-times-circle {
  color: red;
}
.fa-check-circle
{
    color: green;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 1%">
        <a class="navbar-brand" href="index.php" style="font-weight:bold">OBE Tool</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="dash.php">Dashboard</a>
            </li>
            <li class="nav-item">
              
            <?php
                        if ($_SESSION['desgn']==3){
                        echo '<a href="SPEC_CO.php" class="nav-link">Curriculum</a> ';
                        }
                        elseif($_SESSION['desgn']==1 or $_SESSION['desgn']==2 ){
                          echo'<a href="set_curr.php" class="nav-link">Curriculum</a> ';
                        }
                        
                        ?>    
            </li>
            <li class="nav-item">
                <a class="nav-link" href="report.php">Report</a>
              </li>
          </ul> 
          <?php 
          
          if(session_status() == PHP_SESSION_NONE){ 
            echo '<button class="btn btn-light" data-toggle="modal" data-target="#Modal2" style="margin-right: 1%;">
            <strong>SIGN UP</strong> <i class="fas fa-user-plus"></i>
            </button>';
          
          echo '<button class="btn btn-light" data-toggle="modal" data-target="#Modal" style="margin-right: 1%;">
                <strong>LOGIN</strong> <i class="fas fa-sign-in-alt"></i>
                </button>';
         }
          else {
          echo '<button class="btn btn-light active" style="margin-right: 1%;">
          <strong>'.$_SESSION["f_name"].' '.$_SESSION["s_name"].'</strong></button>';
          echo '<form method="post"><button type="submit" class="btn btn-danger" name="can_cred">LOGOUT</button></form>';
          if(isset($_POST['can_cred'])){
            header("Location:index.php");
            session_destroy();
            } 
          }
          ?>
        </div>
    </nav>
    
    <div class="container-fluid">
        <h4 style="text-align:center;margin:1%">PROFILE DETAILS</h4>
        <hr>
        <div class="row" style="padding-left:1%;padding-right:1%;padding-bottom:1%">
            <div class="col-4" style="border-right:0.1px solid rgb(226,226,226);height:60vh;">
                <div class="jumbotron">
                    <h3 class="display-5">Hello, Prof. <?echo $_SESSION["f_name"].' '.$_SESSION["s_name"];?> !</h3>
                    <p class="lead" style="margin-top: 5%"><strong>Id:</strong> <?echo $id?></p>
                    <p class="lead"><strong>Branch:</strong>  <?echo $branch?></p>
                    <p class="lead"><strong>Designation:</strong> <?echo $post?></p>

                    <hr class="my-2">
                    <p style="font-size:3%;margin-bottom:2%">You can update the profile here...</p>
                    <a class="btn btn-primary btn-lg" href="#" role="button" style="margin-right: 2%">Update</a>
                    <a class="btn btn-warning btn-lg" href="#" role="button">Change Password</a>

                </div>
            </div>
            <div class="col-4" style="border-right:0.1px solid rgb(226,226,226);height:60vh">
                <h5 style="text-align:center;">SUBJECTS</h5>
                <div style="height:60vh; overflow-y: scroll;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">*</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Batch</th>
                        </tr>
                    </thead>
                    <tbody style="height:60vh; overflow-y: scroll;">
                    <?php  
                    $q_disp="SELECT * FROM $branch WHERE teacher_id='$id'";
                    $result_display = mysqli_query($conn,$q_disp) or die("ERROR".mysqli_error($conn));
                    $no=1;
                    while ( $row_display = mysqli_fetch_array($result_display) )
                        {
                    ?>
                        <tr>
                        <th scope="row"><?echo $no?></th>
                        <td><?echo $row_display['sub_name']?></td>
                        <td><?echo 'Sem : '.$row_display['semester'].' || Year : '.$row_display['year']?></td>
                        </tr>
                    <?php
                    $no=$no+1;
                        }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col-4">
                <h5 style="text-align:center;">TASKS</h5>
                <div style="height:60vh; overflow-y: scroll;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">*</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Note</th>
                        <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody style="height:60vh; overflow-y: scroll;">
                    <?php  
                    $alert_query="SELECT * FROM `alert_db` WHERE teacher_id='$id'";
                    $alert_fire = mysqli_query($conn,$alert_query) or die("ERROR".mysqli_error($conn));
                    $no=1;
                    while ( $row_display = mysqli_fetch_array($alert_fire) )
                        {if($row_display['status']==1){
                    ?>
                        <tr>
                        <th scope="row"><?echo $no?></th>
                        <td><?echo $row_display['sub']?></td>
                        <td><?echo $row_display['message'].'</br>'.'Batch : Sem- '.$row_display['sem'].'||Year- '.$row_display['year']?></td>
                        <td><button class="btn btn-primary" onclick="alert_ok(  '<?php echo $row_display['teacher_id'] ?>',
                                                                                '<?php echo $row_display['sub'] ?>',
                                                                                '<?php echo $row_display['sem'];?>',
                                                                                '<?php echo $row_display['year']; ?>',
                                                                                '<?php echo $branch; ?>')"><i class="fas fa-check"></i></button></td>
                        </tr>
                    <?php
                    $no=$no+1;}
                        }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
<div id="result"></div>
</body>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();
    function alert_ok(id,sub,sem,year,branch){
        data = {sub:sub,sem:sem,t_id:id,branch:branch,year:year};
        $.post("alert_ok.php",data,
        function(data){
            $('#result').html(data)
        });
    }
</script>

</html>