<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserJourneyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Parcours Complet : Un étudiant s'inscrit, se connecte, consulte un événement et s'y inscrit.
     */
    public function test_full_student_journey()
    {
        // 1. Création du compte étudiant (Simulation de l'inscription)
        $student = User::factory()->student()->create([
            'password' => bcrypt('password123'),
        ]);

        // 2. Connexion
        $response = $this->post('/login', [
            'email' => $student->email,
            'password' => 'password123',
        ]);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($student);

        // 3. Consultation de la liste des événements
        $event = Event::factory()->create([
            'title' => 'Salon Integration Test',
            'date' => Carbon::now()->addDays(10),
        ]);

        $response = $this->get(route('events.index'));
        $response->assertStatus(200);
        $response->assertSee('Salon Integration Test');

        // 4. Consultation du détail d'un événement
        $response = $this->get(route('events.show', $event));
        $response->assertStatus(200);
        $response->assertSee($event->description);

        // 5. Inscription à l'événement
        $response = $this->post(route('events.register.toggle', $event));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // 6. Vérification finale en base de données (Interaction complète)
        $this->assertTrue($event->users()->where('user_id', $student->id)->exists());
    }

    /**
     * Parcours Complet : Un manager crée un événement, puis tente une action interdite pour vérifier les limites.
     */
    public function test_full_manager_workflow_and_failure_case()
    {
        $manager = User::factory()->manager()->create();

        // 1. Connexion
        $this->actingAs($manager);

        // 2. Création d'un événement via l'interface (Simulation)
        $eventData = [
            'title' => 'Event Manager Workflow',
            'description' => 'Test integration',
            'type' => 'jpo',
            'date' => Carbon::now()->addWeeks(1)->format('Y-m-d\TH:i'),
            'location' => 'Salle A',
        ];

        $response = $this->post(route('events.store'), $eventData);
        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['title' => 'Event Manager Workflow']);

        $event = Event::where('title', 'Event Manager Workflow')->first();

        // 3. Cas d'échec représentatif : Le manager tente de s'inscrire à son propre événement
        // Cela doit échouer selon nos règles métier (US28/US29)
        $response = $this->post(route('events.register.toggle', $event));
        $response->assertSessionHas('error', 'Action réservée aux élèves. Les managers ne peuvent pas participer.');

        // Vérification de l'intégrité des données : pas d'inscription enregistrée
        $this->assertEquals(0, $event->users()->count());
    }
}
