<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création des utilisateurs de test
        $manager = User::factory()->manager()->create([
            'name' => 'Matis Kohn',
            'email' => 'kohnmatis01@gmail.com',
        ]);

        $student = User::factory()->student()->create([
            'name' => 'Étudiant Test',
            'email' => 'student@example.com',
        ]);

        $otherStudents = User::factory(10)->student()->create();

        // 2. Création des événements

        // Usage Nominal : Salons et JPO à venir
        $upcomingEvents = [
            [
                'title' => 'Salon de l\'Étudiant Paris',
                'description' => 'Venez découvrir les formations de la Coding Factory au Salon de l\'Étudiant. Rencontrez nos étudiants et formateurs pour discuter de votre avenir.',
                'type' => 'salon',
                'date' => now()->addWeeks(2),
                'location' => 'Paris Expo Porte de Versailles',
                'subjects' => 'Développement, IA, Cybersécurité',
                'requirements' => 'Badge d\'accès au salon requis',
                'guides' => 'Munissez-vous de vos CV et portfolios',
            ],
            [
                'title' => 'Journée Portes Ouvertes - Campus Cergy',
                'description' => 'Visitez nos locaux, découvrez nos équipements et participez à des ateliers de démonstration en direct.',
                'type' => 'jpo',
                'date' => now()->addDays(5)->setHour(10)->setMinute(0),
                'location' => 'Coding Factory, Campus de Cergy',
                'subjects' => 'Présentation du cursus L1/L2/L3',
                'requirements' => 'Sur inscription uniquement',
                'guides' => 'Parking gratuit disponible sur place',
            ],
            [
                'title' => 'Salon Tech & Digital Lyon',
                'description' => 'La Coding Factory présente ses spécialisations IA et Big Data au cœur de l\'écosystème tech lyonnais.',
                'type' => 'salon',
                'date' => now()->addMonths(1),
                'location' => 'Centre de Congrès de Lyon',
                'subjects' => 'Intelligence Artificielle, Big Data',
                'requirements' => 'Entrée libre',
                'guides' => 'Stand A12 - Hall B',
            ],
        ];

        foreach ($upcomingEvents as $eventData) {
            $event = \App\Models\Event::create($eventData);

            // Attacher quelques étudiants aléatoirement pour avoir un état "occupé"
            $event->users()->attach($otherStudents->random(rand(1, 4)));
            // Attacher l'étudiant test au premier événement pour illustrer un cas nominal
            if ($eventData['type'] === 'salon' && $eventData['title'] === 'Salon de l\'Étudiant Paris') {
                $event->users()->attach($student);
            }
        }

        // Cas d'erreur / Historique : Événement passé
        \App\Models\Event::factory()->past()->create([
            'title' => 'Conférence IA & Éthique (Terminé)',
            'description' => 'Un retour sur les enjeux de l\'IA dans le monde de l\'éducation.',
            'type' => 'jpo',
            'location' => 'Amphi A, Paris',
        ]);

        // État vide : Événement sans aucun inscrit
        \App\Models\Event::create([
            'title' => 'Nouvelle JPO : Ouverture des Inscriptions',
            'description' => 'Un nouvel événement sans encore aucun participant inscrit pour tester l\'affichage de l\'état vide.',
            'type' => 'jpo',
            'date' => now()->addMonths(3),
            'location' => 'Campus de Bordeaux',
            'subjects' => 'Toutes formations',
            'requirements' => 'Aucun',
            'guides' => 'Apportez vos questions !',
        ]);

        // Générer quelques événements supplémentaires aléatoires
        \App\Models\Event::factory(5)->create();
    }
}
