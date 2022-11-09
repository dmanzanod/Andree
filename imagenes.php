<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Verdana, sans-serif;
  margin: 0;
}

* {
  box-sizing: border-box;
}

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
<body>

<h2 style="text-align:center">Documentos Enviados</h2>

<div class="row">
<?php 
    $con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,"bd_andree");

    $sql = "SELECT id, hash FROM tbl_requerimientos WHERE id = '".$_GET['j']."'";

    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
        $hash = $row['hash'];
    }
    
    $sql = "SELECT nombre_original, nombre_servidor FROM tbl_imagenes where hash = '".$hash."'";

    $result = mysqli_query($con,$sql);
    $j=1;
    while($row = mysqli_fetch_array($result)) {
        
        $thumbnail_path = "http://app.andreebienestar.cl/upload/".$row['nombre_servidor'];
        $image_path = "http://app.andreebienestar.cl/upload/".$row['nombre_servidor'];
        
        echo '<div class="column">';
        echo '<img src="http://app.andreebienestar.cl/upload/'.$row['nombre_servidor'].'" style="width:100%" onclick="openModal();currentSlide('.$j.')" class="hover-shadow cursor">';
        echo '</div>';
        $j++;
    }
    mysqli_close($con);
 ?>
</div>

    <div id="myModal" class="modal">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <div class="modal-content">


<?php 
    $con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,"bd_andree");

    $sql = "SELECT id, hash FROM tbl_requerimientos WHERE id = '".$_GET['j']."'";

    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
        $hash = $row['hash'];
    }
    
    $sql = "SELECT nombre_original, nombre_servidor FROM tbl_imagenes where hash = '".$hash."'";

    $result = mysqli_query($con,$sql);
    $i=1;
    
    $j = $j-1;
    while($row = mysqli_fetch_array($result)) {
        echo '<div class="mySlides">';
        echo '<div class="numbertext">'.$i.' / '.$j.'</div>';
        echo '<img src="http://app.andreebienestar.cl/upload/'.$row['nombre_servidor'].'" style="width:100%">';
        echo '</div>';
        
        $i++;
    }
    
    mysqli_close($con);
 ?>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="caption-container">
      <p id="caption"></p>
    </div>


<?php 
    $con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,"bd_andree");

    $sql = "SELECT id, hash FROM tbl_requerimientos WHERE id = '".$_GET['j']."'";

    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
        $hash = $row['hash'];
    }
    
    $sql = "SELECT nombre_original, nombre_servidor FROM tbl_imagenes where hash = '".$hash."'";

    $result = mysqli_query($con,$sql);
    $i=1;
    while($row = mysqli_fetch_array($result)) {
        echo '<div class="column">';
        echo '<img class="demo cursor" src="http://app.andreebienestar.cl/upload/'.$row['nombre_servidor'].'" style="width:100%" onclick="currentSlide('.$i.')" alt="">';
        echo '</div>';
        
        $i++;
    }
    mysqli_close($con);
 ?>
  </div>
</div>

<script>
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>
    
</body>
</html>