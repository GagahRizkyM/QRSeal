@extends('layouts.user.default')
@section('content')


    <div class="container">
        <div class="row">
            <div class="text-center">
                <h1> Preview </h1>
            </div>
            <div class="col-md-8">
              <object class="pdf" data=
              "{{ asset('storage/' . $file) }}" width="800" height="500">
                      </object>
            </div>
            <div class="col-md-4">
              <img src="{{ asset('storage/' . $qr_code) }}" alt="QR code" style="width: 100%;">
              <button class="btn btn-primary" style="background-color: #40A2D8;" type="submit">Proses</button>
            </div>
        </div>
    </div>

@endsection
