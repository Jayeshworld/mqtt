<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Elevator;
use Faker\Factory as Faker;

class UserElevatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // First, let's create some elevators
        $this->createElevators($faker);
        
        // Then create users and assign elevators to them
        $this->createUsers($faker);
    }

    /**
     * Create elevators for assignment to users
     */
    private function createElevators($faker): void
    {
        $elevatorNames = [
            'Main Building Lift A', 'Main Building Lift B', 'Tower North Elevator',
            'Tower South Elevator', 'Parking Garage Lift', 'Service Elevator 1',
            'Service Elevator 2', 'Express Lift', 'Freight Elevator A',
            'Freight Elevator B', 'Hospital Wing Lift', 'East Wing Elevator',
            'West Wing Elevator', 'Emergency Lift', 'VIP Executive Lift',
            'Staff Only Elevator', 'Loading Bay Lift', 'Rooftop Access Lift',
            'Basement Level Lift', 'Central Core Elevator', 'Fire Exit Lift',
            'Mall Elevator A', 'Mall Elevator B', 'Office Complex Lift 1',
            'Office Complex Lift 2', 'Residential Tower A', 'Residential Tower B',
            'Hotel Guest Elevator', 'Hotel Service Lift', 'Conference Hall Lift',
            'Auditorium Elevator', 'Library Lift', 'Laboratory Access Lift',
            'Storage Area Lift', 'Maintenance Elevator', 'Security Office Lift',
            'Reception Area Lift', 'Cafeteria Service Lift', 'Gymnasium Elevator',
            'Pool Area Lift', 'Spa Access Elevator', 'Penthouse Private Lift',
            'Garden Level Elevator', 'Mezzanine Floor Lift', 'Observatory Lift',
            'Rooftop Bar Elevator', 'Kitchen Service Lift', 'Banquet Hall Lift',
            'Meeting Room Elevator', 'Executive Floor Lift', 'Data Center Lift'
        ];

        $locations = [
            'New York, NY', 'Los Angeles, CA', 'Chicago, IL', 'Houston, TX',
            'Phoenix, AZ', 'Philadelphia, PA', 'San Antonio, TX', 'San Diego, CA',
            'Dallas, TX', 'San Jose, CA', 'Austin, TX', 'Jacksonville, FL',
            'Fort Worth, TX', 'Columbus, OH', 'Charlotte, NC', 'San Francisco, CA',
            'Indianapolis, IN', 'Seattle, WA', 'Denver, CO', 'Washington, DC',
            'Boston, MA', 'El Paso, TX', 'Nashville, TN', 'Detroit, MI',
            'Oklahoma City, OK', 'Portland, OR', 'Las Vegas, NV', 'Memphis, TN',
            'Louisville, KY', 'Baltimore, MD', 'Milwaukee, WI', 'Albuquerque, NM',
            'Tucson, AZ', 'Fresno, CA', 'Sacramento, CA', 'Mesa, AZ',
            'Kansas City, MO', 'Atlanta, GA', 'Omaha, NE', 'Colorado Springs, CO',
            'Raleigh, NC', 'Miami, FL', 'Virginia Beach, VA', 'Oakland, CA',
            'Minneapolis, MN', 'Tulsa, OK', 'Arlington, TX', 'Tampa, FL'
        ];

        $statuses = ['active', 'maintenance', 'inactive', 'under_repair'];
        $capacities = [500, 750, 1000, 1250, 1500, 2000, 2500, 3000];

        foreach ($elevatorNames as $index => $name) {
            Elevator::create([
                'maac_id' => 'MAAC-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'name' => $name,
                'location' => $faker->randomElement($locations),
                'capacity' => $faker->randomElement($capacities),
                'status' => $faker->randomElement($statuses),
                'remarks' => $faker->optional(0.3)->sentence(),
                'user_id' => null, // Will be assigned later
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Create users with fake data
     */
    private function createUsers($faker): void
    {
        $roles = ['admin', 'manager', 'user', 'guest'];
        $roleWeights = [
            'admin' => 5,    // 5% admin
            'manager' => 15, // 15% manager  
            'user' => 75,    // 75% user
            'guest' => 5     // 5% guest
        ];

        // US States for realistic addresses
        $states = [
            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA',
            'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD',
            'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ',
            'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC',
            'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'
        ];

        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
            'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose',
            'Austin', 'Jacksonville', 'Fort Worth', 'Columbus', 'Charlotte',
            'San Francisco', 'Indianapolis', 'Seattle', 'Denver', 'Washington',
            'Boston', 'El Paso', 'Nashville', 'Detroit', 'Oklahoma City',
            'Portland', 'Las Vegas', 'Memphis', 'Louisville', 'Baltimore',
            'Milwaukee', 'Albuquerque', 'Tucson', 'Fresno', 'Sacramento',
            'Mesa', 'Kansas City', 'Atlanta', 'Omaha', 'Colorado Springs'
        ];

        $countries = ['United States', 'Canada', 'United Kingdom', 'Australia', 'Germany'];

        // Create 100 users
        for ($i = 1; $i <= 100; $i++) {
            // Weighted role selection
            $role = $this->getWeightedRole($roleWeights);
            
            // Create user
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password123'), // Default password
                'role' => $role,
                'mobile' => $faker->optional(0.8)->phoneNumber(),
                'address' => $faker->optional(0.9)->streetAddress(),
                'city' => $faker->optional(0.9)->randomElement($cities),
                'state' => $faker->optional(0.9)->randomElement($states),
                'country' => $faker->randomElement($countries),
                'zip' => $faker->optional(0.8)->postcode(),
                'profile_picture' => $faker->optional(0.3)->imageUrl(200, 200, 'people'),
                'email_verified_at' => $faker->optional(0.85)->dateTimeBetween('-1 year', 'now'),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ]);

            // Assign elevators to users (not all users will have elevators)
            $this->assignElevatorsToUser($user, $faker);
        }
    }

    /**
     * Get weighted random role
     */
    private function getWeightedRole(array $roleWeights): string
    {
        $rand = rand(1, 100);
        $cumulative = 0;
        
        foreach ($roleWeights as $role => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $role;
            }
        }
        
        return 'user'; // fallback
    }

    /**
     * Assign elevators to user based on their role
     */
    private function assignElevatorsToUser(User $user, $faker): void
    {
        // Different elevator assignment probability based on role
        $assignmentProbability = match ($user->role) {
            'admin' => 0.95,    // 95% chance
            'manager' => 0.80,  // 80% chance
            'user' => 0.60,     // 60% chance
            'guest' => 0.20,    // 20% chance
            default => 0.50
        };

        // Skip if random chance says no assignment
        if (!$faker->optional($assignmentProbability)->boolean()) {
            return;
        }

        // Number of elevators to assign based on role
        $elevatorCount = match ($user->role) {
            'admin' => $faker->numberBetween(3, 8),
            'manager' => $faker->numberBetween(2, 5),
            'user' => $faker->numberBetween(1, 3),
            'guest' => 1,
            default => 1
        };

        // Get available elevators (not assigned or can be shared)
        $availableElevators = Elevator::inRandomOrder()
            ->limit($elevatorCount * 2) // Get more than needed for randomness
            ->get();

        // Assign elevators
        $selectedElevators = $availableElevators->random(min($elevatorCount, $availableElevators->count()));
        
        foreach ($selectedElevators as $elevator) {
            // Update elevator with user_id (assuming many-to-one relationship)
            // If you have many-to-many relationship, you'd use attach() instead
            $elevator->update(['user_id' => $user->id]);
        }
    }
}