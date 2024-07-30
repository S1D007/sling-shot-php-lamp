<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <title>Sling Shot</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
    <script src="./assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <script type="text/javascript" src="./assets/js/user.js"></script>    
    <script src="./assets/js/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script src="./assets/js/jquery-ui.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
     <style>
      body{
/*          background: url('./assets/img/Slingshot _28 JUNE-01.png');*/
/*          background:#0C356D;*/
          background-size: 100vw 100vh;
          background-repeat: no-repeat;
          margin: 0px;
        }
        .logo{
            position: absolute;
            /*left: 20px;
            top:20px;*/
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .footer{        
            position: absolute;
/*            left: 20px;*/
            bottom:20px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;        
      }
        @media only screen and (max-width:768px){
        body{
/*          background: url('./assets/img/Slingshot _28 JUNE-06.png') !important;*/
          background-size: 100vw 95vh !important;
          background-repeat: no-repeat !important;
        }
        .logo{
            position: relative;
            /* margin: 0 auto; */
            /* display: block; */
            /* text-align: center; */
            /* left: 25%; */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer img {
          width: 100%;
          padding: 20px;
        }
      }

      
    </style>
</head>
<body>
  <div class="logo">
    <img src="./assets/img/Logo 1.png" width="280" />
  </div>
  <input type="hidden" id="slingShotId" value="<?php echo $_GET['id']?>">
   <!-- First Screen - Capture Photo -->
<div id="screen1" class="screen">
  <div >
    <div >
      <div >
        <video id="videoElement" muted playsinline webkit-playsinline></video>
        <img id="capturedImage" alt="Captured Image">
        <button id="captureBtn" class="btn">CAPTURE</button>        
        <button id="retakeBtn" class="btn" style="display:none;">RE-TAKE</button>
        <button id="nextBtn" class="btn" style="display:none;">NEXT</button>
      </div>
    </div>
  </div>
</div>

<!-- Second Screen - Get Name and Message -->
<div id="screen2" class="screen" style="display: none;">
  <div class="container">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 mt-5">
        <!-- <img src="./assets/img/Asset 5@400x.png" class="custom-drone" /> -->
        <!-- <div id="photoPreview" class="photo-preview"></div> -->
        <form id="custom-form">
          <div class="mb-3">
            <!-- <label for="nameInput" class="form-label text-dark">Name</label> -->
            <input type="text" class="form-control shadow" id="nameInput" placeholder="Name" required>
          </div>
          <div class="mb-3">
            <!-- <label for="nameInput" class="form-label text-dark">Name</label> -->
            <input type="text" class="form-control shadow" id="employeeID" placeholder="Employee ID" required>
          </div>
          <div class="mb-3" style="display:none;">
            <!-- <label for="nameInput" class="form-label text-dark">Name</label> -->
            <input type="email" class="form-control shadow" id="emailInput" placeholder="Email" required>
          </div>
          <div class="mb-3" style="display: none;">
            <!-- <label for="nameInput" class="form-label text-dark">Name</label> -->
            <input type="tel" class="form-control shadow" id="mobileInput" placeholder="Mobile" required>
          </div>
          <div class="mb-3">
            <!-- <label for="messageInput" class="form-label text-dark">Message</label> -->
            <textarea class="form-control shadow" id="messageInput" rows="4" maxlength="90" placeholder="Message" required></textarea>
            <!-- <input type="text" class="form-control shadow" id="messageInput" placeholder="Social Media Handle"> -->
          </div>
          <input type="hidden" name="image" id="image" required>
        <button id="submitBtn" class="btn" style="">SUBMIT</button>          
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Third Screen - Success Message -->
<div id="screen3" class="screen" style="display: none;">
  <div class="container">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-auto" style="width: 100vw;justify-content: center;align-items: center;flex-wrap: wrap;display: flex;flex-direction: column;">        
        <button class="btn btn-xl shadow my-5" id="lock" onclick="lock_sensor()">Lock</button>
        <p style="color: #07375b;margin: 0 auto;vertical-align: middle;font-size: 1.6rem;font-weight: 900;bottom: 100px;">Let the magic come alive as you sling towards the screen!</p>        
        <!-- <span id="success-msg" class="text-success"><h2>Thank you for sharing the vibe!</h2></span>
        <button id="uploadNoteBtn" class="btn btn-primary" onclick="window.location.reload();">Share Vibe Again</button>                 -->                
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="footer">
    <img src="./assets/img/Logo 2.png" width="500" />
  </div>
</footer>

<script>
  // io.set('transports','websocket');
  // const socket = io("https://api.gokapturehub.com/", {'transports':['websocket']});

  // const socket = new Soc
  const socket = io('https://api.gokapturehub.com', {
    transports: ['websocket'],
  });
  // const socket = new WebSocket('https://api.gokapturehub.com');
  // socket.on("connect", () => {
  //   // console.log(socket.id); // x8WIv7-mJelg7on_ALbx    
  //   socket.emit('123',{'alpha':1,'beta':2,'gamma':3,'tracker':true});    
  // });
  

  // const ws = new WebSocket('ws://127.0.0.1:8081');
  // // const ws = new WebSocket('ws://192.168.29.189:8081');

  // ws.onopen = function() {
  //     console.log('WebSocket connection established');
  //     alert('WebSocket connection established');
  // };

  // ws.onerror = function(error) {
  //     console.log("WebSocket Error: " + error.message);
  //     alert("WebSocket Error: " + error.message);
  // };
// DOM elements
const screen1 = document.getElementById('screen1');
const screen2 = document.getElementById('screen2');
const screen3 = document.getElementById('screen3');
const videoElement = document.getElementById('videoElement');
const captureBtn = document.getElementById('captureBtn');
const capturedImage = document.getElementById('capturedImage');
const retakeBtn = document.getElementById('retakeBtn');
const nameInput = document.getElementById('nameInput');
const mobileInput = document.getElementById('mobileInput');
const emailInput = document.getElementById('emailInput');
const emp_id_input = document.getElementById('employeeID');
const messageInput = document.getElementById('messageInput');
const slingShot_Id = document.getElementById('slingShotId');

// const emailInput = document.getElementById('emailInput');
// const mobileInput = document.getElementById('mobileInput');
const imageInput = document.getElementById('image');
const submitBtn = document.getElementById('submitBtn');
var data;

let shouldWriteData = true;

// document.getElementById('uploadNoteBtn').addEventListener('click', addNote);
function lock_sensor() {
  lock = true;
  $('#lock').text('Locked');
  $('#lock').attr('disabled','disabled');
}
// Show the first screen and request user permission to use the camera
function showScreen1() {
  screen1.style.display = 'block';

  // Request user permission to use the camera
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(function (stream) {
      videoElement.srcObject = stream;
      videoElement.onloadedmetadata = function (e) {
        videoElement.play();
        videoElement.style.transform = 'scaleX(-1)';
        const videoWidth = videoElement.videoWidth;
        const videoHeight = videoElement.videoHeight;
        let squareSizeh, squareSizew;

        // let squareSize;
        // if (videoWidth > videoHeight) {
        //   squareSize = videoHeight;
        // } else {
        //   squareSize = videoWidth;
        // }
        // const offsetX = (videoWidth - squareSize) / 2;
        // const offsetY = (videoHeight - squareSize) / 2;
        squareSizeh = videoHeight;

        squareSizew = videoWidth;
        // Calculate the offset to center the square
        const offsetX = (videoWidth - squareSizew) / 2;
        const offsetY = (videoHeight - squareSizeh) / 2;


        videoElement.videoWidth = squareSizew;
        videoElement.videoHeight = squareSizeh;
      };
    })
    .catch(function (err) {
      console.error('Error accessing camera:', err);
    });
}

// Capture photo from video stream
// Capture photo from video stream
function capturePhoto() {
  // const canvas = document.createElement('canvas');
  // const context = canvas.getContext('2d');
  // canvas.width = videoElement.videoWidth;
  // canvas.height = videoElement.videoHeight;
  // context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
  // const photoData = canvas.toDataURL('image/jpeg');


  const videoWidth = videoElement.videoWidth;
  const videoHeight = videoElement.videoHeight;

  // Calculate the square size
  let squareSizeh, squareSizew;
  // if (videoWidth > videoHeight) {
  //   squareSize = videoHeight;
  // } else {
  //   squareSize = videoWidth;
  // }  
  squareSizeh = videoHeight;

  squareSizew = videoWidth;
  // Calculate the offset to center the square
  const offsetX = (videoWidth - squareSizew) / 2;
  const offsetY = (videoHeight - (squareSizeh - 115)) / 2;

  const canvas = document.createElement('canvas');
  const context = canvas.getContext('2d');
  canvas.width = squareSizew;
  canvas.height = squareSizeh;
  context.drawImage(videoElement, offsetX, offsetY, videoWidth, (videoHeight-115), 0, 0, videoWidth, videoHeight);
  const photoData = canvas.toDataURL('image/jpeg');

  // Convert the base64 image data to a Blob object
  const byteString = atob(photoData.split(',')[1]);
  const ab = new ArrayBuffer(byteString.length);
  const ia = new Uint8Array(ab);
  for (let i = 0; i < byteString.length; i++) {
    ia[i] = byteString.charCodeAt(i);
  }
  const blob = new Blob([ab], { type: 'image/jpeg' });
  
  // Create a FormData object and append the photo blob
  const formData = new FormData();
  formData.append('photo', blob, 'photo.jpg');  
  // Send the photo to the server using AJAX (Assuming you have jQuery library available)
  $.ajax({
    url: 'save_photo.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      // Handle the response from the server
      if (response.success) {
        const photoPath = response.photoPath;
        // showScreen2(photoPath);
        // console.log(photoPath);
        
        
        $('#retakeBtn').show();
        $('#capturedImage').attr('src',photoPath);
        $('#capturedImage').show();
        $('#nextBtn').show();
        $('#videoElement').hide();
        $('#captureBtn').hide();

      } else {
        console.error('Error saving photo:', response.error);
      }
    },
    error: function(xhr, status, error) {
      console.error('Error saving photo:', error);
    }
  });
//   showScreen2();

    // console.log(formData);
}

$('#retakeBtn').on('click',function(){
  $('#retakeBtn').hide();
  $('#capturedImage').hide();
  $('#nextBtn').hide();
  $('#videoElement').show();
  $('#captureBtn').show();
});

$('#nextBtn').on('click',function(){
  showScreen2($('#capturedImage').attr('src'));

});

// Show the second screen to get name and message
function showScreen2(photoData) {
  screen1.style.display = 'none';
  screen2.style.display = 'block';  

  // Set the captured photo as the background image  
  imageInput.value = photoData;
  // photoPreview.style.backgroundImage = `url(${photoData})`;
}

var counter =0;
var lock =false;
var tracker = false;
;(function(window, document, undefined) {
      "use strict";
      
      var elax = document.getElementById("ax"),
          elay = document.getElementById("ay"),
          elaz = document.getElementById("az"),
          sens = 0.05,
          dec = 2,
          a = null;

      var mouseListener = function(event) {
        if(null !== event.acceleration) {
          a = event.acceleration;
          // alert(a);          
          if(a.z >= 25 || a.z <= -25){    
          //$('#submitBtn').trigger('click');        
            // alert('test');
            shouldWriteData = false; 
            data_device['tracker'] = false;              
            if(data.name != '' && counter==0){                           
              addNote();                                          
              let some_data = {
              'alpha':data_device.alpha,
              'beta':data_device.beta,
              'gama':data_device.gamma,
              'tracker':false
                  };   
              socket.emit(<?php echo $_GET['id'];?>,some_data);
                window.location.reload();
              // $.post('write_current_data.php', data_device)
              // .done(() => {                                          
              //   console.log('Orientation data written successfully.');
              //   window.location.reload();
              // })
              // .fail((error) => {
              //   console.error('Error writing orientation data:', error);
              // });
              
              counter++;
            }
          }          
        }
      };      
      window.addEventListener("devicemotion", mouseListener, false);    
    })(window, document);

function ValidateEmail(mail) {
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(mail.match(mailformat))
  {      
    return true;
  }
  else
  {
    return false;
  }  
}




function phonenumber(inputtxt){
  var phoneno = /^\d+$/;
  if(inputtxt.match(phoneno)){
      return true;
  }
  else
    {
    // alert("message");
    return false;
    }
}


function submitForm(event) {
  event.preventDefault();
  const name = nameInput.value;
  const email = emailInput.value;
  const mobile = mobileInput.value;
  var empId = emp_id_input.value;
  var message = messageInput.value;
  var slingShotId = slingShot_Id.value;
  // var email = emailInput.value;
  // var mobile = mobileInput.value;
  const photo = imageInput.value; 
  if(name != ''){    
    showScreen3(name, email, empId, mobile , message, photo,slingShotId);
    data = {
      name: name,      
      email:email,
      empId:empId,
      mobile:mobile,
      message:message,
      photoPath: photo,
      slingShotId : slingShotId
    };  
  // addNote();  
  }
  else{
    $('#custom-form').append('<p style="color:red;">Please Fill the Name Field.</p>');
  }

}



// Show the success message in the third screen
function showScreen3(name, email, empId,mobile, message, photo,slingShotId) {
  screen2.style.display = 'none';
  screen3.style.display = 'block';

   data = {
      name: name,      
      email:email,
      mobile:mobile,
      empId:empId,
      message:message,
      photoPath: photo,
      slingShotId:slingShotId
    };  
    
  // addNote();      
  if (window.DeviceOrientationEvent) {    
    startOrientationTracking();    
  } else {
    console.log('Device orientation not supported.');
  }
}

  var data_device;
  

    function startOrientationTracking() {
      window.addEventListener('deviceorientationabsolute', handleOrientation);
    }

     function handleOrientation(event) {  
    tracker = true;     
      const { alpha, beta, gamma } = event;
      const orientationData = {
        alpha,
        beta,
        gamma,
        'tracker':tracker
      };
      data_device = {
        alpha,
        beta,
        gamma,
        'tracker':tracker
      };
      if(lock){
        shouldWriteData = false;
      }
      // Send the orientation data to the PHP script using jQuery AJAX
      else{
         if (shouldWriteData) {
          let some_data = {
              'alpha':alpha,
        'beta':beta,
        'gama':gamma,
        'tracker':tracker
            };   
          socket.emit(<?php echo $_GET['id'];?>,some_data);
          // $.post('writeData.php', orientationData)
          //   .done(() => {
          //     console.log('Orientation data written successfully.');
          //   })
          //   .fail((error) => {
          //     console.error('Error writing orientation data:', error);
          //   });
          
                     
            // ws.send(JSON.stringify(some_data));          
        } else {
          console.log('Data writing is currently stopped due to conditions.');
        }
      }
    }

// Event listeners
captureBtn.addEventListener('click', capturePhoto);
submitBtn.addEventListener('click', submitForm);

function addNote(){
  // $('#uploadNoteBtn').attr('disabled','disabled');  
  $('#custom-form').append('<p style="color:darkgreen;font-weight:900;">Thank you for sharing the vibe!</p>')
  $('#custom-form').append('');
  // Make the AJAX request
  $.ajax({
    url: 'save_note.php',
    type: 'POST',
    data: data,
    dataType: 'json',
    success: function(response) {
      // Handle the response from the server      
      if (response.success) {
        // Note saved successfully
        // $('#success-msg').show();
        // $('#screen3').append('<h2>Thank you for submitting Feed Back. Check the Wall.</h2>');        
        // Redirect to the first screen or perform any other desired action        
        
      } else {
        // Error saving the note
        console.error('Error saving note:', response.error);
      }
    }    
  });
  $('#success-msg').show();
}

// Start with the first screen
showScreen1();
</script>
</body>
</html>