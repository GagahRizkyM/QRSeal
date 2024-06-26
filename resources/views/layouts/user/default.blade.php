<!doctype html>
<html lang="en">

<head>


    @include('layouts.user.head')

</head>

<body>


    @include('layouts.user.header')


    @yield('content')






    <script>
        // Function to clear the signature canvas
        function clearSignature() {
            var canvas = document.getElementById('signatureCanvas');
            var context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
        }
    </script>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
      document.addEventListener("DOMContentLoaded", function() {
            @if (session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{session('error')}}",
                    icon: "error"
                });
            @endif
            @if (session('success'))
                Swal.fire({
                    title: "Sukses!",
                    text: "{{session('success')}}",
                    icon: "success"
                });
            @endif

        });
     </script>
</body>

</html>
