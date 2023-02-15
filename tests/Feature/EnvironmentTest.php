<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Env;
use function PHPUnit\Framework\assertEquals;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetEnv()
    {
        $youtube = env('YOUTUBE');
        self::assertEquals('Programmer Zaman Now' , $youtube);
    }
    public function testDefaultEnv()
    {
        $author = Env::get('AUTHOR', 'Eko');
        self::assertEquals('Eko' , $author);
    }
}