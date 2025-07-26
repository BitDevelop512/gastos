<?php
session_start();
error_reporting(0);
$archivo = $_GET['valor'];
?>
<html lang="es">
<head>
  <style>
  .myVideo
  {
    position: relative;
  }
  .exampleVideoPage
  {
    margin-top: 5px;
    position: relative;
    width: 80%;
    max-width: 70rem;
    margin: auto;
  }
  </style>
  <link rel="stylesheet" href="dist/css/rtop.videoPlayer.1.0.0.min.css">
  <link rel="stylesheet" href="dist/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <script src="dist/js/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
  <script src="dist/js/rtop.videoPlayer.1.0.0.min.js"></script>
</head>
<body>
  <div class="box-body">
    <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
    <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
      <div class="exampleVideoPage">
        <div class="myVideo" id="my_video" data-video="<?php echo $archivo; ?>" data-poster="" data-type='video/mp4'></div>
      </div>
    </div>
  </div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  var vid = $('#my_video').RTOP_VideoPlayer({
    showFullScreen: true,
    showTimer: true,
    showSoundControl: true
  });
});
</script>
</body>
</html>