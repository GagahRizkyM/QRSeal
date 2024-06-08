@extends('layouts.user.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="text-center">
                <h1> Preview </h1>
            </div>
            <div class="col-md-8" id="pdfPreview">
                <object class="pdf" data=
              "{{ asset('storage/' . $file) }}" width="800" height="500">
                </object>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $qr_code) }}" id="qrCode" alt="QR code" style="width: 100%;"
                    draggable="true">
                <button class="btn btn-primary" id="saveQRCode" style="background-color: #40A2D8;" type="submit">Proses</button>
            </div>
        </div>
    </div>



    <script type="module">
        import 'https://cdn.interactjs.io/v1.9.20/auto-start/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/actions/drag/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/actions/resize/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/modifiers/index.js'
        import 'https://cdn.interactjs.io/v1.9.20/dev-tools/index.js'
        import interact from 'https://cdn.interactjs.io/v1.9.20/interactjs/index.js'


        interact('#qrCode')
            .draggable({
                onmove: dragMoveListener,
            });

        interact('#pdfPreview')
            .dropzone({
                accept: '#qrCode',
                ondrop: function(event) {
                    var clone = event.relatedTarget.cloneNode(true);
                    clone.removeAttribute("id");
                    clone.removeAttribute("draggable");
                    event.currentTarget.appendChild(clone);
                }
            });

        document.getElementById('saveQRCode').addEventListener('click', function() {
            var qrCode = document.getElementById('qrCode');
            var pdfPreview = document.getElementById('pdfPreview');

            if (qrCode && pdfPreview) {
                var clone = qrCode.cloneNode(true);
                clone.removeAttribute("id");
                clone.removeAttribute("draggable");
                pdfPreview.appendChild(clone);
            }
        });

        function dragMoveListener(event) {
            var target = event.target,
                // keep the dragged position in the data-x/data-y attributes
                x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            // translate the element
            target.style.webkitTransform =
                target.style.transform =
                'translate(' + x + 'px, ' + y + 'px)';

            // update the posiion attributes
            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);
        }

        // this is used later in the resizing and gesture demos
        window.dragMoveListener = dragMoveListener;
    </script>
@endsection
