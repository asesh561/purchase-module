<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
  <div>
  <button onclick="taxmaster()">TAX MASTER TABLE<button>
</div>
<script>
  function taxmaster(){
  window.location.href= 'taxmastertable.php';
  } 
  </script>
  <script>
    function clearForm() {
  document.getElementById("myForm").reset();
}

  </script>
  <div style="text-align: center">
  <h3 style="background-color: rgb(181, 181, 235)">TAX MASTERS</h3>
  </div>
<div style="padding:0.5%;">
  <button onclick="Home()">Home</button>
</div>

      <h5>All * fields stars are mandetory</h5>
      <form action="" method="post" id="myForm">
        Tax Code :<input type="text"  name="tc" /><br /><br />
        Description:<input
          type="text"
          
          name="description"
        /><br /><br />
        Tax code value:<input
          type="number"
          
          name="tcv"
        /><br /><br />
        Formula:<input type="radio"  name="any" value="Formula" />
         Flat:<input
          type="radio"
          value="Flat"
          name="any"
        /><br /><br />

        <input type="submit" value="save" />
        <button  onclick="clearForm()">cancel</button>
      </form>
    </div>
  </body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

 } 

 if(isset($_POST['tc']))
 {
  $tc= $_POST['tc'];
  $description=$_POST['description'];
  $tcv = $_POST['tcv'];
  $any =$_POST['any'];

  $sql= "insert into tax_master (tc,description,tcv,any) values('$tc',' $description','$tcv','$any')";

  if(mysqli_query($conn,$sql))
  {
    echo "data created successfully";
  }
  else
  {
    echo "data creation failed". mysqli_error($conn);
  }

 }
?>