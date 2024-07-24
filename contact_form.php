<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar datos
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    if ($name && $email && $subject && $message) {
        // Crear un array con los datos
        $newMessage = array(
            "name" => $name,
            "email" => $email,
            "subject" => $subject,
            "message" => $message,
            "date" => date("Y-m-d H:i:s")
        );

        $jsonFile = 'messages.json';
        
        // Leer el contenido del archivo JSON
        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            $messages = json_decode($jsonData, true);
        } else {
            $messages = array();
        }

        // Añadir el nuevo mensaje
        $messages[] = $newMessage;

        // Guardar los datos en el archivo JSON
        if (file_put_contents($jsonFile, json_encode($messages, JSON_PRETTY_PRINT))) {
            echo "<script>alert('Mensaje enviado y almacenado exitosamente');</script>";
        } else {
            echo "<script>alert('Error al almacenar el mensaje');</script>";
        }
    } else {
        echo "<script>alert('Datos inválidos');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://jdan.github.io/98.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #008080;
        }
        .window {
            width: 350px;
        }
        .window-body {
            padding: 10px;
        }
        form p {
            margin: 10px 0;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            box-sizing: border-box;
        }
        button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="window">
        <div class="title-bar">
            <div class="title-bar-text">Contact Form</div>
        </div>
        <div class="window-body">
            <form method="POST" action="">
                <p>Name: <input type="text" name="name" required></p>
                <p>Email: <input type="email" name="email" required></p>
                <p>Subject: <input type="text" name="subject" required></p>
                <p>Message: <textarea name="message" rows="4" required></textarea></p>
                <p><button type="submit">Send</button></p>
            </form>
        </div>
    </div>
</body>
</html>
