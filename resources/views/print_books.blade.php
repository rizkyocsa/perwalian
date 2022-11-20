<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <title>Document</title> -->
</head>
<body>
    <h1 class="text-center">Data Buku</h1>
    <p class="text-center">Laporan Data Buku Tahun 2022</p>
    <br>
    <table id="table-data" class="table table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>JUDUL</th>
                <th>PENULIS</th>
                <th>TAHUN</th>
                <th>PENERBIT</th>
                <th>COVER</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach ($books as $book)
                <tr>
                    <td>{{ $no++}}</td>
                    <td>{{ $book->judul}}</td>
                    <td>{{ $book->penulis}}</td>
                    <td>{{ $book->tahun}}</td>
                    <td>{{ $book->penerbit}}</td>
                    <td>
                        @if($book->cover !== null)
                        <img src="{{ public_path('storage/cover_buku/'.$book->cover) }}" width="80px" class="mx-auto d-block"/>
                        @else
                            [Gambar tidak tersedia]
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>