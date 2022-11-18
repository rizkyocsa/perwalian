@extends('adminlte::page')

@section('title', 'Home Page')

@section('content_header')
    <h1>Data Buku</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Buku')}}</div>
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-targer="#tambahBukuModal"><i class="fa fa-plus"></i>Tambah Data</button>
                <table id="table-data" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>JUDUL</th>
                            <th>PENULIS</th>
                            <th>TAHUN</th>
                            <th>PENERBIT</th>
                            <th>COVER</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach($books as $book)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$book->judul}}</td>
                                <td>{{$book->penulis}}</td>
                                <td>{{$book->tahun}}</td>
                                <td>{{$book->penerbit}}</td>
                                <td>
                                    @if($book->cover !== null)
                                    <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px"/>
                                    @else
                                        [Gambar tidak tersedia]
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection