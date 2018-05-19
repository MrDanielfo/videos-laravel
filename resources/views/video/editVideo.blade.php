@extends('layouts.app'); 

@section('content')

<div class="container">
    <div class="row">
        <h2 class="text-center">Editar video: {{$video->title}}</h2>
        <form action="{{route('videoUpdate', ['video_id' => $video->id])}}" method="post" enctype="multipart/form-data" class="col-lg-8 col-lg-offset-2">
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
                <input type="text" class="form-control" id="title" name="title" value="{{ $video->title }}">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" name="description" id="description">{{ $video->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Imagen</label>
                @if(Storage::disk('images')->has($video->image))
                    <div class="video-image-thumb">
                        <div class="video-image-mask">
                            <img src="{{ url('miniatura/'.$video->image) }}" alt="{{ $video->title }}" class="img-responsive video-image">
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <div class="form-group">
                <label for="video">Video</label>
                <video controls id="video-player" class="img-responsive">
                    <source src="{{ route('fileVideo', ['filename' => $video->video_path])}}"></source>
                    Tu navegador no es compatible con HTML5
                </video>
                <input type="file" class="form-control" id="video" name="video"> 
            </div>

            <button type="submit" class="btn btn-success">Editar Video</button>
        </form>
    </div>   
</div>

@endsection 