<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use App\Rules\CheckEmailDns;

use Tests\TestCase;

class EmailDnsObjTest extends TestCase
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
    * @test
    */
    public function rule_object_version_with_valid_hosts()
    {
        $validator = Validator::make(['email' => 'somebody@gmail.com'], [
        'email' => new CheckEmailDns(),
        ]);

        $this->assertTrue($validator->passes);
    }

    /**
    * @test
    */
    public function rule_object_version_with_invalid_hosts()
    {

        $validator = Validator::make(['email' => 'somebody@invalid.gmail.com'], [
        'email' => new CheckEmailDns()

        ]);

        $this->assertTrue($validator->fails());
        $this->assertEquals(
        'The email has an invalid host.',
        $validator->errors()->first()
        );
    }

}
