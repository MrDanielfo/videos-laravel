@extends('layouts.app'); 

@section('content')

<div class="container">
    <div class="row">
        <h2 class="text-center">Crear un nuevo video</h2>
        <form action="{{ route('saveVideo') }}" method="post" enctype="multipart/form-data" class="col-lg-8 col-lg-offset-2">
            {!! csrf_field() !!}

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Imagen</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <div class="form-group">
                <label for="video">Video</label>
                <input type="file" class="form-control" id="video" name="video">
            </div>

            <button type="submit" class="btn btn-success">Crear Video</button>
        </form>
    </div>   
</div>

@endsection 