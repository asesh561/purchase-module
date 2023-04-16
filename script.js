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

function loadvalues() {
  var po = document.getElementById("po").value;

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("item_code1").value = this.responseText;
    }
  };
  xhttp.open("GET", "get_itemcode1.php?po=" + po, true);
  xhttp.send();

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("description1").value = this.responseText;
    }
  };
  xhr.open("GET", "get_desc1.php?po=" + po, true);
  xhr.send();

  var xnr = new XMLHttpRequest();
  xnr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("units1").value = this.responseText;
    }
  };
  xnr.open("GET", "get_units.php?po=" + po, true);
  xnr.send();
}
