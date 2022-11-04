@extends('adminlte::page')

@section('title','Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{__('Dashboard')}}</div>

                    <div class="card-body">
                        @if($user->roles_id == 1)
                            Anda login sebagai admin
                        @else
                            Anda login sebagai user
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!')</script>
@stop