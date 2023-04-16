<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid green;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
        .container{
          text-align: right;
        }
        
        </style>
</head>
<body>
    Form date:<input type="date" name="date" >
    To date:<input type="date" name="date" >
    supplier code:<select>
        <option>--select option--</option>
    </select>
    supplier name:<select>
        <option>--select name--</option>
    </select>
    Item:<select>
        <option>--select item--</option>
    </select>
    Description:<select>
        <option>--select description--</option>
    </select>
    Status:<select>
        <option>--status--</option>
    </select><br><br>
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }


?>


<br>

    <table id="table">
    <tr>
    <th>Supplier code</th>
    <th>Supplier Name</th>
    <th>PO DATE</th>
    <th>PURCHASE ORDER</th>
    <th>ITEM</th>
    <th>DESCRIPTION</th>
    <th>RATE PER UNIT</th>
    <th>ORDERED QUANTITY</th>
    <th>REQUIRED QUANTITY</th>
    <th>T DATE</th>
    <th>RECEIVED DATE</th>
    <th>STATUS</th>
    <th>D.LOCATION</th>
    <th>DOC NO</th>
</tr>

<?php
  //$id=12;//$_GET['id'];
  $sql= "SELECT po.*, qty.aq, qty.rq
  FROM purchase_order po
  JOIN quantity qty ON po.po = qty.po";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_assoc($result))
    {
      
      
      ?>
      <tr>
    <td><?php echo $row['code']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['po']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['rate_unit']; ?></td>
    <td><?php echo $row['aq']; ?></td>
      <td><?php echo $row['rq']; ?></td>
    </tr>
  
  <?php } } ?>
  
    </table>
</body>
</html>