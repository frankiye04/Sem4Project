<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <button class="toggle-dark-mode" onclick="toggleDarkMode()">
        <i class="fas fa-moon"></i>
    </button>
    <div class="container">
        <h1>QR Code Generator</h1>
        <div class="input-container">
            <input type="text" id="text" placeholder="Enter text here...">
        </div>
        <div class="time-box">
            <div class="date">
                <i class="far fa-calendar-alt"></i>
                <span id="current-date">Loading date...</span>
            </div>
            <div class="clock">
                <i class="far fa-clock"></i>
                <span id="current-time">Loading time...</span>
            </div>
        </div>
        <button class="generate-btn" onclick="generateQR()">Generate QR</button>
        <div id="qrcode-container">
            <div id="qrcode"></div>
            <div id="qr-timestamp"></div>
            <div class="button-container">
                <button id="download-btn" onclick="downloadQR()" style="display: none;">Download QR</button>
                <button id="share-btn" onclick="shareQR()" style="display: none; margin-top: 10px;">Share QR</button>
            </div>
        </div>
    </div>

    <script src="qrcode.min.js"></script>
    <script src="script.js"></script>
</body>
</html>