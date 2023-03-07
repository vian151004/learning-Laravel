<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HelloService;

class HelloController extends Controller
{
    private HelloService $helloService;

    public function __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }
    
    public function Hello(Request $request, string $name): string
    {
        return $this->helloService->hello($name);
    }

    public function Request(Request $request): string
    {
        return $request->path() . PHP_EOL .
            $request->url() . PHP_EOL .
            $request->fullUrl() . PHP_EOL .
            $request->method() . PHP_EOL .
            $request->header('Accept');
    }
}
