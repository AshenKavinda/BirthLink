

function domReady(fn) {
    if (
        document.readyState === "complete" ||
        document.readyState === "interactive"
    ) {
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

domReady(function () {

    // If QR code is found
    function onScanSuccess(decodeText, decodeResult) {
        alert(decodeText);
        // Redirect to the URL contained in the QR code
        window.location.href =  '../../interBaby/babyVaccine/babyVaccine.html?bid='+decodeText;
    }

    let htmlscanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 10, qrbox: 250 } // Fixed typo from "qrbos" to "qrbox"
    );
    htmlscanner.render(onScanSuccess);
});