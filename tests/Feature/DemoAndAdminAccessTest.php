<?php

namespace Tests\Feature;

use App\Http\Controllers\DemoController;
use App\Models\DemoActivity;
use App\Models\DemoSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoAndAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_starts_and_tracks_an_anonymous_visitor(): void
    {
        $redirect = $this->get('/demo');
        $redirect->assertRedirect(route('demo.dashboard'));
        $redirect->assertCookie('demo_session');
        $this->assertDatabaseCount('demo_sessions', 1);
        $this->assertDatabaseHas('demo_activities', ['event' => 'started', 'page' => 'dashboard']);
        $demoToken = $redirect->getCookie('demo_session')->getValue();
        $this->assertTrue(app(DemoController::class)->recordPageActivity($demoToken, 'leads'));
        $this->assertDatabaseHas('demo_activities', ['event' => 'viewed', 'page' => 'leads']);
    }

    public function test_crm_and_admin_routes_require_authorization(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get('/admin')->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
        $this->get('/demo/leads')->assertForbidden();
    }

    public function test_super_admin_can_sign_in_with_environment_credentials_and_create_admins(): void
    {
        config(['demo.super_admin_email' => 'safullahzafar@gmail.com', 'demo.super_admin_password' => 'a-strong-test-password']);

        $this->post('/login', [
            'email' => 'safullahzafar@gmail.com',
            'password' => 'a-strong-test-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
        $this->get('/admin')->assertOk()->assertSee('Super Admin Dashboard');

        $this->post('/admin/admins', [
            'name' => 'Sales Admin',
            'email' => 'sales@example.com',
            'password' => 'another-strong-password',
            'password_confirmation' => 'another-strong-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('users', ['email' => 'sales@example.com', 'role' => 'admin']);
        $this->assertDatabaseCount('demo_activities', 0);
    }

    public function test_demo_activity_retains_a_session_relationship(): void
    {
        $this->get('/demo');
        $demoSession = DemoSession::query()->firstOrFail();

        $this->get('/demo/contacts');
        $this->assertGreaterThanOrEqual(2, DemoActivity::query()->whereBelongsTo($demoSession)->count());

        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
    }
}
