@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container"> 
            <h2 class="text-center col-md-12">Canal de: <strong>{{$user->name}}<strong></h2>
                
            @include('video.videosList')

        </div> 
    </div>
</div>
@endsection