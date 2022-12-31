@extends('adminlte::page')

@section('title', 'Home Page')

@section('content_header')
    <h1>Data Buku</h1>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            @if($user->roles_id == 1)
                <div class="card-header">{{ __('Pengelolaan Buku')}}</div>
            @else
                <div class="card-header">{{ __('Data Buku')}}</div>
            @endif
            <div class="card-body">
                 @if($user->roles_id == 1)
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahBukuModal"><i class="fa fa-plus"></i>Tambah Data</button>
                <a href="{{ route('admin.print.books')}}" class="btn btn-secondary" target="_blank"><i class="fa fa-print"></i>Cetak PDF</a>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('admin.book.export')}}" class="btn btn-info" targe="_blank">Export</a>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#importDataModal">Import</button>
                </div>
                <hr>
                @endif
                <table id="table-data" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>JUDUL</th>
                            <th>PENULIS</th>
                            <th>TAHUN</th>
                            <th>PENERBIT</th>
                            <th>COVER</th>
                            @if($user->roles_id == 1)
                            <th>AKSI</th>
                            @endif
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
                                    <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px" class="mx-auto d-block"/>
                                    @else
                                        [Gambar tidak tersedia]
                                    @endif
                                </td>
                                @if($user->roles_id == 1)
                                <td>
                                    <div class="btn-group mx-auto d-block" role="group" aria-label="Basic example">
                                        <button type="button" id="btn-edit-buku" class="btn btn-success" data-toggle="modal" data-target="#editBukuModal" data-id="{{ $book->id }}">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteConfirmation('{{$book->id}}', '{{$book->judul}}')">Hapus</button>
                                    </div>
                                </td>
                                @endif  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Tambah Data Buku
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.book.submit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="judul">Judul Buku</label>
                                <input type="text" name="judul" id="judul" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Penulis</label>
                                <input type="text" name="penulis" id="penulis" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="text" name="tahun" id="tahun" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" name="penerbit" id="penerbit" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label for="cover">Cover</label>
                                <input type="file" name="cover" id="cover" class="form-control" required/>
                                {!!$errors->first('image', '<span class="text-danger">:message</span>')!!}
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Buku -->
    <div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit Data Buku
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.book.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label for="edit-judul">Judul Buku</label>
                                        <input type="text" name="judul" id="edit-judul" class="form-control" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-penulis">Penulis</label>
                                        <input type="text" name="penulis" id="edit-penulis" class="form-control" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-tahun">Tahun</label>
                                        <input type="text" name="tahun" id="edit-tahun" class="form-control" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-penerbit">Penerbit</label>
                                        <input type="text" name="penerbit" id="edit-penerbit" class="form-control" required/>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group" id="image-area"></div>
                                <div class="form-group">
                                    <label for="edit-cover">Cover</label>
                                    <input type="file" name="cover" id="edit-cover" class="form-control" required/>
                                    {!!$errors->first('cover', '<span class="text-danger">:message</span>')!!}
                                </div>
                            </div>
                        </div>                        
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="edit-id">
                            <input type="hidden" name="old_cover" id="edit-old-cover">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Data Buku -->
    <div class="modal fade" id="importDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Import Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.book.import')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="cover">Upload File</label>
                            <input type="file" name="file" class="form-control"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Import Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@yield('adminlte_js')

@section('js')
<script>
        //Modal Edit
        $(function(){
            $(document).on('click','#btn-edit-buku', function(){
                let id = $(this).data('id');
                $('#image-area').empty();
                $.ajax({
                    type: "get",
                    url: "{{url('/admin/ajaxadmin/dataBuku')}}/"+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-judul').val(res.judul);
                        $('#edit-penerbit').val(res.penerbit);
                        $('#edit-penulis').val(res.penulis);
                        $('#edit-tahun').val(res.tahun);
                        $('#edit-id').val(res.id);
                        $('#edit-old-cover').val(res.cover);
                        if(res.cover !== null){
                            $('#image-area').append(
                                "<img src='"+baseurl+"/storage/cover_buku/"+res.cover+"' width='200px'>"
                            );
                        }else{
                            $('#image-area').append('[Gambar tidak tersedia]');
                        }
                    },
                });
            });
        });

    //Delete
    function deleteConfirmation(id, judul){
        Swal.fire({
            title: "Hapus?",
            icon: 'warning',
            text: "Apakah anda yakin akan menghapus data buku dengan judul " + judul +" ?!",
            showCancelButton: !0,
            confirmButtonText: "Ya, Lakukan!",
            cancelButtonText: "Tidak, batalkan!", 
            reverseButtons: !0
        }).then(function (e){
            if(e.value === true){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "books/delete/" + id,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'json',
                    success: function(results){
                        if(results.success===true){
                            swal.fire("Done!", results.message, "success");
                            setTimeout(function(){
                                location.reload();
                            },1000);
                        }else{
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            }else{
                e.dismiss;
            }
        }, function(dismiss){
            return false;
        })
    }
</script>
@endsection