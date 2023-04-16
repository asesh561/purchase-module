<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <script>
    function loadcode() {
  var name = document.getElementById("name").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("code").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "get_code.php?name=" + name, true);
  xhttp.send();
}
</script>


    <h3>Payment</h3>
  <form action="" method="post">
   <body>
    
    Doc no :<input type="text" name="dn">
    <script>
    var counter = localStorage.getItem("counter")||0;

    document.addEventListener('DOMContentLoaded', function(){
    document.querySelector('input[name="dn"]').value = ++counter;
    localStorage.setItem('counter', counter);
})
</script>

  
   Date:<input type="date" name="date" />

    cost center :<select name=cost_center>
      <option>--select center--</option>
      <?php 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "purchase_module";
      
      $conn = mysqli_connect($servername, $username, $password, $dbname);
      if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
      
       }
       $sql="select distinct cost_center from payments";
       $result = mysqli_query($conn,$sql);
       while ($row = mysqli_fetch_assoc($result))
       {
        echo "<option>" . $row['cost_center'] . "</option>";
       }
       ?>
    </select>
    vendor:<select name="name" id="name" onchange="loadcode()";>
      <option>--select vendor--</option>
      <?php 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "purchase_module";
      
      $conn = mysqli_connect($servername, $username, $password, $dbname);
      if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
      
       }
       $sql="select distinct name from supplier";
       $result = mysqli_query($conn,$sql);
       while ($row = mysqli_fetch_assoc($result))
       {
        echo "<option>" . $row['name'] . "</option>";
       }
      ?>
    </select>
    vendor code:<select name="code" id="code">
      <option>--select vendor code--</option>
      </select>
    payment method:<select name="payment_method" id="payment_method" onchange="loadvalues()";>
      <option>--select payment method--</option>
      <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "purchase_module";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
        
         }
         $sql="select distinct payment_method from payments";
       $result = mysqli_query($conn,$sql);
       while($row=mysqli_fetch_assoc($result))
       {
        echo "<option>" . $row['payment_method'] . "</option>";
       }
      ?>
      </select
    ><br /><br />
    choice:<select id="choice" name="choice">
      
      <option>--select choice--</option>
      <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "purchase_module";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
        
         }
         $sql="select distinct choice from payments";
       $result = mysqli_query($conn,$sql);
       while($row=mysqli_fetch_assoc($result))
       {
        echo "<option>" . $row['choice'] . "</option>";
       }
      ?>
    </select>
    payment mode:<select id="payment_mode" name="payment_mode">
      <option>--select payment mode--</option>
      <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "purchase_module";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
        
         }
         $sql="select distinct payment_mode from payments";
       $result = mysqli_query($conn,$sql);
       while($row=mysqli_fetch_assoc($result))
       {
        echo "<option>" . $row['payment_mode'] . "</option>";
       }
      ?>
    </select>
    Cash code :<select id="cash_code" name="cash_code">
      <option>--select cash code--</option>
      <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "purchase_module";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
        
         }
         $sql="select distinct cash_code from payments";
       $result = mysqli_query($conn,$sql);
       while($row=mysqli_fetch_assoc($result))
       {
        echo "<option>" . $row['cash_code'] . "</option>";
       }
      ?></select><br /><br />
    <div style="display: inline-block; width: 12%">
      <label for="Iteam code">code</label><br /><br />
      <input type="text" name="code1" />
    </div>
    <div style="display: inline-block; width: 12%">
      <label for="Description">Description</label><br /><br />
      <input type="text" name="description" />
    </div>
    <div style="display: inline-block; width: 12%">
      <label for="cr">cr</label><br /><br />
      <input type="text" name="cr" value="cr" />
    </div>
    <div style="display: inline-block; width: 12%">
      <label for="Amount">Amount</label><br /><br />
      <input type="text" name="Amount" />
    </div>
    <br /><br />
    Narration:<input type="text" name="narration" />

    <div style="text-align: center;">
      <input type="submit" value="submit">
      <input type="submit" value="cancel">
      
    </div>
    
    
  </body>
</form>
  
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
 if(isset($_POST['name'])){

$date = $_POST['date'];
$dn = $_POST['dn'];
$name = $_POST['name'];
$cost_center=$_POST['cost_center'];
$code=$_POST['code'];
$payment_method=$_POST['payment_method'];
$choice=$_POST['choice'];
$payment_mode=$_POST['payment_mode'];
$cash_code=$_POST['cash_code'];
$code1=$_POST['code1'];
$description=$_POST['description'];
$cr=$_POST['cr'];
$Amount=$_POST['Amount'];
$narration=$_POST['narration'];

$sql= "INSERT INTO `payment_details` (`date`,`dn`, `cost_center`, `name`, `code`, `payment_method`, `choice`, `payment_mode`, `cash_code`, `code1`, `description`, `cr`, `Amount`, `narration`) VALUES ('$date','$dn', '$cost_center', '$name', '$code', '$payment_method', '$choice', '$payment_mode', '$cash_code', '$code1', '$description', '$cr', '$Amount', '$narration')";

if(mysqli_query($conn,$sql))
{
  echo"data inserted successfully";
}
else{
  echo "failed".mysqli_error($conn);
}
 }

?>
