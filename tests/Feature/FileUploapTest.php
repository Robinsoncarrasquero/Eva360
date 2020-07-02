<?php

namespace Tests\Feature;

use ErrorException;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Testing\file;
use Tests\TestCase;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class FileUploapTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * Test para saber si es un archivo json realmente
     * @test
     */
    public function test_Json_FileUpload_exits(){

        $data=['Evaluado'=>'Pedro','Evaluadores'=>['name'=>'Juan Justino','relation'=>'Boss','email'=>'jjuan@example.com']];

        $file = UploadedFile::fake()->create('test.json');
        $response = $this->json('POST', 'file-upload', ['fileName'=>$file,'file'=>$data]);

        // $this->getJson(route('jsonfile', ['file'=>'eva360.json']))
        // ->assertJsonPath('Evaluadores.0.email', [
        //     'jjuan@example.com',

        // ]);

         $response->assertExactJson($data);
         $response
             ->assertStatus(201)
             ->assertJsonPath('uploads', 'application/json');

        Storage::assertExists('uploads/eva360.json');
        Storage::assertMissing('/uploads/test.json');

    }

    public function testing(){
        $data=['Evaluado'=>'Pedro','Evaluadores'=>['name'=>'Juan Justino','relation'=>'Boss','email'=>'jjuan@example.com']];

        $this->getJson(route('file-upload', ['fileName'=>$data]))
        ->assertJsonPath('uploads', [])
        ->assertJsonPath('comments.0.user.username', 'Pedro')
        ->assertJsonPath('comments.*.body', [
            'First!',
            'This is my comment',
        ]);

    }


    public function testAvatarUpload()
    {
        //Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->json('POST', 'file', [
            'avatar' => $file,
        ]);


        // Assert the file was stored...
        $response->assertJsonPath('avatar.jpg','image');
        //Storage::assertExists('avatar.jpg');

    }




}
