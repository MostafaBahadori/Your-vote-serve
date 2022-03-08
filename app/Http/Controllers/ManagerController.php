<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManagersCollection;
use App\Http\Resources\RequestsCollection;
use App\Http\Resources\UserResource;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    //

/**
     * Display a listing of the manager's requests.
     *
     * @return \Illuminate\Http\Response
     */

    public function request(Request $request){
        $user = $request->user();
        if(!$user->manager){
            return Response('You are not a manager!', 403);
        }

        
        return Response(new RequestsCollection($user->manager->requests()));
        


        
    }

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response(new ManagersCollection(Manager::paginate(12)));
    }
    public function create(Request $request){
        $user = $request->user();
        if($user->is_admin){
            $fields = $request->validate([
                'user_id' => 'required|integer|unique:managers,user_id|exists:users,id',
                'position'=> 'required|string|alpha',
            ]);
            $fields['creator_id'] = $user->id;
            $created_manager = Manager::create($fields);
            return Response($created_manager, 201);
        


        }else{
            return Response('', 403);
        }
    }

    public function search($query){
        // Get the search value from the request
        
    
        // Search in the title from the elections table
        $users = User::select('users.*')->join('managers', function($join)
            {
              $join->on('managers.user_id', '=', 'users.id');
           
            })->where('users.username', 'LIKE', "%{$query}%")->get();
        
    
        // Return the search
        
        return Response(UserResource::collection($users));
    }
}
