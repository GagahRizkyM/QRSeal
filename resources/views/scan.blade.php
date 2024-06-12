@extends('layouts.user.default')
@section('content')

{{-- <div class="text-center test">
    <h1>SCAN QRCODE</h1>
</div>
<div class="desktop-render-area">


    <div class="reader-container" style="position: relative; height: 50% !important; weight:50% !important">


        <div id="reader" style="height: 100%, width: 100%"></div>
        <div class="mt-8 bg=white dark=bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2"></div>
        </div>
    </div>
</div> --}}

<!-- Load Quagga.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<!-- Load PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

<input type="file" id="pdfInput" accept=".pdf" />
<button onclick="scanPDF()">Scan Barcode</button>

<script>
  // Tentukan workerSrc menggunakan worker dari CDN
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

  async function scanPDF() {
    const pdfInput = document.getElementById('pdfInput');
    const file = pdfInput.files[0];

    if (!file) {
      alert('Please select a PDF file.');
      return;
    }

    const pdfData = await readFileAsArrayBuffer(file);
    const pdfImages = await getPdfImages(pdfData);

    for (const imageData of pdfImages) {
      const result = await scanBarcode(imageData);
      console.log('Barcode scan result:', result); // Tambahkan ini untuk melihat hasil pemindaian barcode di konsol
      if (result && result.exists) {
        alert('Barcode valid.');
        return; // Hentikan pemindaian setelah barcode terdeteksi
      }
    }

    // Jika tidak ada barcode yang terdeteksi
    alert('No barcode found.');
  }

  function readFileAsArrayBuffer(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => resolve(reader.result);
      reader.onerror = error => reject(error);
      reader.readAsArrayBuffer(file);
    });
  }

  async function getPdfImages(pdfData) {
    const pdf = await pdfjsLib.getDocument({ data: pdfData }).promise;
    const images = [];
    for (let i = 1; i <= pdf.numPages; i++) {
      const page = await pdf.getPage(i);
      const viewport = page.getViewport({ scale: 1 });
      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;
      await page.render({ canvasContext: context, viewport: viewport }).promise;
      images.push(canvas.toDataURL('image/png'));
    }
    return images;
  }

  async function scanBarcode(imageData) {
    return new Promise((resolve, reject) => {
      Quagga.decodeSingle({
        src: imageData,
        numOfWorkers: 0,
        decoder: {
          readers: ['ean_reader']
        },
        locate: true,
        locateBarcodes: true,
        inputStream: {
          size: 800
        },
        locator: {
          patchSize: 'medium',
          halfSample: true
        },
        debug: false,
        settings: {}
      }, (result) => {
        if (result && result.codeResult) {
          const barcode = result.codeResult.code;
          console.log('Barcode detected:', barcode);
          resolve({ barcode: barcode, exists: true });
        } else {
          console.log('Barcode not found');
          resolve({ barcode: null, exists: false });
        }
      });
    });
  }
</script>








<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
function onScanSuccess(decodedText, decodedResult) {
  // handle the scanned code as you like, for example:
  console.log(`Code matched = ${decodedText}`, decodedResult);
}

let config = {
  fps: 120,
  qrbox: {width: 250, height: 250, aspectRatio: 1.0, disableFlip: true},
  rememberLastUsedCamera: true,
  // Only support camera scan type.
  supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
};

let html5QrcodeScanner = new Html5QrcodeScanner(
  "reader", config, /* verbose= */ false);
html5QrcodeScanner.render(onScanSuccess);
</script>
@stop
