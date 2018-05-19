@extends('layouts.app'); 

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <h2 class="text-center">{{$video->title}}</h2>
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <video controls id="video-player" class="img-responsive">
                <source src="{{ route('fileVideo', ['filename' => $video->video_path])}}"></source>
                Tu navegador no es compatible con HTML5
            </video>
            <div class="panel panel-default video-data">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a href="{{ route('channelUser', ['user_id' => $video->user_id ]) }}" class="canal-usuario">{{$video->user->name}}</a>
                        <p><strong>{{ FormatTime::LongTimeFilter($video->created_at)}}</strong></p>
                    </div>
                </div>
                <div class="panel-body">
                    {{$video->description}}
                </div>
            </div>
            <!-- comentarios -->
            @include('video.comments')
        </div>
    </div>
@endsection 