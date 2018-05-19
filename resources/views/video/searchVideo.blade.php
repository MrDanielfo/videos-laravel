@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <form action="{{url('search-video/'.$search )}}" class="col-md-3 col-md-offset-4 form-busqueda" method="GET">
                <label for="filter">Ordenar</label>
                <select name="filter" class="form-control">
                    <option value="new">Más nuevos primero</option>
                    <option value="old">Más antiguos primero</option>
                    <option value="alfa">De la A la Z</option>
                </select>
                <input type="submit" value="Ordenar" class="btn-filtrado btn btn-sm btn-primary">
            </form>  
            <h2 class="text-center col-md-12">Búsqueda de: <strong>{{$search}}<strong></h2>
                
            @include('video.videosList')

        </div> 
    </div>
</div>
@endsection