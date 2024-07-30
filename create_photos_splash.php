<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sling Shot Display</title>  
    <script src="./assets/js/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script src="./assets/js/jquery-ui.js"></script>
    <script src="./assets/js/html2canvas.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <style>
  *{
      font-family: 'Montserrat', sans-serif !important;
  }
    body{
/*      background:#0C356D;*/
      background: url('./assets/img/AI-02.jpg');
      background-size: 100vw 100vh;
      background-repeat: no-repeat;
      overflow:hidden;
    }
    #notesContainer {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      gap: 20px;
      font-family: arial;
    }

    /* Style for each note */
    .note {
/*      width: 49%;      */
      width: 250px;
      position: absolute;
/*      height: 120px;      */
      /*background-size: 90%!important;*/
      /*background-size: contain !important;*/
      background-size: cover !important;
      background-repeat: no-repeat !important;
      height: 300px;
      background-position: center !important;
      overflow: hidden;
      background: white;
/*      padding: 10px;*/
/*      background-color: #f0f0f0;*/
    /*background-size:cover;
    background-repeat: no-repeat;
    background-position: top;*/
      border-radius: 5px;
      display: flex;          
    flex-wrap: wrap;
    }

    .note-header{
      display: flex;
        width: 100%;
        align-items: center;
        justify-content: flex-start;
        /* flex-wrap: wrap; */
        gap: 0px;
        flex-direction: column;
        padding: 1%;
/*        margin-top: -80px !important;*/
    }

    /* Style for the image in each note */
    .note img {
    width: 80px;
    height: 80px;
/*    z-index:1;*/
    position:relative;
    /*width: 46%;*/
    /*height: 52%;*/
/*    width: 90px;*/
    border-radius: 200%;
/*      height: 60%;*/
/*      padding: 40px 0;*/
      background-color: #ffffff3d;
/*      margin-left: -30px;*/
    }

    .note-message{
      text-align: center;
      width: 65%;
      position: absolute;
/*      bottom: 110px !important;*/
/*      top: 90px;*/
/*      height: 45px;*/
      /*background-image: linear-gradient(to right,#E5E6E6, #FEFEFE,#E5E6E6);
      border: 1px solid black;*/
      padding: 8px;
      border-radius: 200px;
    }

    .note h3 {
      margin: 5px 0;
/*      font-size: 16px;*/
      font-size: 10px;
      font-weight: bold;
      color: white;
    }

    /* Style for the message in each note */
    .note p {
      margin: 0;
      font-size: 16px !important;
      margin: 0 auto;
      line-height: 20px;
      font-size: 14px;
/*      font-family: cursive;*/
      color:white;
      padding: 5px 10px;
      font-weight: 900;
    }
    .note span{
      color:#3e3939;
      padding: 3px;
      word-wrap: break-word;
      font-size: 0.7rem;
      font-weight: 600;
    } 
    #tracker {
      width: 100px;
      height: 100px;
      background: url('./assets/img/target-aim.png');
      background-size: contain;
      border-radius: 50%;
      position: absolute;
      display: none;
      top:50%;
      left:50%;
      z-index: 999999;
    }
    .message{
      z-index: 1;
      text-align: center;
      width: 75%;
      position: absolute;
      bottom: 21%;
      font-size: 0.8rem;
      background: white;
      /* height: 45px; */
/*      background-image: linear-gradient(to right,#E5E6E6, #FEFEFE,#E5E6E6);*/
      border: 1px solid #F72461;
      padding: 10px;
      border-radius: 200px
    }
  </style>
</head>
<body onload="fetchNotes();">
  <div style="position: absolute;width: 98%;display: flex;align-items: center;justify-content: left;margin: 20px 50px;">
     <img src="./assets/img/FINAL AIKYATA.png" width="200"/>
  </div>
    <!-- <img src="./assets/img2/Slingshot logo_19 Jun.png" width="200" height="125" style="position:absolute;right:10px;"/> -->
