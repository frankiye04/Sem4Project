let generatedTimestamp = null;
        
// Detect device type
function detectDevice() {
    const userAgent = navigator.userAgent;
    if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Windows Phone|Opera Mini/i.test(userAgent)) {
        document.documentElement.classList.add('mobile-device');
    } else if (/Tablet|iPad|iP(hone|od)|Android|BlackBerry|IEMobile|Windows Phone|Opera Mini/i.test(userAgent)) {
        document.documentElement.classList.add('tablet-device');
    } else {
        document.documentElement.classList.add('desktop-device');
    }
}
        
// Update time
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();
    const dateString = now.toLocaleDateString();
    document.getElementById("current-time").textContent = `Time: ${timeString}`;
    document.getElementById("current-date").textContent = `Date: ${dateString}`;
}
        
// Initialize
function init() {
    setInterval(updateTime, 1000);
    updateTime();
    detectDevice();
            
    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
        document.querySelector('.toggle-dark-mode i').className = 'fas fa-sun';
    }
}
        
// Toggle dark mode
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
    const isEnabled = document.body.classList.contains("dark-mode");
    localStorage.setItem('darkMode', isEnabled ? 'enabled' : 'disabled');
            
    const icon = document.querySelector('.toggle-dark-mode i');
    if (isEnabled) {
        icon.className = 'fas fa-sun';
    } else {
        icon.className = 'fas fa-moon';
    }
}
        
// Generate QR code
function generateQR() {
    const text = document.getElementById("text").value.trim();
    const qrContainer = document.getElementById("qrcode");
    const downloadBtn = document.getElementById("download-btn");
    const timestampBox = document.getElementById("qr-timestamp");
    const qrcodeContainer = document.getElementById("qrcode-container");
            
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
            
    timestampBox.innerHTML = `Generated at: ${dateString} ${timeString}`;
    qrcodeContainer.style.display = "flex";
            
    setTimeout(() => {
        const qrCanvas = qrContainer.querySelector("canvas");
        if (qrCanvas) {
            downloadBtn.style.display = "block";
        }
    }, 500);
}
        
// Download QR code
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
        
// Initialize on load
window.onload = init;