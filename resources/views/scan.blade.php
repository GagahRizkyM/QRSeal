@extends('layouts.user.default')
@section('content')

<div class="text-center test">
    <h1>SCAN QRCODE</h1>
</div>
<div class="desktop-render-area">


    <div class="reader-container" style="position: relative; height: 50% !important; weight:50% !important">


        <div id="reader" style="height: 100%, width: 100%"></div>
        <div class="mt-8 bg=white dark=bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2"></div>
        </div>
    </div>
</div>





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