<!--  <div style="display:block;text-align: center;padding:20px;">-->
<!--    <img src="./assets/img/logo.png" style="width:180px !important;margin:0 !important;height: auto;padding: 0;background: none;">-->
<!--</div>-->
  <div id="tracker"></div>
  <div id="notesContainer"></div>
  <img id="capturedImage" src="" style="display: none;">
  <div id="custom-div" style="width: 400px;height: 400px;position: absolute;top: 500px;"></div>
  <script>

  // Global variable to store the notes on the wall
    let notes = [];

    // Maximum number of notes allowed on the wall
    const maxNotes = 10;

    var total_notes = 0;

    // Image folder containing the images
    const imageFolder = './assets/img/';


    const tracker = $('#tracker');
    let x = window.innerWidth / 2;
    let y = window.innerHeight / 2;
    var initial_pos;
    var animationDuration = 1000; 

    $(document).ready(function () {
      initial_pos = $('#tracker').offset();
      
      // Start fetching orientation data
      // fetchOrientationData();
    })

    var last_x,last_y;
    // function updateTrackerPosition(alpha, beta) {                
    //   const newX =(initial_pos.left - 150) - (alpha * 15) ; // Adjust the sensitivity by changing the multiplier
    //   const newY =(initial_pos.top * 4 ) - (beta * 15);
    //   x = Math.max(0, Math.min(window.innerWidth, newX));
    //   y = Math.max(0, Math.min(window.innerHeight, newY));    
    //   // $('#tracker').css('left', x+'px');
    //   // $('#tracker').css('top', y+'px');    
    //   // console.log(window.innerWidth);
    //   // console.log(window.innerHeight);
    //     if(y!=0){        
    //       if(x < 1280 && y < 550){
    //         $('#tracker').stop().animate({
    //           left: x + 'px',
    //           top: y + 'px'
    //         }, animationDuration, 'linear');
    //       }                      
    //     }      
    // }


    // var gamma_old =0;
    // var beta_old =0;
    // function fetchOrientationData() {
    //   // Fetch orientation data from the file using jQuery AJAX
    //   $.get('readData.php')
    //     .done((data) => {

    //       if(data != 'null'){
    //         const orientation = JSON.parse(data);
    //         if( (orientation.gamma > 0 || orientation.gamma < 0) &&  (orientation.beta > 0 || orientation.beta < 0)){
                            
    //           updateTrackerPosition(orientation.gamma, orientation.beta);
    //           if(gamma_old!= orientation.gamma && beta_old != orientation.beta){
    //             gamma_old= orientation.gamma;
    //             beta_old = orientation.beta;

    //             $('#tracker').show();
    //           }
    //         }                            
            
    //       }
          
    //       // Fetch data again after a short delay
    //       setTimeout(fetchOrientationData, 0); // Adjust the delay as needed
    //     })
    //     .fail((error) => {
    //       console.error('Error fetching orientation data:', error);
    //     });
    // }
    

    

    // Fetch notes from the server and update the wall
