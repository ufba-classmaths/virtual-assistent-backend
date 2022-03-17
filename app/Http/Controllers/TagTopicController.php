<?php

namespace App\Http\Controllers;

use App\Models\TagTopic;
use App\Http\Requests\StoreTagTopicRequest;
use App\Http\Requests\UpdateTagTopicRequest;

class TagTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTagTopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagTopicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TagTopic  $tagTopic
     * @return \Illuminate\Http\Response
     */
    public function show(TagTopic $tagTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TagTopic  $tagTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(TagTopic $tagTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagTopicRequest  $request
     * @param  \App\Models\TagTopic  $tagTopic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagTopicRequest $request, TagTopic $tagTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TagTopic  $tagTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(TagTopic $tagTopic)
    {
        //
    }
}
