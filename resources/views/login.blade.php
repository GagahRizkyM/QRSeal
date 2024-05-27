<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  {{-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
  <style>
    .bg-blue{
      background-color: #40A2D8;
    }
  </style>
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-3/assets/css/login-3.css">
</head>
  <body>


<!-- Login 3 - Bootstrap Brain Component -->
<section class="p-3 p-md-4 p-xl-5">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 bg-blue">
        <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
           <img src="{{ asset('/img/QRSeal2.png')}}" class="rounded mx-auto mb-5 d-block" alt="...">
           <img src="{{ asset('/img/login.png')}}" class="rounded mx-auto d-block" alt="...">
        </div>
      </div>
      <div class="col-12 col-md-6 bsb-tpl-bg-lotion">
        <div class="p-3 p-md-4 mt-5 p-xl-5">
          <div class="row">
            <div class="col-12">
              <div class="mb-5">
                <h3>Login</h3>
                <p>Selamat datang! Silahkan masuk ke akun anda.</p>
              </div>
            </div>
          </div>

          <form action="{{route('auth')}}" method="post">
            @csrf
            <div class="row gy-3 gy-md-4 overflow-hidden">
              <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" id="password" value="" required>
                <p class="text-end"><a href="#">Lupa Password?</a></p>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn bsb-btn-xl btn-primary" >Login</button>
                  <p class="text-center">Belum punya akun?<a href="{{route('register')}}">Register</a></p>
                </div>
              </div>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>
</section>


     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
