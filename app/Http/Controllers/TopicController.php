<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\StoreTopicRequest;
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
        return  Topic::whereNotNull("name")->get()->toTree();
    }

    public function getRoots()
    {
        $roots =   Topic::where("name", "<>", "")->with('questions')->whereIsRoot()->get()->toTree();
        $validRoots = array();
        foreach ($roots as $root) {
            if ($this->isValidMenu($root->id)) {
                array_push($validRoots, $root);
            }
        }

        return $validRoots;
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWithParent(StoreTopicRequest $request, $id)
    {


        if ($parent = Topic::find($id)) {
            $newTopic = Topic::create($request->all());

            $parent->appendNode($newTopic);
            return $this->success('Topic registred', 201);
        }

        return $this->error('Parent not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $topic = Topic::with('questions')->descendantsAndSelf($id)->toTree();
        if ($topic) {
            $children = array();
            if (count($topic[0]->children) > 0) {
                foreach ($topic[0]->children as $child) {
                    return $child;
                    if ($this->isValidMenu($child->id) && $child->name != "") {
                        array_push($children, $child);
                    }
                }
                return array("id" => $topic[0]->id, "name" => $topic->name, "children" => $children);
            } else {
                return $topic[0]->questions;
            }
        }

        return $this->error('Topic not found', 404);
    }

    public function isValidMenu($id)
    {

        return  $leaves = Topic::with('questions')->whereIsLeaf()->descendantsAndSelf($id)->toTree();

        $validList = array();
        foreach ($leaves as $leave) {
            if (count($leave->questions) > 0) {
                array_push($validList, $leave);
            }
        }

        return count($validList) > 0;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTopicRequest  $request
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTopicRequest $request, Topic $topic)
    {
        if ($topic) {
            $topic->name = $request->input('name');
            $topic->update();
            return $this->success('Topic updated', 200);
        }

        return $this->error('Topic not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($topic = Topic::find($id)) {
            $topic->delete();
            return $this->success('Topic deleted', 200);
        }

        return $this->error('Topic not found', 404);
    }
}
