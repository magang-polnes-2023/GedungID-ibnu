<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Gedung</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="mt-3">
                            <h5>Data Gedung:</h5>
                            @foreach ($gedungs as $gedung)
                                <ul>
                                    <img src="{{ asset('storage/' . $gedung->foto) }}" class="w-100 rounded">
                                    <li><strong>Nama Gedung:</strong> {{ $gedung->nama }}</li>
                                    <li><strong>Lokasi:</strong> {{ $gedung->lokasi }}</li>
                                    <li><strong>Fasilitas:</strong> {{ $gedung->fasilitas_id }}</li>
                                    <li><strong>Deskripsi:</strong> {{ $gedung->deskripsi }}</li>
                                    <li><strong>Harga:</strong> {{ $gedung->harga }}</li>
                                    <li><strong>Ketersediaan:</strong> {{ $gedung->ketersediaan }}</li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
