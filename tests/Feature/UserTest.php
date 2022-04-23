<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    private $user;
    private $token;
    private $headers;
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

    private $json_structure_return = [
        [
            "id",
            "name",
            "email",
            "email_verified_at",
            "password",
            "created_at",
            "updated_at",

        ]
    ];


    public function test_get_all_users()
    {
        $this->init();
        $response = $this->get('/api/v3/users');
        //assert
        //$response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
        $json = $response->json();
        echo json_encode($json);
    }

    public function test_store_user(){
        $new_user = [
            [
                "name" => "TestNome",
                "email" => "123@ufba.br",
                "password" => "12345",
            ]
            ];
        $response = $this->withHeaders($this->headers)->post('/api/v3/users', $new_user);
    }




}
