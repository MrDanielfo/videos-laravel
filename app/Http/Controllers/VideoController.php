<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;
use App\User;

class VideoController extends Controller {

    public function createVideo(){
        return view('video.createVideo'); 
    }

    public function saveVideo(Request $request) {
        $validateData = $this->validate($request, [
            'title' => 'required|min:4',
            'description' => 'required',
            'video'     => 'mimes:mp4'
        ]); 

        $video = new Video();
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        // subida de la miniatura

        $image = $request->file('image');
        if($image) {
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path; 
        }

        // subida del video

        $video_file = $request->file('video');

        if($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));

            $video->video_path = $video_path; 
        }

        $video->save(); 

        return redirect()->route('home')->with(array(
            'message' => 'El video se ha subido correctamente'
        ));
    } 

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200); 
    }

    public function getVideoSingle($video_id) {
        $video = Video::find($video_id);

        return view('video.videoSingle', array(
            'video'   =>    $video
        ));
    }

    public function getVideo($filename) {
        $file = Storage::disk('videos')->get($filename);

        return new Response($file, 200); 
    }

    public function deleteVideo($video_id){
        $user = \Auth::user();
        $video = Video::find($video_id);
        
        $comments = Comment::where('video_id', $video_id)->get(); 

        if($user && ($video->user_id == $user->id)) {
            // eliminar comentarios
            if($comments && count($comments) >= 1) {
                foreach($comments as $comment) {
                    $comment->delete();
                }          
            }
            
            // eliminar ficheros
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            // eliminar video
            $video->delete();
            $message = array('message' => 'Video eliminado correctamente'); 
        } else {
            $message = array('message' => 'El Video no se ha eliminado correctamente'); 
        }

        return redirect()->route('home')->with($message); 
    }

    public function editVideo($video_id){

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        if($user && ($video->user_id == $user->id)) { 
            return view('video.editVideo', array(
                'video'   =>    $video
            ));
        } else {
            return redirect()->route('home');
        }
        
    }

    public function updateVideo($video_id, Request $request) {

        $validateData = $this->validate($request, [
            'title' => 'required|min:4',
            'description' => 'required',
            'video'     => 'mimes:mp4,avi',
            'image'     => 'mimes:jpeg,png'
        ]); 

        $video = Video::findOrFail($video_id);

        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        $image = $request->file('image');
        if($image) {
            Storage::disk('images')->delete($video->image);

            $image_path = time().$image->getClientOriginalName();
            Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path; 
        }

        $video_file = $request->file('video');

        if($video_file) {
            Storage::disk('videos')->delete($video->video_path);

            $video_path = time().$video_file->getClientOriginalName();  
            Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path; 
        }

        $video->save(); 

        return redirect()->route('home')->with(array(
            'message' => 'El video se ha editado correctamente'
        ));
    }

    public function search($search = null, $filter = null) {

        if(is_null($search)){
            $search = \Request::get('search'); 

            if(is_null($search)) {
                return redirect()->route('home');    
            }
            return redirect()->route('searchVideo', array(
                'search' => $search
            )); 
        }

        if(is_null($filter) && $filter = \Request::get('filter') && !is_null($search)) {
            $filter = \Request::get('filter'); 
            return redirect()->route('searchVideo', array(
                'search' => $search,
                'filter'  => $filter
            )); 
        }

        $column = 'id';
        $order  = 'desc';

        if(!is_null($filter)) {
            if($filter == 'new') {
                $column = 'id';
                $order  = 'desc';
            }

            if($filter == 'new') {
                $column = 'id';
                $order  = 'asc';
            }
            
            if($filter == 'alfa') {
                $column = 'title';
                $order  = 'asc';
            }
        }

        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->orderBy($column, $order)->paginate(5);


        return view('video.searchVideo', array(
            'videos'    => $videos,
            'search'    => $search
        )); 
    }

    
}
