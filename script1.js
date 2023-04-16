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

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var response = JSON.parse(this.responseText);
      document.getElementById("item_code").value = response.item_code;
      document.getElementById("description").value = response.description;
      document.getElementById("units").value = response.units;
    }
  };
  xhr.open("GET", "get_values.php?po=" + po, true);
  xhr.send();
  var po = document.getElementById("po").value;

  var xnr = new XMLHttpRequest();
  xnr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var response = JSON.parse(this.responseText);
      document.getElementById("aq").value = response.aq;
      document.getElementById("rq").value = response.rq;
      document.getElementById("shrinkage").value = response.shrinkage;
      document.getElementById("price").value = response.price;
      document.getElementById("bag_type").value = response.bag_type;
      document.getElementById("bag").value = response.bag;
    }
  };
  xnr.open("GET", "get_values1.php?po=" + po, true);
  xnr.send();
}
