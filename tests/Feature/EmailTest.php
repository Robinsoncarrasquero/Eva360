<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;


class EmailTest extends TestCase
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
     * A basic feature test example.
     *
     * @test
     */
    public function closure_rule_with_invalid_host()
    {
        $response = $this->post('check', ['email' => 'someone@invalid.gmail.com']);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['email' => 'The email has an invalid host.']);
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function closure_rule_with_valid_host() :void
    {
        $response = $this->post('check', ['email' => 'someone@gmail.com']);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }


     /**
     * @test
     */
    public function check_extends_version_with_valid_host()
    {
        $validator = Validator::make(['email' => 'somebody@gmail.com'], [
            'email' => 'check_email_dns',
        ]);
        $this->assertTrue($validator->fails());

    }
    /**
     * @test
     */
    public function check_extends_version_with_invalid_host()
    {
        $validator = Validator::make(['email' => 'somebody@invalid.gmail.com'], [
            'email' => 'check_email_dns',
        ]);
        $this->assertTrue($validator->fails());
        $this->assertEquals(
            'The email has an invalid host.',
            $validator->errors()->first()
        );
    }


}
