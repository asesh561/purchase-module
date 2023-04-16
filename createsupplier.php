<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
  </div>

    <div style="text-align: center">
      supplier details (fields marked starred are mandatory)
    </div>
    <br /><br /><br />
    <div style="text-align: center">
      <form action="" method="post">
        name:
        <input type="text" name="name" id="name" style="border: 1px solid blue" />
        code:
        <input type="number" name="code" id="code" /><br /><br />

        place:
        <input type="text" name="place" id="place" />
        Address:
        <input type="text" name="address" id="address" />
        Email id:
        <input type="email" name="email" id="email" /><br /><br />
        Phone:
        <input type="tel" name="phone" id="phone" />
        contact type:
        <select name="contact">
          <option value="supplier"name="contact">supplier</option>
          <option value="Tax-Master" name="contact">Tax-Master</option>
        </select><br /><br />
        Supplier group:
        <select name="supplier_group">
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select><br />
       currency:
        <input type="radio" name="currency" value="base_currency" />
        <input type="radio" name="currency" value="other_currency" /><br /><br />

        PAN/TIN:
        <input type="number" name="pan" id="pan" /><br /><br /><br />
        Note:
        <input type="text" name="note" value="Note" /><br><br>
        <div style="text-align: center">
          <input type="submit" class="btn" value="save">
        </div>
      </form>
      <br /><br />
    </div>
    <div style="padding:0.5%;">
  <button onclick="Home()">supplier table</button>
</div>
<script>
function Home(){
   window.location.href='suppliertable.php';
}
</script>
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
  $name = $_POST['name'];
  $code = $_POST['code'];
  $place = $_POST['place'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $contact=$_POST['contact'];
  $pan=$_POST['pan'];
  $supplier_group=$_POST['supplier_group'];
  
  $currency=$_POST['currency'] ;
  $note = $_POST['note'];
 

$sql ="INSERT INTO `supplier` (`name`, `code`, `place`, `email`, `address`, `phone`, `contact`, `pan`, `supplier_group`, `currency`, `note`) VALUES ( '$name', '$code', '$place', '$email', '$address', '$phone', '$contact', '$pan', '$supplier_group', '$currency', '$note');";

 if(mysqli_query($conn,$sql))
 {
    echo "data created successfully";
 }
 else{
    echo "Error creating data: " . mysqli_error($conn);
 }
}


?>
