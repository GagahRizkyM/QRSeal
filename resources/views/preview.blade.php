@extends('layouts.user.default')

@section('content')
    <div class="container-fluid" style="height: 100vh;">
        <div class="row h-100">
            <!-- PDF Preview Section -->
            <div class="col-md-8 d-flex align-items-center justify-content-center position-relative" id="pdfPreview" style="border-right: 1px solid #ccc;">
                <embed src="{{ asset('storage/' . $file) }}" type="application/pdf" style="width: 100%; height: 100%; border: none;" />

                <!-- QR Code positioned absolutely within the preview area -->
                <img src="{{ asset('storage/' . $qr_code) }}" id="qrCode" alt="QR code" style="width: 10%; height: auto; position: absolute; top: 10px; left: 10px; display: none;">
            </div>

            <!-- QR Code and Download Section -->
            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('storage/' . $qr_code) }}" id="initialQrCode" alt="QR code" style="width: 100%; height: auto;" draggable="true">

                <!-- Download Button -->
                <button class="btn btn-primary mt-4" id="downloadPDF" style="background-color: #40A2D8;">
                    Download PDF with QR Code
                </button>

                <!-- Save QR Code Button -->
                <button class="btn btn-secondary mt-2" id="saveQRCode" type="button">Save QR Code to PDF</button>
            </div>
        </div>
    </div>

    <!-- Include the pdf-lib library -->
    <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script type="module">
        import 'https://cdn.interactjs.io/v1.9.20/auto-start/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/actions/drag/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/actions/resize/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/modifiers/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/dev-tools/index.js'
        import interact from 'https://cdn.interactjs.io/v1.9.20/interactjs/index.js'

        // Global variable to store QR code position
        let qrCodePosition = { x: 0, y: 0 };

        // Initial draggable QR code
        interact('#initialQrCode')
            .draggable({
                onstart: function(event) {
                    // Show and move QR code to preview area when drag starts
                    var initialQrCode = event.target;
                    var qrCodeInPreview = document.getElementById('qrCode');

                    // Position QR code in preview where the drag started
                    qrCodeInPreview.style.top = (event.pageY - initialQrCode.height / 2) + 'px';
                    qrCodeInPreview.style.left = (event.pageX - initialQrCode.width / 2) + 'px';
                    qrCodeInPreview.style.display = 'block';

                    // Save the position of the QR code
                    qrCodePosition.x = event.pageX - initialQrCode.width / 2;
                    qrCodePosition.y = event.pageY - initialQrCode.height / 2;

                    // Remove the initial QR code from its original place
                    initialQrCode.style.display = 'none';
                },
                onmove: dragMoveListener,
                onend: function(event) {
                    // Hide the initial QR code after dragging ends
                    event.target.style.display = 'none';
                }
            });

        // Make the QR code in the preview draggable as well
        interact('#qrCode')
            .draggable({
                onmove: dragMoveListener
            });

        // Function to update QR code position during drag
        function dragMoveListener(event) {
            var target = event.target,
                x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            // Update the position of the QR code
            target.style.webkitTransform =
                target.style.transform =
                'translate(' + x + 'px, ' + y + 'px)';

            // Save the new position for next drag move
            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);

            // Update the global QR code position
            qrCodePosition.x = event.pageX - target.width / 2;
            qrCodePosition.y = event.pageY - target.height / 2;
        }

        // Assign the dragMoveListener to the window for reuse
        window.dragMoveListener = dragMoveListener;

         // Download PDF button functionality
    document.getElementById('downloadPDF').addEventListener('click', async function () {
        // Get the QR code element and its position
        var qrCode = document.getElementById('qrCode');
        var pdfPreview = document.getElementById('pdfPreview');

        if (qrCode && pdfPreview) {
            // Get the position of the QR code
            var qrX = qrCodePosition.x;
            var qrY = qrCodePosition.y;

            // Calculate the position and size in the PDF (based on your layout and scaling)
            var pdfWidth = pdfPreview.clientWidth;
            var pdfHeight = pdfPreview.clientHeight;
            var qrWidth = qrCode.clientWidth;
            var qrHeight = qrCode.clientHeight;

            // Calculate the scale factor based on QR code dimensions in the PDF
            var scaleFactor = qrWidth / qrCode.naturalWidth;

            // Calculate the position of the QR code in the PDF
            var qrPosX = qrX / pdfWidth;
            var qrPosY = (pdfHeight - (qrY + qrHeight)) / pdfHeight;

            // Load the PDF and add the QR code
            const existingPdfBytes = await fetch("{{ asset('storage/' . $file) }}").then(res => res.arrayBuffer());
            const qrCodeImageBytes = await fetch(qrCode.src).then(res => res.arrayBuffer());

            const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes);
            const qrCodeImage = await pdfDoc.embedPng(qrCodeImageBytes);
            const pages = pdfDoc.getPages();
            const firstPage = pages[0];

            // Calculate the dimensions of the QR code in the PDF's coordinate system
            const qrCodePdfWidth = qrCode.naturalWidth * scaleFactor;
            const qrCodePdfHeight = qrCode.naturalHeight * scaleFactor;

            // Add the QR code to the PDF at the specified position
            firstPage.drawImage(qrCodeImage, {
                x: firstPage.getWidth() * qrPosX,
                y: firstPage.getHeight() * qrPosY,
                width: qrCodePdfWidth,
                height: qrCodePdfHeight,
            });

            // Serialize the PDF to bytes and download
            const pdfBytes = await pdfDoc.save();
            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const url = URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = 'downloaded-with-qr-code.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    });

        // Save QR Code to PDF preview
        document.getElementById('saveQRCode').addEventListener('click', function() {
            var qrCode = document.getElementById('qrCode');
            var pdfPreview = document.getElementById('pdfPreview');

            if (qrCode && pdfPreview) {
                qrCode.style.display = 'block';
            }
        });
    </script>
@endsection
