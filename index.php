<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            flex-direction: column;
            transition: background 0.5s ease-in-out, color 0.5s ease-in-out;
        }

        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
            width: 280px;
        }

        .container:hover {
            transform: scale(1.05);
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            width: 80%;
            text-align: center;
            transition: box-shadow 0.3s ease-in-out;
        }

        input:hover {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(90deg, #ff9800, #ff5722);
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.3s ease, background 0.3s ease;
            outline: none;
        }

        button:hover {
            background: linear-gradient(90deg, #ff6a00, #e65100);
            transform: scale(1.08);
        }

        #qrcode {
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }

        .dark-mode {
            background: #1e1e1e !important;
        }

        .dark-mode .container {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }

        .toggle-dark-mode {
            position: absolute;
            top: 10px;
            right: 10px;
            background: black;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .toggle-dark-mode:hover {
            transform: scale(1.1) rotate(360deg);
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .time-box {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            transition: background 0.3s ease;
        }

        .time-box .date,
        .time-box .clock {
            margin: 5px 0;
            color: #f5f5f5;
            text-shadow: 0 0 3px rgba(0,0,0,0.6);
        }

        .clock {
            font-size: 18px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-3px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <button class="toggle-dark-mode" onclick="toggleDarkMode()">🌙</button>
    <div class="container">
        <h1>QR Code Generator</h1>
        <input type="text" id="text" placeholder="Enter text here...">
        <div class="time-box">
            <div class="date">📅 <?php echo date("l, F j, Y"); ?></div>
            <div class="clock" id="currentTime">🕒 Loading time...</div>
        </div>
        <button onclick="generateQR()">Generate QR</button>
        <div id="qrcode"></div>
        <div id="qr-timestamp" style="margin-top: 8px; font-size: 13px; opacity: 0.8;"></div>
        <div class="button-container">
            <button id="download-btn" onclick="downloadQR()" style="display: none;">Download QR</button>
        </div>
    </div>

    <script src="qrcode.min.js"></script>
    <script>
        let generatedTimestamp = null;

        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById("currentTime").textContent = "🕒 Time: " + timeString;
        }

        setInterval(updateTime, 1000);
        updateTime();

        function toggleDarkMode() {
            document.body.classList.toggle("dark-mode");
            const btn = document.querySelector(".toggle-dark-mode");
            btn.innerHTML = document.body.classList.contains("dark-mode") ? "☀️" : "🌙";
        }

        function generateQR() {
            const text = document.getElementById("text").value.trim();
            const qrContainer = document.getElementById("qrcode");
            const downloadBtn = document.getElementById("download-btn");
            const timestampBox = document.getElementById("qr-timestamp");

            qrContainer.innerHTML = "";
            timestampBox.innerHTML = "";
            downloadBtn.style.display = "none";

            if (text === "") {
                alert("Please enter text to generate a QR code.");
                return;
            }

            const now = new Date();
            const timeString = now.toLocaleTimeString();
            const dateString = now.toLocaleDateString();
            generatedTimestamp = now.toISOString().replace(/[:T]/g, "-").split(".")[0];

            new QRCode(qrContainer, {
                text: text,
                width: 250,
                height: 250,
                colorDark: "#000",
                colorLight: "#fff"
            });

            timestampBox.innerHTML = `🕒 Generated at: ${dateString} ${timeString}`;

            setTimeout(() => {
                const qrCanvas = qrContainer.querySelector("canvas");
                if (qrCanvas) {
                    downloadBtn.style.display = "block";
                }
            }, 500);
        }

        function downloadQR() {
            const qrCanvas = document.querySelector("#qrcode canvas");
            if (!qrCanvas) {
                alert("Please generate a QR code first.");
                return;
            }

            if (!generatedTimestamp) {
                alert("Timestamp missing. Please generate the QR again.");
                return;
            }

            const filename = `QR_${generatedTimestamp}.png`;
            const link = document.createElement("a");
            link.href = qrCanvas.toDataURL("image/png");
            link.download = filename;
            link.click();
        }
    </script>
</body>
</html>
