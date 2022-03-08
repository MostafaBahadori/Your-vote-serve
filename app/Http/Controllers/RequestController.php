<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Http\Resources\RequestsCollection;
use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        return Response(RequestResource::collection(RequestModel::where('from', $request->user()->id)->orWhere('to', $request->user()->id)->distinct()->get()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'to' => 'required|exists:managers,user_id',
            'title' => 'required|string|min:4',
            'content' => 'required|min:10'
        ]);
        $fields['from'] = $user->id;
        $created_request = RequestModel::create($fields);
        return Response($created_request, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(RequestModel $request)
    {
        if($request->from != auth()->user()->id && $request->to != auth()->user()->id){
                return Response('Permission Denied', 403);
        }
        return Response(new RequestResource($request));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestModel $request)
    {
        //
    }

    /**
     * answer the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function answer(RequestModel $requestModel, Request $request)
    {
        $user = $request->user();
        if (!$user->manager->id || $user->id != $requestModel->to) {
            return Response('', 403);
        }

        $fields = $request->validate([
            'answer' => 'required|string'
        ]);
        $fields['answered_at'] = Carbon::now();

        $updated_request = $requestModel->update($fields);
        return Response($updated_request, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestModel $requestModel)
    {
        $user = $request->user();
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestModel $request)
    {
        //
    }
}
