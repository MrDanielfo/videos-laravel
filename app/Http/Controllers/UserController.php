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

class UserController extends Controller
{
    public function channel($user_id){
        $user = User::find($user_id);

        if(!is_object($user)) {
            return redirect()->route('home'); 
        }

        $videos = Video::where('user_id', $user_id)->paginate(5);

        /* si se usa sólo $id, se debe respetar en todos los parámetros */
        /* es un error usar $id, y posteriormente, 'user_id', $user_id */ 
        /* para seguir la práctica del video se utilizará mejor user_id */ 

        return view('user.channel', array(
            'user'      => $user,
            'videos'    => $videos
        )); 
    }
}
