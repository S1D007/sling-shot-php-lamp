<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note to Image</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .note {
            position: absolute;
            padding: 10px;
            border: 1px solid #ccc;
            background-size: cover;
        }

        .note-header {
            display: flex;
            align-items: center;
        }

        .note-message {
            margin-left: 10px;
        }

        .note img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <div id="noteContainer">
        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sling_shot";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the database
        $sql = "SELECT * FROM notes";
        $result = $conn->query($sql);

        // Generate notes from fetched data
        while ($row = $result->fetch_assoc()) {
            $noteHTML = '<div class="note" style="background:url(\'./assets/img/' . $row["img_id"] . '.svg\');">' .
                '<div class="note-image"></div>' .
                '<div class="note-header" style="margin-top:' . $row["margin_top"] . ';margin-left:' . $row["margin_left"] . ';"><img src="' . $row["photo"] . '">' .
                '<div class="note-message"><p>' . $row["name"] . '</p><span>' . $row["message"] . '</span></div></div>' .
                '</div>';
            
            echo $noteHTML;
        }

        $conn->close();
        ?>

    </div>
    <script>
        
    </script>
    
</body>
</html>
