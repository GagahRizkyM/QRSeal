@extends('layouts.user.default')
@section('content')

<div class="text-center">
    <h1> Preview </h1>    
    <img src="{{asset('storage/' .$qr_code)}}" alt="QR code">
    
    <iframe src="{{ asset('storage/'.$file) }}"  frameBorder="0"
    scrolling="auto"
    height="100%"
    width="100%"></iframe>
    {{-- <object class="pdf" 
            data=
"{{ asset('storage/'.$file) }}"
            width="800"
            height="500">
    </object> --}}
     <button class="btn btn-primary" style="background-color: #40A2D8;" type="submit">Proses</button>
  </div>




@stop
