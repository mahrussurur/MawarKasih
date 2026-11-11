<?php

namespace Tests\Feature;

use App\Models\ProfilDonatur;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonaturControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    // Membuat dan login sebagai Admin
    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin);
        session(['admin_last_activity' => time()]);

        return $admin;
    }

    // Membuat user Donatur beserta profilnya
    private function buatDonatur(
        array $userAttrs = [],
        array $profilAttrs = []
    ): User {
        $donatur = User::factory()->create(array_merge([
            'role' => 'donatur',
            'status' => 'aktif',
        ], $userAttrs));

        ProfilDonatur::create(array_merge([
            'user_id' => $donatur->id,
            'nama' => 'Donatur ' . $donatur->id,
            'no_hp' => '08123456789',
            'alamat' => 'Banyuwangi',
        ], $profilAttrs));

        return $donatur;
    }

    // Pengujian fungsi index()
    public function test_index_donatur(): void
    {
        $this->actingAsAdmin();

        $response = $this->get(route('admin.donatur.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donatur.index');
    }

    // Pengujian fungsi create()
    public function test_create_donatur(): void
    {
        $this->actingAsAdmin();

        $response = $this->get(route('admin.donatur.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donatur.create');
    }

    
// Pengujian fungsi store()

    // Skenario 1: Berhasil menambahkan donatur
    public function test_store_donatur_berhasil(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.donatur.store'), [
            'nama' => 'Diana Eka',
            'username' => 'diana123',
            'email' => 'diana@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '081234567890',
            'alamat' => 'Banyuwangi',
        ]);

        $response->assertRedirect(route('admin.donatur.index'));

        $this->assertDatabaseHas('users', [
            'username' => 'diana123',
            'email' => 'diana@mail.com',
            'role' => 'donatur',
        ]);

        $this->assertDatabaseHas('profil_donatur', [
            'nama' => 'Diana Eka',
            'no_hp' => '081234567890',
            'alamat' => 'Banyuwangi',
        ]);
    }

    // TC-021: Admin gagal menambahkan donatur dengan email duplikat
    public function test_store_donatur_email_duplikat(): void
    {
        $this->actingAsAdmin();

        $this->buatDonatur([
            'username' => 'diana123',
            'email' => 'diana@mail.com',
        ]);

        $jumlahUser = User::count();

        $response = $this->post(route('admin.donatur.store'), [
            'nama' => 'Diana Kedua',
            'username' => 'diana456',
            'email' => 'diana@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertEquals($jumlahUser, User::count());
    }

    // Pengujian fungsi show()
    public function test_show_donatur(): void
    {
        $this->actingAsAdmin();

        $donatur = $this->buatDonatur([
            'username' => 'diana123',
            'email' => 'diana@mail.com',
        ]);

        $response = $this->get(route('admin.donatur.show', $donatur->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donatur.show');
        $response->assertViewHas('donatur');
        $response->assertViewHas('donasi');
    }

    // Pengujian fungsi edit()
    public function test_edit_donatur(): void
    {
        $this->actingAsAdmin();

        $donatur = $this->buatDonatur([
            'username' => 'diana123',
            'email' => 'diana@mail.com',
        ]);

        $response = $this->get(route('admin.donatur.edit', $donatur->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donatur.edit');
        $response->assertViewHas('donatur');
    }

    // Pengujian fungsi update()
    public function test_update_donatur(): void
    {
        $this->actingAsAdmin();

        $donatur = $this->buatDonatur(
            [
                'username' => 'diana123',
                'email' => 'diana@mail.com',
            ],
            [
                'nama' => 'Diana Eka',
            ]
        );

        $response = $this->put(
            route('admin.donatur.update', $donatur->id),
            [
                'nama' => 'Diana Permata',
                'username' => 'diana123',
                'email' => 'diana@mail.com',
                'no_hp' => '081234567890',
                'alamat' => 'Banyuwangi',
            ]
        );

        $response->assertRedirect(route('admin.donatur.index'));

        $this->assertDatabaseHas('users', [
            'id' => $donatur->id,
            'username' => 'diana123',
            'email' => 'diana@mail.com',
        ]);

        $this->assertDatabaseHas('profil_donatur', [
            'user_id' => $donatur->id,
            'nama' => 'Diana Permata',
            'no_hp' => '081234567890',
            'alamat' => 'Banyuwangi',
        ]);
    }

// Pengujian fungsi destroy()
    public function test_destroy_donatur(): void
    {
        $this->actingAsAdmin();

        $donatur = $this->buatDonatur([
            'username' => 'diana123',
            'email' => 'diana@mail.com',
        ]);

        $response = $this->delete(
            route('admin.donatur.destroy', $donatur->id)
        );

        $response->assertRedirect(route('admin.donatur.index'));

        $this->assertDatabaseMissing('users', [
            'id' => $donatur->id,
        ]);
    }
}