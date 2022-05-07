<?php

namespace App\Http\Controllers;

use App\Http\Requests\NlpRequest;
use App\Models\Question;
use App\Models\Topic;
use App\Traits\ApiResponser;
use JoggApp\NaturalLanguage\NaturalLanguage;
use JoggApp\NaturalLanguage\NaturalLanguageClient;

class NlpController extends Controller
{

    use ApiResponser;

    private NaturalLanguage $naturalLanguage;

    public function __construct()
    {


        $this->naturalLanguage = new NaturalLanguage(new NaturalLanguageClient(config('naturallanguage')));
    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Requests\NlpRequest
     */
    public function index(NlpRequest $request)
    {

        $entities = $this->naturalLanguage->entities($request->input('text'));

        $entitiesName = $this->costumizeEntities($entities);

        $answers = $this->getByAnswers($entitiesName);
        if (count($answers) > 0) {
            return $answers;
        }
        $questions = $this->getByAnswers($entitiesName, 'description');
        if (count($questions) > 0) {
            return $questions;
        }

        $topics = $this->getByTopics($entitiesName);
        if (count($topics) > 0) {
            return $topics;
        }

        return $this->error('Not found', 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function costumizeEntities($entities): array
    {
        $entitiesName = array();
        foreach ($entities['entities'] as $entity) {
            array_push($entitiesName, $entity['name']);
        }
        return array_unique($entitiesName);
    }

    private function getByAnswers($entitiesName, $type = 'answer'): array
    {
        $query  = null;
        $queryentitiesNameAux = $entitiesName;
        while (True) {
            if (count($entitiesName) > 0) {
                foreach ($entitiesName as $value) {
                    if (!isset($query)) {
                        $query = Question::where($type, 'LIKE', "%$value%");
                    }
                    $query =  $query->where($type, 'LIKE', "%$value%");
                }

                $response = $query->get();
                if (count($response->toArray()) > 0) {
                    return $response->toArray();
                }
                $query  = null;
                array_pop($entitiesName);
            } else {
                break;
            }
        }

        if (count($queryentitiesNameAux) > 0) {
            foreach ($entitiesName as $value) {
                $query =  Question::where($type, 'LIKE', "%$value%");
                if (count($query->toArray()) > 0) {
                    return $query->toArray();
                }
            }
        }

        return array();
    }

    private function getByTopics($entitiesName): array
    {
        $query  = null;
        $queryentitiesNameAux = $entitiesName;
        while (True) {
            if (count($entitiesName) > 0) {
                foreach ($entitiesName as $value) {
                    if (!isset($query)) {
                        $query = Topic::where('name', 'LIKE', "%$value%");
                    }
                    $query =  $query->where('name', 'LIKE', "%$value%");
                }

                $response = $query->get();
                if (count($response->toArray()) > 0) {
                    return $response->toArray();
                }
                $query  = null;
                array_pop($entitiesName);
            } else {
                break;
            }
        }

        if (count($queryentitiesNameAux) > 0) {
            foreach ($entitiesName as $value) {
                $query =  Question::where('name', 'LIKE', "%$value%");
                if (count($query->toArray()) > 0) {
                    return $query->toArray();
                }
            }
        }

        return array();
    }
}
