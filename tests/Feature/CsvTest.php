<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CsvTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function tes_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
