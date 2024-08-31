<!DOCTYPE html>
<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>

  <video id="myVideo" controls="controls" style="height: 400px;">
    <source src="video.mp4" type="video/mp4">
      <source src="video.mp4" type="video/ogg">
        Your browser does not support HTML5 video.
  </video>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
<script type="text/javascript">
$("#myVideo").on("ended", function() {
   //TO DO: Your code goes here...
      alert("Video Finished");
});

$("#myVideo").on("loadedmetadata", function() {
      alert("Video loaded");
  // this.currentTime = 50;//50 seconds
   //TO DO: Your code goes here...
});


$("#myVideo").on("timeupdate", function(e) {

	console.log(this.currentTime);
  var cTime=this.currentTime;
  if(cTime>0 && cTime % 2 == 0)//Alerts every 2 minutes once
      alert("Video played "+cTime+" minutes");
   //TO DO: Your code goes here...
  var perc=cTime * 100 / this.duration;
  if(perc % 10 == 0)//Alerts when every 10% watched
      alert("Video played "+ perc +"%");
});	
</script>
</html>