<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    private $data;
    private $token;
    private $headers;

    public function init()
    {
        $this->data = [
            'email' => 'admin@ufba.br',
            'password' => 'admin1',
        ];

        $response = $this->post('/api/v2/auth/login', $this->data);
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
        $response = $this->get('/api/v1/topics/25');

        //assert
        $response->assertOk();
        $response->assertExactJson(
        [[
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
        ]]);
    }

    public function test_v1_show_topics_not_found()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/5');
        //$responseJson = $response->json();

        //assert
        $response->assertNotFound();
        $response->assertExactJson([
            "status" => "Error",
            "message" => "Topic not found",
            "data" => null
        ]);
    }

    public function test_v3_show_topics_returned()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/25');

        //assert
        $response->assertOk();
        $response->assertExactJson(
            [
                [
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
                ]
            ]);
    }

    public function test_v3_show_topics_not_found()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/5');
        //$responseJson = $response->json();

        //assert
        $response->assertNotFound();
        $response->assertExactJson([
            "status" => "Error",
            "message" => "Topic not found",
            "data" => null
        ]);
    }
}
