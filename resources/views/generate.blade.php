@extends('layouts.user.default')
@section('content')
    <style>
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            min-height: 150px;
            padding: 54px 54px;
            vertical-align: middle;
            text-align: center;
            margin: 20px;
            cursor: pointer;
        }

        .dropzone.dragover {
            background: #f0f0f0;
        }

        .dropzone p {
            margin: 0;
            font-size: 1.2em;
        }
    </style>

    <div class="text-center py-5">
        <h1>Generate QR-CODE & Validasi </h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-body dropzone" id="dropzone">
                        <h2><i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 5rem"></i></h2>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary">Pilih File</button>
                        </div>
                        <div id="file_name">
                            <p class="fs-6 py-2">Support PDF</p>
                            <p class="fs-6">Ukuran Maksimal : 100 MB</p>
                        </div>
                        <input type="file" id="fileInput" style="display:none" accept=".pdf">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row ">
            <form id="certificateForm" method="POST" action="{{ route('process_certificate') }}"
                enctype="multipart/form-data">
                <div class="col-xl-12">
                    <div class="card mb-4" style="border-radius: 10px;">
                        <div class="card-header" style="background-color: #40A2D8; border-radius: 10px">
                            <p class="text-start" style="color: white">INPUT INFORMASI SERTIFIKAT</p>
                        </div>
                        <div class="card-body">
                            <p class="text-start">Berikan Info Sertifikat Anda</p>
                            @csrf

                            <div class="row mb-3">
                                <label for="serficate_number" class="col-md-2 col-form-label">No. Sertifikat</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="serficate_number" id="serficate_number"
                                        placeholder="13/X/2024">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-2 col-form-label">Nama Peserta</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Gagah Perkasa" title="Masukkan Nama Lengkap">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jenis_pelatian" class="col-md-2 col-form-label">Jenis Pelatihan</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="jenis_pelatian" id="jenis_pelatian"
                                        placeholder="Pelatihan cocok tanam">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_terbit" class="col-md-2 col-form-label">Tanggal Terbit</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control datepicker" name="date_terbit"
                                        id="date_terbit">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name_penandatangan" class="col-md-2 col-form-label">Penandatangan</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name_penandatangan"
                                        id="name_penandatangan" placeholder="" title="Nama yang Menandatangani">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="digital_code" class="form-label">Tanda Tangan Digital</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control disabled" name="digital_code"
                                            id="digital_code" placeholder="Kode otomatis generate" readonly value="">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-primary" onclick="generateRandom()">Tanda
                                                Tangan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="form-group">
                                <label for="signatureCanvas">Tanda Tangan</label>
                                <canvas id="signatureCanvas" name="signatureCanvas" width="600" height="200"
                                    style="border: 1px solid #40A2D8; border-radius: 5px;"></canvas>
                                <input type="hidden" id="signature" name="signature">
                            </div> --}}
                            {{-- <div class="form-group" style="margin-bottom: 20px;">
                  <label for="uploadFile">Upload File</label>
                  <input type="file" id="uploadFile" name="inputImage" style="border-radius: 5px; border: 1px solid #40A2D8;">
                </div> --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-5">
                        <button class="btn btn-primary" style="background-color: #40A2D8;" type="submit">Generate
                            QR-CODE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap5'
            });
        })
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const file_name = document.getElementById('file_name')

        dropzone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            console.log(event.target.files);
            if (event.target.files[0].type !== 'application/pdf') {
                alert('FILE HARUS PDF BRO')
            } else {
                file_name.innerHTML = `
              <p class="fs-6 py-2">Nama File: ${event.target.files[0].name}</p>
              <p class="fs-6">Ukuran Maksimal : ${(event.target.files[0].size / (1024*1024)).toFixed(2)} MB</p>
              `;
            }
            // handleFiles(event.target.files);
        });

        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('dragover');

            if (event.dataTransfer.files[0].type !== 'application/pdf') {
                window.alert('FILE HARUS PDF BRO')
            } else {
                file_name.innerHTML = `
              <p class="fs-6 py-2">Nama File: ${event.dataTransfer.files[0].name}</p>
              <p class="fs-6">Ukuran Maksimal : ${(event.dataTransfer.files[0].size / (1024*1024)).toFixed(2)} MB</p>
              `;
            }
            console.log(event.dataTransfer.files);
            // handleFiles(event.dataTransfer.files);
        });

        function handleFiles(files) {
            const formData = new FormData();
            for (const file of files) {
                formData.append('file[]', file);
            }

            fetch('{{ route('store.generate.qr') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error(error);
                });
        }

        async function generateRandom() {
            // let result = '';
            // const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            // const charactersLength = characters.length;
            // let counter = 0;
            // while (counter < 100) {
            //     result += characters.charAt(Math.floor(Math.random() * charactersLength));
            //     counter += 1;
            // }

            const serficate_number = document.getElementById('serficate_number').value;
            const name = document.getElementById('name').value;
            const jenis_pelatian = document.getElementById('jenis_pelatian').value;
            const date_terbit = document.getElementById('date_terbit').value;
            const name_penandatangan = document.getElementById('name_penandatangan').value;
            let data = {
                data: `${serficate_number}|${name}|${jenis_pelatian}|${date_terbit}|${name_penandatangan}`,
            }
            console.log(data);
            const baseUrl = "{{ url('/') }}"

            const response = await fetch(`${baseUrl}/api/encrypt`, {
                method: "POST", // or 'PUT'
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
            const result = await response.json();
            console.log(result);

            const responseDecryp = await fetch(`${baseUrl}/api/decrypt`, {
                method: "POST", // or 'PUT'
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({data1: result.encrypted, data2: result.encryptedRsa}),
            })
            const decryp = await responseDecryp.json();
            console.log(decryp);

            const digital_code = document.getElementById('digital_code');
            digital_code.value = result.encrypted;
        }
    </script>
@endsection
