<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;

class ClientValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user for authentication
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);
    }

    public function test_email_is_required_for_client_creation()
    {
        $this->actingAs($this->admin);

        $clientData = [
            'name' => 'Test Client',
            'address' => 'Test Address 123',
            'postal_code' => '1234 AB',
            'phone' => '0612345678',
            // 'email' is intentionally missing
            'preference' => null,
            'adults' => 2,
            'children' => 1,
            'babies' => 0,
            'comment' => 'Test comment',
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('clients', [
            'name' => 'Test Client'
        ]);
    }

    public function test_email_must_be_valid_format()
    {
        $this->actingAs($this->admin);

        $clientData = [
            'name' => 'Test Client',
            'address' => 'Test Address 123',
            'postal_code' => '1234 AB',
            'phone' => '0612345678',
            'email' => 'invalid-email-format',
            'preference' => null,
            'adults' => 2,
            'children' => 1,
            'babies' => 0,
            'comment' => 'Test comment',
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('clients', [
            'name' => 'Test Client'
        ]);
    }

    public function test_email_must_be_unique()
    {
        $this->actingAs($this->admin);

        // Create existing client
        Client::factory()->create([
            'email' => 'existing@test.com'
        ]);

        $clientData = [
            'name' => 'Test Client',
            'address' => 'Test Address 123',
            'postal_code' => '1234 AB',
            'phone' => '0612345678',
            'email' => 'existing@test.com', // Duplicate email
            'preference' => null,
            'adults' => 2,
            'children' => 1,
            'babies' => 0,
            'comment' => 'Test comment',
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertSessionHasErrors('email');
        $this->assertEquals(1, Client::where('email', 'existing@test.com')->count());
    }

    public function test_client_can_be_created_with_valid_email()
    {
        $this->actingAs($this->admin);

        $clientData = [
            'name' => 'Test Client',
            'address' => 'Test Address 123',
            'postal_code' => '1234 AB',
            'phone' => '0612345678',
            'email' => 'valid@test.com',
            'preference' => null,
            'adults' => 2,
            'children' => 1,
            'babies' => 0,
            'comment' => 'Test comment',
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertRedirect(route('clients.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('clients', [
            'email' => 'valid@test.com',
            'name' => 'Test Client'
        ]);
    }
}
