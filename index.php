<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia sesión</title>
</head>

<body>
    <h1>Página de inicio</h1>
    <div id="reader" width="600px" height="600px"></div>
    <script src="./dist/html5-qrcode.js">
        const html5QrCode = new Html5Qrcode( /* element id */ "reader");
        // File based scanning
        const fileinput = document.getElementById('qr-input-file');
        fileinput.addEventListener('change', e => {
            if (e.target.files.length == 0) {
                // No file selected, ignore 
                return;
            }

            const imageFile = e.target.files[0];
            // Scan QR Code
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    // success, use decodedText
                    console.log(decodedText);
                })
                .catch(err => {
                    // failure, handle it.
                    console.log(`Error scanning file. Reason: ${err}`)
                });
        });

        // Note: Current public API `scanFile` only returns the decoded text. There is
        // another work in progress API (in beta) which returns a full decoded result of
        // type `QrcodeResult` (check interface in src/core.ts) which contains the
        // decoded text, code format, code bounds, etc.
        // Eventually, this beta API will be migrated to the public API.
    </script>
    <!--<input type="file" id="qr-input-file" accept="image/*">-->
    <input type="file" id="qr-input-file" accept="image/*" capture>
</body>

</html>