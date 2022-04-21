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

    private $existent_topic = [
        'id' => '25',
        'return' => [[
            "id" => 25,
            "name" => "institucional",
            "questions" => [
                [
                    "id" => 8,
                    "topic_id" => 25,
                    "description" => "Site do Instituto de Computação da UFBA",
                    "answare" => null
                ]
            ],
            "children" => []
        ]]
    ];

    private $non_existent_topic = [
        'id' => '5',
        'return' => [
            "status" => "Error",
            "message" => "Topic not found",
            "data" => null
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

    public function test_v1_show_topics_returned()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/' . $this->existent_topic['id']);

        //assert
        $response->assertOk();
        $response->assertExactJson($this->existent_topic['return']);
    }

    public function test_v1_show_topics_not_found()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/' . $this->non_existent_topic['id']);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->non_existent_topic['return']);
    }

    public function test_v3_show_topics_returned()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->existent_topic['id']);

        //assert
        $response->assertOk();
        $response->assertExactJson($this->existent_topic['return']);
    }

    public function test_v3_show_topics_not_found()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->non_existent_topic['id']);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->non_existent_topic['return']);
    }
}
