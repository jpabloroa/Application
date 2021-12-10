<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <title>Inicia sesión</title>
</head>

<body>
    <?php
    echo "primero que nada, primero que todo";
    ?>
    <h1>Página de inicio</h1>
    <div id="reader" style="width:200px;height:auto;"></div>
    <input type="file" id="qr-input-file" accept="image/*">
    <!--<input type="file" id="qr-input-file" accept="image/*" capture>-->
    <script>
        const html5QrCode = new Html5Qrcode( /* element id */ "reader");
        // File based scanning
        console.log("Activado !");
        const fileinput = document.getElementById('qr-input-file');
        fileinput.addEventListener('change', e => {
            console.log("Archivo cargado !");
            if (e.target.files.length == 0) {
                // No file selected, ignore
                alert("No hay archivos");
                return;
            }

            const imageFile = e.target.files[0];
            // Scan QR Code
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    // success, use decodedText
                    alert("Escaneado ! Resultado:" + decodedText);
                })
                .catch(err => {
                    // failure, handle it.
                    alert("Error de escaneo");
                    console.log(`Error scanning file. Reason: ${err}`)
                });
        });
    </script>
</body>

</html>