    <div id="videos-list">
        @if(count($videos) >= 1)
        @foreach($videos as $video)
            <div class="video-item col-md-8 pull-left panel panel-default">
                <div class="panel-body">
                    @if(Storage::disk('images')->has($video->image))
                        <div class="video-image-thumb col-md-4 pull-left">
                            <div class="video-image-mask">
                                    <img src="{{ url('miniatura/'.$video->image) }}" alt="{{ $video->title }}" class="img-responsive video-image">
                            </div>
                        </div>   
                    @endif
                    <div class="data">
                        <h4 class="video-title"><a href="{{ url('video-detail/'.$video->id)}}">{{$video->title}}</a></h4>
                        <a href="{{ route('channelUser', ['user_id' => $video->user_id ]) }}" class="canal-usuario">{{$video->user->name}}</a>
                    </div>
                    <!-- botones de accion -->
                    <a href="{{ url('video-detail/'.$video->id)}}" class="btn btn-success">Ver</a>
                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                    <a href="{{ url('video-edit/'.$video->id)}}" class="btn btn-warning">Editar</a>
                    <a href="#modal-{{$video->id}}" role="button" class="btn btn-danger" data-toggle="modal">Eliminar</a>    
                        <!-- Modal / Ventana / Overlay en HTML -->
                        <div id="modal-{{$video->id}}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">¿Estás seguro?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Seguro que quieres borrar el video?</p>
                                        <p class="text-warning"><small>{{$video->title}}</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a href="{{ route('videoDelete', ['video_id' => $video->id]) }}" type="button" class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
        @else
            <div class="alert alert-warning">
                No hay videos actualmente
            </div>
        @endif
        
    </div>
    <div class="col-md-4 col-md-offset-4">
        {{ $videos->links() }}
    </div>
    