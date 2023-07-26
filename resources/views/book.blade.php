@extends('adminlte::page')

@section('title', 'Siswa Page')

@section('content_header')
    <h1>Data Siswa</h1>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
                <div class="card-header">{{ __('Pengelolaan Siswa')}}</div>
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahSiswaModal"><i class="fa fa-plus"></i>Tambah Data</button>                
                <hr>
                <table id="table-data" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <!-- <th>NIK</th> -->
                            <th>NAMA</th>
                            <th>EMAIL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach($user as $data)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->email}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="btn-edit-buku" class="btn btn-success" data-toggle="modal" data-target="#editBukuModal" data-id="{{ $data->id }}">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteConfirmation('{{$data->id}}','{{$data->name}}')">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form action="{{ route('admin.siswa.submit')}}" method="post" enctype="multipart/form-data">
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
        });
    }
</script>
@endsection