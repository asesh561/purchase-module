<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$payment_method = $_GET['payment_method'];

$sql = "SELECT choice, payment_mode, cash_code FROM payments WHERE payment_method='" . $payment_method . "'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $data = array(
    'choice' => $row['choice'],
    'payment_mode' => $row['payment_mode'],
    'cash_code' => $row['cash_code']
  );
  foreach ($data as $key => $value) {
    echo '<select id="' . $key . '" name="' . $key . '">';
    // create an option element for each value
    foreach ($value as $option) {
      echo '<option value="' . $option . '">' . $option . '</option>';
    }
    echo '</select>';
  }
} else {
  echo "No items found";
}

mysqli_close($conn);
?>