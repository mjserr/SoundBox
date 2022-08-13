<!DOCTYPE html>
<html>
<head>
	<title>music player</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style2.css">
</head>

<body>

  <div class="main">
  	<p id="logo"><i class="fa fa-music"></i>Music</p>
    
    <!--- left part --->
     <div class="left">

      <!--- song img --->
      <img id="track_image">
         <div class="volume">
            <p id="volume_show">90</p>
            <i class="fa fa-volume-up" aria-hidden="true" onclick="mute_sound()" id="volume_icon"></i>
            <input type="range" min="0" max="100" value="90" onchange="volume_change()" id="volume">  
         </div>

     </div>
 

     <!--- right part --->
  	 <div class="right">

        <div class="show_song_no">
          <p id="present">1</p>
          <p>/</p>
          <p id="total">5</p>
        </div>

       <!--- song title & artist name --->
      <p id="title">title.mp3</p>
      <p id="artist">Artist name</p>

      <!--- middle part --->
  	 	<div class="middle">
  	       <button onclick="previous_song()" id="pre"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
      	   <button onclick="justplay()" id="play"><i class="fa fa-play" aria-hidden="true"></i></button>
  	       <button onclick="next_song()" id="next"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
  	   </div>

       <!--- song duration part --->
        <div class="duration">
           <input type="range" min="0" max="100" value="0" id="duration_slider" onchange="change_duration()">
        </div>
           <button id="auto" onclick="autoplay_switch()">Auto play <i class="fa fa-circle-o-notch" aria-hidden="true"></i></button>
  	</div>


  </div>

  <!--- php file --->
  <?php

    include "../db_conn.php";
    /**
    $sql = "SELECT song FROM users";
    $result = mysql_query($sql) or die ('Query Error: ' . mysql_error()); 
    while ($results = mysql_fetch_array($result))
    {
        $gender[] = $results;
    }

    **/
    $result = mysqli_query($conn,"SELECT * FROM users");
    $result2 = mysqli_query($conn,"SELECT * FROM users");
    $result3 = mysqli_query($conn,"SELECT * FROM users");
    $result4 = mysqli_query($conn,"SELECT * FROM users");
    $music_names = array();
    $music_singer = array();
    $music_song = array();
    $music_cover = array();
/**names**/
    if(mysqli_num_rows($result) > 0){
      while ($row = mysqli_fetch_array($result)) {
          $music_names[] = $row['name'];
      }
    }

    /**singer**/
    if(mysqli_num_rows($result2) > 0){
      while ($row = mysqli_fetch_array($result2)) {
          $music_singer[] = $row['singer'];
      }
    }
    if(mysqli_num_rows($result3) > 0){
      while ($row = mysqli_fetch_array($result3)) {
          $music_song[] = $row['song'];
      }
    }
      if(mysqli_num_rows($result4) > 0){
      while ($row = mysqli_fetch_array($result4)) {
          $music_cover[] = $row['cover'];
      }
    }
    
  ?>


   
  <!--- Add javascript file --->
  <script>

    let previous = document.querySelector('#pre');
    let play = document.querySelector('#play');
    let next = document.querySelector('#next');
    let title = document.querySelector('#title');
    let recent_volume= document.querySelector('#volume');
    let volume_show = document.querySelector('#volume_show');
    let slider = document.querySelector('#duration_slider');
    let show_duration = document.querySelector('#show_duration');
    let track_image = document.querySelector('#track_image');
    let auto_play = document.querySelector('#auto');
    let present = document.querySelector('#present');
    let total = document.querySelector('#total');
    let artist = document.querySelector('#artist');


    let timer;
    let autoplay = 0;

    let index_no = 0;
    let Playing_song = false;

    //create a audio Element
    let track = document.createElement('audio');

    //array sample
    var music_names= <?php echo json_encode($music_names); ?>;
    var music_singer= <?php echo json_encode($music_singer); ?>;
    var music_song= <?php echo json_encode($music_song); ?>;
    var music_cover= <?php echo json_encode($music_cover); ?>;
    
    //All songs list

    let All_song = [];
    for(var i=0; i<music_names.length; i++)  {
        All_song.push({
          name: music_names[i], 
          singer: music_singer[i], 
          img: music_cover[i],
          path: music_song[i]});
    }



    // let All_song = [
    //    { name: "7 years", path: "music/LukasGraham.mp3", img: "img/LukasGraham.jpg", singer: "LukasGraham"},
    // ];


    // All functions


    // function load the track
    function load_track(index_no){
      clearInterval(timer);
      reset_slider();

      track.src = All_song[index_no].path;
      title.innerHTML = All_song[index_no].name;  
      track_image.src = All_song[index_no].img;
        artist.innerHTML = All_song[index_no].singer;
        track.load();

      timer = setInterval(range_slider ,1000);
      total.innerHTML = All_song.length;
      present.innerHTML = index_no + 1;
    }

    load_track(index_no);


    //mute sound function
    function mute_sound(){
      track.volume = 0;
      volume.value = 0;
      volume_show.innerHTML = 0;
    }


    // checking.. the song is playing or not
     function justplay(){
      if(Playing_song==false){
        playsong();

      }else{
        pausesong();
      }
     }


    // reset song slider
     function reset_slider(){
      slider.value = 0;
     }

    // play song
    function playsong(){
      track.play();
      Playing_song = true;
      play.innerHTML = '<i class="fa fa-pause" aria-hidden="true"></i>';
    }

    //pause song
    function pausesong(){
      track.pause();
      Playing_song = false;
      play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
    }


    // next song
    function next_song(){
      if(index_no < All_song.length - 1){
        index_no += 1;
        load_track(index_no);
        playsong();
      }else{
        index_no = 0;
        load_track(index_no);
        playsong();

      }
    }


    // previous song
    function previous_song(){
      if(index_no > 0){
        index_no -= 1;
        load_track(index_no);
        playsong();

      }else{
        index_no = All_song.length;
        load_track(index_no);
        playsong();
      }
    }


    // change volume
    function volume_change(){
      volume_show.innerHTML = recent_volume.value;
      track.volume = recent_volume.value / 100;
    }

    // change slider position 
    function change_duration(){
      slider_position = track.duration * (slider.value / 100);
      track.currentTime = slider_position;
    }

    // autoplay function
    function autoplay_switch(){
      if (autoplay==1){
           autoplay = 0;
           auto_play.style.background = "rgba(255,255,255,0.2)";
      }else{
           autoplay = 1;
           auto_play.style.background = "#fff";
      }
    }


    function range_slider(){
      let position = 0;
            
            // update slider position
        if(!isNaN(track.duration)){
           position = track.currentTime * (100 / track.duration);
           slider.value =  position;
            }

           
           // function will run when the song is over
           if(track.ended){
             play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
               if(autoplay==1){
               index_no += 1;
               load_track(index_no);
               playsong();
               }
          }
         }
  </script>

</body>
</html>