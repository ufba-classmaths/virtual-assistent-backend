<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Traits\ApiResponser;

class TopicController extends Controller
{

    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Topic::with('questions')->get()->toTree();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        Topic::create($request->all());

        return $this->success('Topic registred', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        if ($topic) {
            return Topic::descendantsAndSelf($topic->id)->toTree();
        }

        return $this->error('Topic not found', 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTopicRequest  $request
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        if ($topic) {
            $topic->name = $request->input('name');
            $topic->update();
            return $this->success('Topic update', 200);
        }

        return $this->error('Topic not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        if ($topic) {
            $topic->delete();
            return $this->success('Topic deleted', 200);
        }

        return $this->error('Topic not found', 404);
    }
}
