<!DOCTYPE html>
<html lang="en">
<head>
<?php
// Start the session
session_start();
$host="localhost";
$user="root";
$pass="";
$db="college_project";
$conn=new mysqli($host,$user,$pass,$db);
$branch=$_SESSION['branch'];
$id = $_SESSION['user_id'];
$query="SELECT DISTINCT * FROM $branch";
$result = mysqli_query($conn,$query) or die("ERROR".mysqli_error($conn));
$result2 = mysqli_query($conn,$query) or die("ERROR".mysqli_error($conn));

$query1="SELECT DISTINCT `semester`, `year` FROM $branch";
$result1 = mysqli_query($conn,$query1) or die("ERROR".mysqli_error($conn));
$result3 = mysqli_query($conn,$query1) or die("ERROR".mysqli_error($conn));
#print_r($row);
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Specify PO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3857a76116.js" crossorigin="anonymous"></script>
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
            <li class="nav-item active">
              <a class="nav-link" href="SPEC_CO.php">Curriculum</a>
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
          echo '<button class="btn btn-light" data-toggle="modal" data-target="#Modal" style="margin-right: 1%;">
          <strong>'.$_SESSION['f_name'].' '.$_SESSION['s_name'].'</strong></button>';
          echo '<form method="post"><button type="submit" class="btn btn-danger" name="can_cred" href="index.php">LOGOUT</button></form>';
          if(isset($_POST['can_cred'])){
            header("Location:index.php");
            session_destroy();
            } 
          }
          ?>
        </div>
      </nav>

      
      <div class="container-fluid">
            <div class="row" style="padding: 1%;">
                <div class='col-2'>
                <nav class="nav flex-column" style="margin: 1%;">
                <a class="nav-link" href="set_curr.php" style="color:black;">Set Curriculum</a>
                <a class="nav-link" href="spec_po.php" style="color:green; font-weight: bold;"">Specify PO</a>
                <a class="nav-link active" href="SPEC_CO.php" style="color: black;">Specify CO </a>
                <a class="nav-link" href="CO_PO.php" style="color: black;">CO-PO Mapping</a>
                <a class="nav-link" href="marks_co.php" style="color: black;">Marks-CO Mapping</a>
                <a class="nav-link" href="marks.php" style="color: black;">Marks Data</a>
                </nav>
                </div>
                <div class='col-10'>
                <div class="container-fluid">
                  <div class="row">
                  <form class="needs-validation" method="post" action="" novalidate>
                  <div class="form-row" style="margin: 2%">
                  <div class="form-group" style="margin-right: 2%">
                  <select name="course" class="form-control custom-select" required>
                    <option value="" disabled selected>Choose Course</option>
                    <?php
                      while($row = mysqli_fetch_array($result)){
                    ?>
                <option><?echo "Subject : ".$row['sub_name']." ".$row['subject-code']." Semester : ".$row['semester']." || Year : ".$row['year']; ?></option>
                      <?}?>
                  </select>
                  </div>
                  <button type="submit" name="show_po" class="btn btn-info">View PO Specifications</button>
                  </div>
                  </form>
                  </div>
                  </div>
                  <?if(isset($_POST['show_po'])){?>
                    <div style="height:40vh; overflow-y: scroll;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">PO/PSO Code</th>
                          <th scope="col">Program Outcome || Program Specific Outcome</th>
                        </tr>
                        <?php
                        $sub=explode(" ",$_POST['course'])[2];
                        $sub_code=explode(" ",$_POST['course'])[3];
                        $sem=explode(" ",$_POST['course'])[6];
                        $year=explode(" ",$_POST['course'])[10];
                        $search_query="SELECT `po1`, `po2`, `po3`, `po4`, `po5`, `po6`, `po7`, `po8`, `po9`, `po10`, `po11`, `po12`, `pso1`, `pso2` FROM `po_db`  
                        WHERE `branch`='$branch' and `sub_name`='$sub' and `sub_code`='$sub_code' and `sem`='$sem' and  `year`='$year' ";
                        $search_result= mysqli_query($conn,$search_query) or die("ERROR".mysqli_error($conn));
                        $search_row = mysqli_fetch_array($search_result);           
                        ?>

                      </thead>
                      <tbody>
                        <tr>
                        <th scope="row">PO1</th>
                        <td><?echo $search_row['po1']?></td>
                        </tr>
                        <tr>
                          <th scope="row">PO2</th>
                          <td><?echo $search_row['po2']?></td>
                        </tr>
                        <tr>
                          <th scope="row">PO3</th>
                          <td><?echo $search_row['po3']?></td>
                        </tr>  
                        <tr>
                        <th scope="row">PO4</th>
                        <td><?echo $search_row['po4']?></td>
                        </tr>
                        <tr>
                          <th scope="row">PO5</th>
                          <td><?echo $search_row['po5']?></td>
                        </tr>
                        <tr>
                          <th scope="row">PO6</th>
                          <td><?echo $search_row['po6']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PO7</th>
                          <td><?echo $search_row['po7']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PO8</th>
                          <td><?echo $search_row['po8']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PO9</th>
                          <td><?echo $search_row['po9']?></td>
                        </tr>    
                        <tr>
                          <th scope="row">PO10</th>
                          <td><?echo $search_row['po10']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PO11</th>
                          <td><?echo $search_row['po11']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PO12</th>
                          <td><?echo $search_row['po12']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PSO1</th>
                          <td><?echo $search_row['pso1']?></td>
                        </tr> 
                        <tr>
                          <th scope="row">PSO2</th>
                          <td><?echo $search_row['pso2']?></td>
                        </tr>                                    
                      </tbody>
                    </table>
                    </div>
                    
                  <?}
                  else{
                  ?>
                  <div class="alert alert-info" role="alert" style="margin-left: 1%">
                  Please enter the above details to view the PO / PSO specifications
                  </div>
                 <? }?>
                <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#add_po" style="margin-left: 1%">Add Program Outcome</button>
              
              
              <!-- Modal -->
                  <div class="modal fade" id="add_po" tabindex="-1">
                    <div class="modal-dialog" >
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Add Course Outcomes</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                        <div class="modal-body" style="height:400px; overflow-y: scroll">
                        <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Subject || Subject-Code</label>
                          <select name="subject" class="form-control custom-select">
                            <option selected>Choose Subject</option>
                            <?php
                              while($row2 = mysqli_fetch_array($result2)){
                            ?>
                              <option><?echo $row2['sub_name']." ".$row2['subject-code']; ?></option>
                              <?}?>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                      <div class="form-group col-md-12">
                          <label>Semester || Year</label>
                          <select name="batch" class="form-control custom-select">
                            <option selected>Choose Semester</option>
                            <?php
                              while($row3 = mysqli_fetch_array($result3)){
                            ?>
                          <option><?echo "Semester : ".$row3['semester']." || Year : ".$row3['year']; ?></option>
                              <?}?>
                          </select>
                        </div>
                        </div>
                        <hr>
                        <div class="form-row" style="margin-top: 2%">
                          <label>PO1-Description</label>
                          <input type="text" class="form-control" name="po1" placeholder="PO1-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%">
                          <label>PO2-Description</label>
                          <input type="text" class="form-control" name="po2" placeholder="PO2-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%">
                          <label>PO3-Description</label>
                          <input type="text" class="form-control" name="po3" placeholder="PO3-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%">
                          <label>PO4-Description</label>
                          <input type="text" class="form-control" name="po4" placeholder="PO4-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%">
                          <label>PO5-Description</label>
                          <input type="text" class="form-control" name="po5" placeholder="PO5-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO6-Description</label>
                          <input type="text" class="form-control" name="po6" placeholder="PO6-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO7-Description</label>
                          <input type="text" class="form-control" name="po7" placeholder="PO7-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO8-Description</label>
                          <input type="text" class="form-control" name="po8" placeholder="PO8-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO9-Description</label>
                          <input type="text" class="form-control" name="po9" placeholder="PO9-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO10-Description</label>
                          <input type="text" class="form-control" name="po10" placeholder="PO10-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO11-Description</label>
                          <input type="text" class="form-control" name="po11" placeholder="PO11-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO12-Description</label>
                          <input type="text" class="form-control" name="po12" placeholder="PO12-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PO10-Description</label>
                          <input type="text" class="form-control" name="po10" placeholder="PO10-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PSO1-Description</label>
                          <input type="text" class="form-control" name="pso1" placeholder="PSO1-Description">
                        </div>
                        <div class="form-row" style="margin-top: 2%"> 
                          <label>PSO2-Description</label>
                          <input type="text" class="form-control" name="pso2" placeholder="PSO2-Description">
                        </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" name="add_po">Add Course Outcome</button>
                        </div>
                        </form>
                        <?php
                        if (isset($_POST['add_po'])){
                        $sub_o=$_POST['subject'];
                        $batch_o=$_POST['batch'];
                        $sub=explode(" ",$sub_o)[0];
                        $sub_code=explode(" ",$sub_o)[1];
                        $sem=explode(" ",$batch_o)[2];
                        $year=explode(" ",$batch_o)[6];
                        $po1=$_POST['po1'];
                        $po2=$_POST['po2'];
                        $po3=$_POST['po3'];
                        $po4=$_POST['po4'];
                        $po5=$_POST['po5'];
                        $po6=$_POST['po6'];
                        $po7=$_POST['po7'];
                        $po8=$_POST['po8'];
                        $po9=$_POST['po9'];
                        $po10=$_POST['po10'];
                        $po11=$_POST['po11'];
                        $po12=$_POST['po12'];
                        $pso1=$_POST['pso1'];
                        $pso2=$_POST['pso2'];
                        $add_query="INSERT INTO `po_db` (`branch`, `sem`, `sub_code`, `sub_name`, `year`, `po1`, `po2`, `po3`, `po4`, `po5`, `po6`, 
                        `po7`, `po8`, `po9`, `po10`, `po11`, `po12`, `pso1`, `pso2`) VALUES 
                         ('$branch','$sem','$sub_code','$sub','$year','$po1','$po2','$po3','$po4','$po5','$po6',
                         '$po7','$po8','$po9','$po10','$po11','$po12','$pso1','$pso2')";
                         $add_result = mysqli_query($conn,$add_query) or die("ERROR".mysqli_error($conn));
                          echo'<script>alert("Record added Successfully")</script>';
                        }
                        ?>
                      </div>
                    </div>
                  </div>
            </div>
      </div>
    </div>
    <script>
	function login_error() {
	alert("Function not available");
	}
</script>
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
</script>
</body>
</html>