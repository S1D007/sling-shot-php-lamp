<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert Div to Image</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>
    <div id="myDiv">
        <!-- Your div content here -->
        <h1>Hello World!</h1>
    </div>
    <button id="captureBtn">Capture and Save</button>
    <img id="capturedImage" src="" style="display: none;">
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('captureBtn').addEventListener('click', function() {
                const myDiv = document.getElementById('myDiv');
                
                if (!myDiv) {
                    console.error('Element with id "myDiv" not found');
                    return;
                }

                html2canvas(myDiv).then(canvas => {
                    // Convert the canvas to a data URL
                    let imgData = canvas.toDataURL('image/png');
                    
                    // Display the captured image
                    document.getElementById('capturedImage').src = imgData;
                    document.getElementById('capturedImage').style.display = 'block';
                    
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
                        console.log(data);
                        alert('Image saved successfully!');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
</body>
</html>
