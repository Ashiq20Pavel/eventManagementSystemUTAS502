<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'role'          => 'admin',
            'name'          => 'Admin User',
            'email'         => 'admin@eventportal.com',
            'password_hash' => Hash::make('password'),
        ]);

        // Organisers
        $org1 = User::create([
            'role'          => 'organiser',
            'name'          => 'Sarah Events Co.',
            'email'         => 'sarah@eventsco.com',
            'password_hash' => Hash::make('password'),
        ]);

        $org2 = User::create([
            'role'          => 'organiser',
            'name'          => 'TechConf Hobart',
            'email'         => 'techconf@hobart.com',
            'password_hash' => Hash::make('password'),
        ]);

        // Attendees
        $attendees = [];
        foreach ([
            ['Alice Chen',    'alice@example.com'],
            ['Bob Patel',     'bob@example.com'],
            ['Carla Rivera',  'carla@example.com'],
            ['David Kim',     'david@example.com'],
            ['Emma Wilson',   'emma@example.com'],
        ] as [$name, $email]) {
            $attendees[] = User::create([
                'role'          => 'attendee',
                'name'          => $name,
                'email'         => $email,
                'password_hash' => Hash::make('password'),
            ]);
        }

        // Events
        $event1 = Event::create([
            'organiser_id' => $org1->id,
            'title'        => 'Hobart Summer Music Festival',
            'description'  => 'A spectacular outdoor music festival featuring local and international artists across three stages. Food, wine, and world-class entertainment in the heart of Hobart.',
            'start_date'   => now()->addDays(30),
            'end_date'     => now()->addDays(32),
            'location'     => 'Salamanca Place, Hobart TAS 7000',
            'capacity'     => 500,
            'price'        => 89.00,
            'status'       => 'published',
        ]);

        $event2 = Event::create([
            'organiser_id' => $org2->id,
            'title'        => 'TasmanTech Conference 2025',
            'description'  => 'Tasmania\'s premier technology conference. Two days of keynotes, workshops, and networking with leaders from Australia\'s fastest-growing tech sector.',
            'start_date'   => now()->addDays(60),
            'end_date'     => now()->addDays(61),
            'location'     => 'Hotel Grand Chancellor, Hobart TAS 7000',
            'capacity'     => 300,
            'price'        => 299.00,
            'status'       => 'published',
        ]);

        $event3 = Event::create([
            'organiser_id' => $org1->id,
            'title'        => 'MONA FOMA Side Show',
            'description'  => 'An intimate evening of avant-garde performance art presented in partnership with MONA. Limited seating — reserve early.',
            'start_date'   => now()->addDays(15),
            'end_date'     => now()->addDays(15),
            'location'     => 'MONA, 655 Main Rd, Berriedale TAS 7011',
            'capacity'     => 80,
            'price'        => 45.00,
            'status'       => 'published',
        ]);

        $event4 = Event::create([
            'organiser_id' => $org2->id,
            'title'        => 'AI & Ethics Symposium',
            'description'  => 'An afternoon of panel discussions on responsible AI development, data privacy, and the future of work. Free event.',
            'start_date'   => now()->addDays(45),
            'end_date'     => now()->addDays(45),
            'location'     => 'University of Tasmania, Sandy Bay TAS 7005',
            'capacity'     => 200,
            'price'        => 0.00,
            'status'       => 'draft',
        ]);

        $event5 = Event::create([
            'organiser_id' => $org1->id,
            'title'        => 'Taste of Tasmania Preview Night',
            'description'  => 'An exclusive preview evening for the iconic Taste of Tasmania festival. Sample dishes from 30+ exhibitors before the public opening.',
            'start_date'   => now()->subDays(10),
            'end_date'     => now()->subDays(10),
            'location'     => 'Franklin Wharf, Hobart TAS 7000',
            'capacity'     => 150,
            'price'        => 35.00,
            'status'       => 'completed',
        ]);

        // Tickets
        $ticketData = [
            [$event1->id, $attendees[0]->id, 89.00],
            [$event1->id, $attendees[1]->id, 89.00],
            [$event1->id, $attendees[2]->id, 89.00],
            [$event2->id, $attendees[0]->id, 299.00],
            [$event2->id, $attendees[3]->id, 299.00],
            [$event3->id, $attendees[1]->id, 45.00],
            [$event3->id, $attendees[4]->id, 45.00],
            [$event5->id, $attendees[0]->id, 35.00],
            [$event5->id, $attendees[2]->id, 35.00],
        ];

        foreach ($ticketData as [$eventId, $userId, $amount]) {
            Ticket::create([
                'event_id'     => $eventId,
                'user_id'      => $userId,
                'ticket_code'  => strtoupper(Str::random(8) . '-' . Str::random(4)),
                'status'       => 'active',
                'amount_paid'  => $amount,
                'purchased_at' => now()->subDays(rand(1, 20)),
            ]);
        }
    }
}