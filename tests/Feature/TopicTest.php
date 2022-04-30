<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    private $user;
    private $token;
    private $headers;

    private $existent_topic = '27';
    private $non_existent_topic = '500';

    private $not_found_return = [
        "status" => "Error",
        "message" => "Topic not found",
        "data" => null
    ];
    private $json_structure_return = [
        [
            "id",
            "name",
            "questions" => [
                '*' => [
                    "id",
                    "topic_id",
                    "description",
                    "answer"
                ]
            ],
            "children" => [
                '*' => []
            ]
        ]
    ];

    public function init()
    {
        $this->user = [
            'email' => 'admin@ufba.br',
            'password' => 'admin1',
        ];

        $response = $this->post('/api/v2/auth/login', $this->user);
        $responseJson = $response->json();
        $this->token = $responseJson['data']['token'];
        $this->headers = [
            'accept' => 'application/json',
            'authentication' => 'Bearer ' . $this->token,
        ];
    }

    // /api/v1/topics/
    public function test_v1_get_root_topics_returned()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/');

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);

        for ($i = 0; $i < count($response->json()); $i++){
            $response->assertJsonCount(0, $i.'.children');
        }
    }

    // /api/v1/topics/{topic}
    public function test_v1_topic_subtree_returned()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/' . $this->existent_topic);

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    // /api/v1/topics/{topic}
    public function test_v1_topic_not_found()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/' . $this->non_existent_topic);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->not_found_return);
    }

    // /api/v3/topics/
    public function test_v3_full_topic_tree_returned()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
        ->get('/api/v3/topics/');

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    // /api/v3/topics/{topic}
    public function test_v3_topic_subtree_returned()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->existent_topic);

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    // /api/v3/topics/{topic}
    public function test_v3_topic_not_found()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->non_existent_topic);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->not_found_return);
    }
}
