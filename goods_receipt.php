<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script></div>
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
function loadvalues(){
 var po= document.getElementById("po").value;

 var xhttp= new XMLHttpRequest();
 xhttp.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    document.getElementById("item_code").value = this.responseText;
  }
};
xhttp.open("GET", "get_itemcode1.php?po=" + po, true);
xhttp.send();

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(){
  if (this.readyState == 4 && this.status == 200) {
    document.getElementById("description").value = this.responseText;
  }
};
xhr.open("GET", "get_desc1.php?po=" + po, true);
xhr.send();

var xnr = new XMLHttpRequest();
xnr.onreadystatechange = function(){
  if (this.readyState == 4 && this.status == 200) {
    document.getElementById("units").value = this.responseText;
  }

};
xnr.open("GET", "get_units.php?po=" + po, true);
xnr.send();

 }
</script>
</head>
<body>
<h3>GOODS RECEIPT</h3>
<button onclick="loadgoodordertable()">Goods order table</button>
  <script>
  function loadgoodordertable()
  {
    window.location.href = 'goods_receipttable.php';
  }

</script><br><br>
  <form action="" method="post">
    Date:<input type="date" name="date">
    
    Vendor:<select name="name" onchange="loadcode()" id="name";>
        <option>--select--</option>
        <?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

 }
 $sql= "select distinct name from supplier";
 $result = mysqli_query($conn,$sql);
 while($row= mysqli_fetch_assoc($result))
 {
    echo "<option value=\"" . $row['name'] . "\">" . $row['name'] . "</option>";
 }
 ?>
    </select>
    Vendor Code:<select name="code" id="code">
        <option>--select--</option>
    </select>
    Gate Entry #<select name="po" id="po" onchange="loadvalues()" >
        <option>--select--</option>
        <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "purchase_module";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
        }
         $sql = "select distinct po from purchase_order";
         $result = mysqli_query($conn,$sql);
         while($row= mysqli_fetch_assoc($result))
         {
          echo "<option value=\"" . $row['po'] . "\">" . $row['po'] . "</option>";
         }


        ?>
    </select>
    <br><br><br>

    <div style="display: inline-block; width:12%">
    <label for="Item code">Item code</label><br><br>
    <input type="text" id="item_code" name="item_code">       
</div> 
<div style="display: inline-block; width: 12%; position: relative; right: 33px;">
        <label for="Description">Item Description</label><br><br>
        <input type="text" name="description"id="description" >
    </div>

    <div style="display: inline-block; width: 12%;">
        <label for="Units">Units</label><br><br>
        <input type="number" name="units" id="units" >
    </div>

    <div style="display: inline-block; width: 12%; position: relative; left: 30px;">
  <label for="Accepted Quantity">Accepted Quantity</label><br><br>
  <input type="number" name="aq" id="aq" >
</div>

<div style="display: inline-block; width: 12%; position: relative; left: 77px;">
  <label for="Receving Quantity">Receving Quantity</label><br><br>
  <input type="number" name="rq" id="rq" >
</div>

  <div style="display: inline-block; width: 12%; position: relative; left: 77px;">
    <label for="Shrinkage">Shrinkage</label><br><br>
    <input type="number" name="shrinkage" id="shrinkage" >
  </div></div>
  <div style="display: inline-block; width: 12%; position: relative; left: 77px;">
    <label for="Price">Price</label><br><br>
    <input type="price" name="price" id="price" >
  </div>
  <div style="display: inline-block; width: 12%; position: relative; left: 77px;">
    <label for="Bag Type">Bag Type</label><br><br>
    <input type="text" name="bag_type" id="bag_type" >
  </div>
  <div style="display: inline-block; width: 12%; position: relative; left: 77px;">
    <label for="Bag">Bag</label><br><br>
    <input type="price" name="bag" id="bag" >
  </div><br><br>

  <div style="display: inline-block; width: 12%; position: relative; left: 77px;">
    <label for="Remarks">Remarks</label><br><br>
    <input type="text" name="remarks" id="remarks">
  </div>
  <div style="text-align:center;">
  <input type="submit" value="submit">
  <button>cancel</button>
</div>
  </form>
<script src="script1.js"></script>
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
 if(isset( $_POST['name'])){
 $date = $_POST['date'];
 $name = $_POST['name'];
 $code = $_POST['code'];
 $po = $_POST['po'];
 $item_code = $_POST['item_code'];
 $description = $_POST['description'];
 $units = $_POST['units'];
 $aq = $_POST['aq'];
 $rq = $_POST['rq'];
 $shrinkage = $_POST['shrinkage'];
 $price = $_POST['price'];
 $bag_type = $_POST['bag_type'];
 $bag = $_POST['bag'];
 $remarks= $_POST['remarks'];

 $sql = "INSERT INTO `goods_receipt` (`date`, `name`, `code`, `po`, `item_code`, `description`, `units`, `aq`, `rq`, `shrinkage`, `price`, `bag_type`, `bag`, `remarks`) VALUES ('$date', '$name', ' $code', '$po', ' $item_code', ' $description', ' $units', ' $aq', ' $rq', ' $shrinkage', ' $price', ' $bag_type', '$bag', '$remarks')";

 if(mysqli_query($conn,$sql))
 {
  echo "Data inserted successfully";
 }
 else
 {
  echo "data creation failed". mysqli_error($conn);
 }
}
?>