function fetchNotes() {
  $.ajax({
    url: 'fetch_notes.php',
    dataType: 'json',
    success: function(data) {
      // Store the fetched notes
      var note = data.notes;    

      // Clear existing notes on the wall
      $('#notesContainer').empty();
      for (var i = 0; i <= note.length - 1; i++) {

        var margin_top = '0';
          var margin_left = 'auto';
          var note_message_bottom ='0';
          var width = '250px';
          if(note[i].img_id == 4){
            margin_top = '-100px';            
            // margin_left = '5px';
            note_message_bottom = '130px';
            // width = '270px';
          }
          
          // else if(note.img_id == 7){
          //   // margin_top = '58px';
          //   if(screen.width < 1325)
          //   { 
          //     margin_top = '-25px'; 
          //     margin_left = '-5px';
          //   }
          //   else{
          //     margin_top = '-30px'; 
          //     margin_left = '-5px';
          //   }
            
          // }
          else if(note[i].img_id == 1){
                margin_left = '15px';
                 margin_top = '-100px';
                 note_message_bottom = '45%';
          }
          else if(note[i].img_id == 2){
                 margin_left = '15px';
                 margin_top = '-100px';
                 note_message_bottom = '45%';
          }
          else if(note[i].img_id == 3){
            margin_left = '15px';
             margin_top = '-100px';
             note_message_bottom = '45%';
          }
          else if(note[i].img_id == 5){
            //   margin_top = '55px';
            margin_top = '-85px';
            note_message_bottom = '115px';
          }
          else if(note[i].img_id == 6){
            margin_top ='-100px';
            note_message_bottom = '130px';        
          }
          else{
            margin_top = '0';
          }
          if(note[i].message.toString() == 'a'){
            note[i].message = '';
          }
          if(note[i].message.toString() == 'a'){
            note[i].message = '';
          }
          

      var randomLeft,randomTop;
      // var get_current_pos = $('#tracker').offset();
      //   $.get('read_data.php')
      //   .done((data) => {

      //     if(data != 'null'){
      //       const orientation = JSON.parse(data);
      //       if( (orientation.gamma > 0 || orientation.gamma < 0) &&  (orientation.beta > 0 || orientation.beta < 0))
      //         $('#tracker').hide();               
      //       // updateTrackerPosition(orientation.gamma, orientation.beta);
      //         var newX =(get_current_pos.left - 100) - (orientation.alpha * 15) ; // Adjust the sensitivity by changing the multiplier
      //         var newY =(get_current_pos.top-40 * 4 ) - (orientation.beta * 15);
      //         randomLeft = Math.max(0, Math.min(window.innerWidth, newX));
      //         randomTop = Math.max(0, Math.min(window.innerHeight, newY));    
      //     }
                    
      //   })
      //   .fail((error) => {
      //     console.error('Error fetching orientation data:', error);
      //   });
               
          // var noteHTML = `<div class="note" style="background:url('./assets/img/` + note.img_id + `.svg');top:` + (get_current_pos.top-40) + `px;left:` + (get_current_pos.left-100) + `px;z-index:` + note.ID + `;">` +
          //   '<div class="note-image"></div>' +
          //   '<div class="note-header" style="margin-top:'+ margin_top +';margin-left:'+ margin_left +'"><img src="' + note.photo + '">' +
          //   '<div class="note-message"><p>' + note.name + '</p><span>'+note.message+'</span></div></div>' +
          //   '' +
          //   '</div>';
        var final_message ='';
        if(note[i].message.toString() == ''){
            
          }
          else{
            final_message = '<div class="message">'+note[i].message+'</div>';
          }
        var noteHTML2 = `<div class="note" id="note-`+note[i].ID+`" style="background:transparent;z-index:` + note[i].ID + `;width:400px;height:400px;">` +
            `<div style="width: 100%;height: 70%;position: absolute;"><img src="./assets/img/` + note[i].img_id + `.png" style="width: 100%;height: 100%;background-color: transparent;"></div><div class="note-image"></div>` +
            '<div class="note-header" style="margin-top:'+ margin_top +';margin-left:'+ margin_left +'"><img src="' + note[i].photo + '">' +
            '<div class="note-message" style="bottom:'+note_message_bottom+'"><p style="position:relative;">' + note[i].name + '</p></div>'+final_message+'</div>' +
            '</div>';  

      $('#custom-div').html(noteHTML2);
      // var my_note = document.getElementById('custom-div');
      var my_note = document.getElementById("note-"+note[i].ID);
      html2canvas(my_note,{ useCORS: true, allowTaint: false }).then(canvas => {
         // if (canvas.width === 0 || canvas.height === 0) {
         //            console.error('Captured canvas has invalid dimensions.');
         //            return;
         //        }
                // const desiredWidth = 800; // set your desired width here
                // const desiredHeight = 800; // set your desired height here
                
                // // Create a new canvas with the desired size
                // var resizedCanvas = document.createElement('canvas');
                // resizedCanvas.width = desiredWidth;
                // resizedCanvas.height = desiredHeight;
                
                // var ctx = resizedCanvas.getContext('2d');
                
                // Draw the original canvas content into the resized canvas
                // ctx.drawImage(canvas, 0, 0, desiredWidth, desiredHeight);
                // Convert the canvas to a data URL
                let imgData = canvas.toDataURL('image/png');
                
                // Display the captured image
                document.getElementById('capturedImage').src = imgData;
                // document.getElementById('capturedImage').style.display = 'block';
                
                // Send the data URL to the server
                fetch('save_image.php', {
                    method: 'POST',
                    body: JSON.stringify({ image: imgData }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    // alert('Image saved successfully!');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });  
      }
      
    },
    error: function() {
      // alert('Failed to fetch notes');
    }
  });
}


    // Add a new note to the wall
    function addNote() {
      // Get the input values
      const photo = photoData;
      const name = nameInput.value;
      const message = messageInput.value;


      // Create a new note object
      const newNote = {
        photo: photo,
        name: name,
        message: message
      };

      // Add the new note at the beginning of the notes array
      notes.unshift(newNote);

      // Remove the oldest note if the number of notes exceeds the limit
      if (notes.length > maxNotes) {
        notes.pop();
      }

      // Clear the input fields
      nameInput.value = '';
      messageInput.value = '';

      // Update the wall
      updateWall();
    }

     function checkRows(){
      $.ajax({
        url: 'row_count.php',        
        success: async function (data) {
          // Store the fetched notes                 
          if(data.count > total_notes){            
            // total_notes++;
            await get_the_row();
          }
        },
        error: function () {
          // alert('Failed to fetch notes');
        }
      });      
    }

    async function get_the_row() {
  await $.ajax({
    url: 'fetch_latest_row.php',
    success: function(note) {
      // let len = 0;
      // if(note.length > 1){
      //   len = note.length - 1;
      // }
      // if(note.length <= 1){
      //   len = note.length;
      // }

      for (var i = 0; i <= note.length - 1; i++) {
        total_notes++;

        // Store the fetched notes
      var windowWidth = window.innerWidth - (0.3 * window.innerWidth);
      var windowHeight = window.innerHeight - (0.35 * window.innerHeight);
      var min = 0;
      var max = 100;

      var randomLeft1, randomTop1, randomLeft2, randomTop2;
      var overlap = true;

      while (overlap) {
        randomLeft1 = Math.floor(Math.random() * windowWidth);
        randomTop1 = Math.floor(Math.random() * windowHeight);
        randomLeft2 = Math.floor(Math.random() * windowWidth);
        randomTop2 = Math.floor(Math.random() * windowHeight);

        overlap = false;

        if (Math.abs(randomLeft2 - randomLeft1) < 200 || Math.abs(randomTop2 - randomTop1) < 100) {
          overlap = true;
          continue;
        }

        $('.note').each(function() {
          var noteLeft = parseInt($(this).css('left'), 10);
          var noteTop = parseInt($(this).css('top'), 10);
          var distanceX = Math.abs(randomLeft2 - noteLeft);
          var distanceY = Math.abs(randomTop2 - noteTop);
          if (distanceX < 200 && distanceY < 100) {
            overlap = true;
            return false; // Exit the loop
          }
        });
      }
      
         //  var margin_top = '0';
         //  var margin_left = 'auto';
         // // note.left = randomLeft;
         //  note.top = randomTop;
        
          var margin_top = '0';
          var margin_left = 'auto';
          var note_message_bottom ='0';
          var width = '250px';
          if(note[i].img_id == 4){
            margin_top = '-100px';            
            // margin_left = '5px';
            note_message_bottom = '130px';
            // width = '270px';
          }
          
          // else if(note.img_id == 7){
          //   // margin_top = '58px';
          //   if(screen.width < 1325)
          //   { 
          //     margin_top = '-25px'; 
          //     margin_left = '-5px';
          //   }
          //   else{
          //     margin_top = '-30px'; 
          //     margin_left = '-5px';
          //   }
            
          // }
          else if(note[i].img_id == 1){
                margin_left = '15px';
                 margin_top = '-100px';
                 note_message_bottom = '45%';
          }
          else if(note[i].img_id == 2){
                 margin_left = '15px';
                 margin_top = '-100px';
                 note_message_bottom = '45%';
          }
          else if(note[i].img_id == 3){
            margin_left = '15px';
             margin_top = '-100px';
             note_message_bottom = '45%';
          }
          else if(note[i].img_id == 5){
            //   margin_top = '55px';
            margin_top = '-85px';
            note_message_bottom = '115px';
          }
          else if(note[i].img_id == 6){
            margin_top ='-100px';
            note_message_bottom = '130px';        
          }
          else{
            margin_top = '0';
          }
          if(note[i].message.toString() == 'a'){
            note[i].message = '';
          }
          if(note[i].message.toString() == 'a'){
            note[i].message = '';
          }
          

      var randomLeft,randomTop;
      // var get_current_pos = $('#tracker').offset();
      //   $.get('read_data.php')
      //   .done((data) => {

      //     if(data != 'null'){
      //       const orientation = JSON.parse(data);
      //       if( (orientation.gamma > 0 || orientation.gamma < 0) &&  (orientation.beta > 0 || orientation.beta < 0))
      //         $('#tracker').hide();               
      //       // updateTrackerPosition(orientation.gamma, orientation.beta);
      //         var newX =(get_current_pos.left - 100) - (orientation.alpha * 15) ; // Adjust the sensitivity by changing the multiplier
      //         var newY =(get_current_pos.top-40 * 4 ) - (orientation.beta * 15);
      //         randomLeft = Math.max(0, Math.min(window.innerWidth, newX));
      //         randomTop = Math.max(0, Math.min(window.innerHeight, newY));    
      //     }
                    
      //   })
      //   .fail((error) => {
      //     console.error('Error fetching orientation data:', error);
      //   });
               
          // var noteHTML = `<div class="note" style="background:url('./assets/img/` + note.img_id + `.svg');top:` + (get_current_pos.top-40) + `px;left:` + (get_current_pos.left-100) + `px;z-index:` + note.ID + `;">` +
          //   '<div class="note-image"></div>' +
          //   '<div class="note-header" style="margin-top:'+ margin_top +';margin-left:'+ margin_left +'"><img src="' + note.photo + '">' +
          //   '<div class="note-message"><p>' + note.name + '</p><span>'+note.message+'</span></div></div>' +
          //   '' +
          //   '</div>';
        var final_message ='';
        if(note[i].message.toString() == ''){
            
          }
          else{
            final_message = '<div class="message">'+note[i].message+'</div>';
          }


          var noteHTML = `<div class="note" style="background:transparent;top:` + randomTop2 + `px;left:` + randomLeft2 + `px;z-index:` + note[i].ID + `;width:`+ width +`;">` +
            `<div style="width: 100%;height: 70%;position: absolute;"><img src="./assets/img/` + note[i].img_id + `.png" style="width: 100%;height: 100%;background-color: transparent;"></div><div class="note-image"></div>` +
            '<div class="note-header" style="margin-top:'+ margin_top +';margin-left:'+ margin_left +'"><img src="' + note[i].photo + '">' +
            '<div class="note-message" style="bottom:'+note_message_bottom+'"><p style="position:relative;">' + note[i].name + '</p></div>'+final_message+'</div>' +
            '</div>';  
            
          
        // var noteHTML = `<div class="note" style="background:transparent;top:` + (get_current_pos.top-40) + `px;left:` + (get_current_pos.left-100) + `px;z-index:` + note.ID + `;width:`+ width +`;">` +
        //     `<div style="width: 100%;height: 70%;position: absolute;"><img src="./assets/img/` + note.img_id + `.png" style="width: 100%;height: 100%;background-color: transparent;"></div><div class="note-image"></div>` +
        //     '<div class="note-header" style="margin-top:'+ margin_top +';margin-left:'+ margin_left +'"><img src="' + note.photo + '">' +
        //     '<div class="note-message" style="bottom:'+note_message_bottom+'"><p>' + note.name + '</p></div>'+final_message+'</div>' +
        //     '</div>';  

      // var noteHTML = `<div class="note" style="background:url('./assets/img/Splash ` + note.img_id + `.png');top:` + randomTop2 + `px;left:` + randomLeft2 + `px;z-index:` + note.ID + `;">` +
      //   '<div class="note-image"></div>' +
      //   '<div class="note-header"><img src="' + note.photo + '">' +
      //   '<div class="note-message"><p>' + note.name + '</p><span>'+note.message+'</span></div></div>' +
      //   '' +
      //   '</div>';

      var notesCount = $('.note').length;
      if (notesCount >= 10) {
        $('.note:last').remove(); // Remove the oldest note
      }

      $('#notesContainer').prepend(noteHTML); // Add the new note at the beginning of the notesContainer
      

      // Add the new note to the notes array or update the existing note
      // ...  
      }
      

    },
    error: function() {
      // alert('Failed to fetch notes');
    }
  });
}



    // Update the wall with the current notes
    function updateWall() {
      // Clear existing notes on the wall
      $('#notesContainer').empty();

      // Iterate over the notes and create new notes
      try{
        notes.forEach(function (note,index) {
          // Generate a random index to select an image        
          if(index==14){
            throw new Error("Break the loop.")
          }          
          const randomIndex = Math.floor(Math.random() * 16) + 1;
          const imageUrl = imageFolder + randomIndex + '.jpg';
          var windowWidth = 800;
          var windowHeight = 300;              
          var randomLeft = Math.floor(Math.random() * (windowWidth ));
          var randomTop = Math.floor(Math.random() * (windowHeight ));
          var noteHTML = `<div class="note" style="background:url('./assets/img2/`+note.img_id+`.png');top:`+randomTop+'px;left:'+randomLeft+'px;">' +
            '<div class="note-image"></div>' +
            '<img src="' + note.photo + '">' +
            '<h3>' + note.name + '</h3>' +
            '<p>' + note.message + '</p>' +
            '</div>';
          $('#notesContainer').append(noteHTML);
        });
      }
      catch(error){
        
      }      
    }

    // Fetch notes initially and set an interval to continuously check for updates
   //  fetchNotes();   
  </script>
</body>
</html>