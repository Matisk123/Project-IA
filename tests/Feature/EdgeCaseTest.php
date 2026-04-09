<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class EdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_cannot_register_to_event()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $event = Event::factory()->create([
            'date' => Carbon::now()->addDays(5),
            'type' => 'jpo'
        ]);

        $response = $this->actingAs($manager)->post(route('events.register.toggle', $event));

        $response->assertSessionHas('error', 'Action réservée aux élèves. Les managers ne peuvent pas participer.');
        $this->assertFalse($event->users()->where('user_id', $manager->id)->exists());
    }

    public function test_student_cannot_register_to_past_event()
    {
        $student = User::factory()->create(['role' => 'student']);
        $event = Event::factory()->create([
            'date' => Carbon::now()->subDays(5), // Evénement passé
            'type' => 'jpo'
        ]);

        $response = $this->actingAs($student)->post(route('events.register.toggle', $event));

        $response->assertSessionHas('error', 'Impossible de modifier votre inscription pour un événement dont la date est dépassée.');
        $this->assertFalse($event->users()->where('user_id', $student->id)->exists());
    }

    public function test_manager_cannot_delete_event_with_participants()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $student = User::factory()->create(['role' => 'student']);
        $event = Event::factory()->create([
            'date' => Carbon::now()->addDays(5),
            'type' => 'jpo'
        ]);

        $event->users()->attach($student->id);

        $response = $this->actingAs($manager)->delete(route('events.destroy', $event));

        $response->assertSessionHas('error', 'Cet événement a déjà des participants inscrits et ne peut être supprimé.');
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    public function test_manager_cannot_create_event_in_past()
    {
        $manager = User::factory()->create(['role' => 'manager']);

        $response = $this->actingAs($manager)->post(route('events.store'), [
            'title' => 'Ancien événement',
            'type' => 'jpo',
            'date' => Carbon::now()->subDays(5)->format('Y-m-d\TH:i'), // Date dans le passé
            'location' => 'Paris',
            'description' => 'Description'
        ]);

        $response->assertSessionHasErrors(['date']);
    }
}
