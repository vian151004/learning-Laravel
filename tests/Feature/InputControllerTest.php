<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Eko') //kirim querry parameter
            ->assertSeeText("Hello Eko");
            
        $this->post('/input/hello', [
            'name' => 'Eko'
        ])->assertSeeText("Hello Eko"); //kirim request body
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "Eko",
                "last" => "Khannedy"
            ]
        ])->assertSeeText("Hello Eko"); 
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "Eko",
                "last" => "Khannedy"
            ]
        ])->assertSeeText("name")->assertSeeText("first") 
            ->assertSeeText("last")->assertSeeText("Eko")
            ->assertSeeText("Khannedy"); 
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            'products' => [
                [
                    "name" => "Apple Macbook Pro",
                    "price" => 30000
                ],
                [
                    "name" => "Samsung Galaxy S10",
                    "price" => 10000
                ]
            ]
        ])->assertSeeText('Apple Macbook Pro')
            ->assertSeeText('Samsung Galaxy S10');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10',
        ])->assertSeeText("Budi")->assertSeeText("true")->assertSeeText("1990-10-10");
    }
}
