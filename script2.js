function loadcode(){
   var name= document.getElementById("name");
   var xhttp = new XMLHttpRequest()
   xhttp.onreadystatechange=function(){
    if(this.readyState==4&&this.status==200){
        document.getElementById("code").innerHTML = this.responseText;
    }
   };
   xhttp.open(GET,"get_code.php?name"+name,true)
   xhttp.send()

}