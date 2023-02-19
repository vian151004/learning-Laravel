<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;use Tests\TestCase;


class ServiceContainerTest extends TestCase
{

    public function testDependency()
    {
       $foo1 = $this->app->make(Foo::class); //new Foo()
       $foo2 = $this->app->make(Foo::class); //new Foo()

       self::assertEquals('Foo', $foo1->foo());
       self::assertEquals('Foo', $foo2->foo());
       self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function ($app){
            return new Person("Eko", "Khannedy");
        });

       $person1 = $this->app->make(Person::class); //closure() //new Person("Eko", "Khannedy")
       $person2 = $this->app->make(Person::class); //closure() //new Person("Eko", "Khannedy")

       self::assertEquals('Eko', $person1->firstname);
       self::assertEquals('Khannedy', $person2->lastname);
       self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app){
            return new Person("Eko", "Khannedy");
        });

       $person1 = $this->app->make(Person::class); //new Person("Eko", "Khannedy") if not exist
       $person2 = $this->app->make(Person::class); //return existing

       self::assertEquals('Eko', $person1->firstname);
       self::assertEquals('Khannedy', $person2->lastname);
       self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Eko", "Khannedy");
        $this->app->instance(Person::class, $person);

       $person1 = $this->app->make(Person::class); //return object $person
       $person2 = $this->app->make(Person::class); //return object $person
       $person3 = $this->app->make(Person::class); //return object $person
       $person4 = $this->app->make(Person::class); //return object $person

       self::assertEquals('Eko', $person1->firstname);
       self::assertEquals('Eko', $person2->firstname);
       self::assertSame($person, $person1);
       self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }
    
    public function testInterfaceToClass()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloservice = $this->app->make(HelloService::class);
        self::assertEquals("Halo Eko", $helloservice->hello("Eko"));
    }



}
