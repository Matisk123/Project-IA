<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Nominal : Inscription et Désinscription d'un étudiant.
     */
    public function test_student_can_toggle_registration_to_future_event()
    {
        $student = User::factory()->student()->create();
        $event = Event::factory()->create([
            'date' => Carbon::now()->addDays(2),
        ]);

        // 1. Inscription
        $response = $this->actingAs($student)->post(route('events.register.toggle', $event));
        $response->assertSessionHas('success', 'Vous vous êtes inscrit à cet événement.');
        $this->assertTrue($event->users()->where('user_id', $student->id)->exists());

        // 2. Désinscription
        $response = $this->actingAs($student)->post(route('events.register.toggle', $event));
        $response->assertSessionHas('success', 'Vous êtes désinscrit de cet événement.');
        $this->assertFalse($event->users()->where('user_id', $student->id)->exists());
    }

    /**
     * Test Nominal : Un manager peut créer un événement valide.
     */
    public function test_manager_can_create_valid_event()
    {
        $manager = User::factory()->manager()->create();

        $eventData = [
            'title' => 'Nouveau Salon Tech',
            'description' => 'Description détaillée',
            'type' => 'salon',
            'date' => Carbon::now()->addMonths(1)->format('Y-m-d\TH:i'),
            'location' => 'Paris',
        ];

        $response = $this->actingAs($manager)->post(route('events.store'), $eventData);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['title' => 'Nouveau Salon Tech']);
    }

    /**
     * Test Autorisation : Un étudiant ne peut pas créer d'événement.
     */
    public function test_student_cannot_access_create_event_page()
    {
        $student = User::factory()->student()->create();

        $response = $this->actingAs($student)->get(route('events.create'));

        $response->assertStatus(403);
    }

    /**
     * Test Autorisation : Un étudiant ne peut pas soumettre de création d'événement.
     */
    public function test_student_cannot_store_event()
    {
        $student = User::factory()->student()->create();

        $response = $this->actingAs($student)->post(route('events.store'), [
            'title' => 'Hack par étudiant',
            'description' => 'Desc',
            'type' => 'jpo',
            'date' => Carbon::now()->addDays(1)->toDateTimeString(),
            'location' => 'Cyber-espace',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('events', ['title' => 'Hack par étudiant']);
    }

    /**
     * Test Nominal : Un manager peut supprimer un événement sans inscription.
     */
    public function test_manager_can_delete_empty_event()
    {
        $manager = User::factory()->manager()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($manager)->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
