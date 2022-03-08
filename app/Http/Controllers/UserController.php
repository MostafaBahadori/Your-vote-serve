<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //


    public function show(Request $request){
        return Response(new UserResource($request->user()));


    }
    
    public function update(Request $request){
        $user = $request->user();
        $fields = $request->validate([
            'first_name'=>'required|min:3|max:24|string',
            'last_name'=>'required|min:3|max:24|string',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'username'=>'required|min:4|max:24|alpha_num|unique:users,username,'.$user->id,
        ]);
        $pic = $request->file('pic');
        if(isset($pic) && $pic != null){
            $fields['pic'] = Storage::putFile('public/pic/users', $pic, 'public');
        }
        $updated_user = $user->update($fields);
        return Response($updated_user);


    }

    public function destroy(Request $request){
        if($request->user()->delete()){
            return Response(1, 204);
        }else{
            return Response(0, 404);
        }

    }

    
    public function search($query){
        // Get the search value from the request
        
    
        // Search in the title from the elections table
        $users = User::query()
            ->where('username', 'LIKE', "%{$query}%")->get();
    
        // Return the search
        
        return Response(UserResource::collection($users));
    }
}
