<?php
include "../includes/header.php";
include "../config/database.php";
session_start();
 if(!isset($_SESSION['email'])){
    header("Location:  http://localhost/CorePHP/login.php");
    exit;
 }
$email = $_SESSION['email'];
//  echo $email;
// if(!isset($email)){
//     header("Location :  http://localhost/CorePHP/view/login.php");
//     exit;
// }
  $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
     if(!$result){
    header("Location:  http://localhost/CorePHP/login.php");   
    exit;
     }
     else if(mysqli_num_rows($result) > 0){
             $user = mysqli_fetch_assoc($result);
           if($user["role"] == "user" ){
            header("Location:  http://localhost/CorePHP/user/index.php");
             exit;
            }
            else{
                $username = $user["name"];
            }
     }
// echo "Admin Dashboard";
?>
<body>
    

<main>
    <div  class="container" >
    <div>
        <a href="../auth/logout.php" class="logout-link" > Log Out</a>
    </div>
<h1>Welcome  <?php  // echo "$username" ?></h1>


<div>
    <?php 
      $query = "SELECT * FROM user WHERE role='user'";
      $result = mysqli_query($conn,$query);
      $id = 1;
      echo "<table class='table' > <tr class='head-row' ><th class='table-head' >Serial No</th> <th class='table-head' >Name</th> <th class='table-head' >Email</th> <th class='table-head' >Age</th>  <th class='table-head' >Gender</th> <th class='table-head' >Role</th>  </tr><tbody class='table-body' >";
      while($row = mysqli_fetch_assoc($result)){
         echo "<tr class='body-row' > <td class='body-data' >".$id."</td>
                    <td class='body-data' >".$row['name']."</td> 
                    <td class='body-data' >".$row['email']."</td>
                    <td class='body-data' >".$row['age']."</td>
                    <td class='body-data' >".$row['gender']."</td>
                    <td class='body-data' >".$row['role']."</td>
                     </tr>";
                    $id++;
      };
      echo "</tbody> </table>";

    ?>
</div> 
</div>
</main>

<?php 
include "../includes/footer.php";
?>