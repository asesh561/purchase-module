<form method="GET" action="city.php">
  <label for="state">State:</label>
  <select id="state" name="state">
  <option value="" <?php if(empty($_GET['state'])) echo 'selected'; ?>>--select state--</option>
    <?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "purchase_module";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $state = $_GET['state'];

    $sql ="SELECT DISTINCT state FROM cities";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        
         $selected = ($state == $row['state']) ? 'selected' : '';
        echo "<option value=\"" . $row['state'] . "\"" . $selected . ">" . $row['state'] . "</option>";
    }
    ?>
  </select>

  <label for="city">City:</label>
  <select id="city" name="city">
    <!-- options will be populated dynamically -->
  </select>

  <input type="button" name="report" id="report" value="Report" onclick="reloadpage();">

  <script>
    function reloadpage() {
      var state = document.getElementById('state').value;
      document.location = "city.php?state=" + state
    };



//     window.onload = function() {
//     document.location = "city.php?state="+--select state--;
// };

  </script>
</form>

