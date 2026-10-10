<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\SiteParameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class GeminiAiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'admin@mlgfinedge.com'
        ]);
    }

    public function test_unauthenticated_user_cannot_test_or_save_ai_key()
    {
        $res1 = $this->post('/admin/ai/test-key', ['api_key' => 'AIzaSyTest123']);
        $res1->assertRedirect('/admin/login');

        $res2 = $this->post('/admin/ai/save-key', ['gemini_api_key' => 'AIzaSyTest123']);
        $res2->assertRedirect('/admin/login');
    }

    public function test_ai_test_key_returns_error_when_key_is_empty()
    {
        $response = $this->actingAs($this->user)->postJson('/admin/ai/test-key', [
            'api_key' => '',
            'model' => 'gemini-2.0-flash'
        ]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_ai_test_key_executes_live_or_mocked_model_diagnostic()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent*' => Http::response([
                'candidates' => [
                    ['content' => ['parts' => [['text' => 'Connected successfully to MLG Finedge.']]]]
                ]
            ], 200),
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent*' => Http::response([
                'candidates' => [
                    ['content' => ['parts' => [['text' => 'Working 1.5 flash']]]]
                ]
            ], 200),
            'https://generativelanguage.googleapis.com/v1beta/models/*' => Http::response([
                'error' => ['message' => 'Model not supported']
            ], 404),
        ]);

        $response = $this->actingAs($this->user)->postJson('/admin/ai/test-key', [
            'api_key' => 'AIzaSyMockKeyForTesting1234567890123456',
            'model' => 'all'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'recommended_model' => 'gemini-2.0-flash',
            'results' => [
                'gemini-2.0-flash' => ['working' => true, 'http_code' => 200],
                'gemini-1.5-flash' => ['working' => true, 'http_code' => 200]
            ]
        ]);
    }

    public function test_saving_gemini_key_and_model_updates_database()
    {
        $response = $this->actingAs($this->user)->postJson('/admin/ai/save-key', [
            'gemini_api_key' => 'AIzaSyProductionKey987654321',
            'gemini_model' => 'gemini-1.5-flash'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('site_parameters', [
            'id' => 'gemini_api_key',
            'value' => 'AIzaSyProductionKey987654321'
        ]);

        $this->assertDatabaseHas('site_parameters', [
            'id' => 'gemini_model',
            'value' => 'gemini-1.5-flash'
        ]);
    }
}
