<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\CsvQuestion;
use App\Models\Responser;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $topics = Topic::get();
        // return Responser::success(null, 'Topics');
        return "List of Tópics";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // $objects =  explode(',', preg_replace('/[\{\}\[\]\" "]+/', '', $request->input('headers')));

        $file = $request->file('questions');
        if ($file) {
            $path = $request->file('questions')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 0, count($data));
            unset($csv_data[0]);

            $csv_data = $this->toUtf8($csv_data);
            return $this->toCsvQuestion($csv_data);
        }
    }

    public function toUtf8($csv_data): array
    {
        $utfEncoded = array();

        foreach ($csv_data as $data) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i] = utf8_encode($data[$i]);
                // $paper = Paper::inputPaper($base, $data, $headers, $review);
            }
            array_push($utfEncoded, $data);
        }

        return $utfEncoded;
    }
    public function toCsvQuestion($csv_data): array
    {
        $csvQuestions = array();

        foreach ($csv_data as $data) {
            $newCsvQuestion = new CsvQuestion($data);
            array_push($csvQuestions, $newCsvQuestion->build());
        }

        return $csvQuestions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
