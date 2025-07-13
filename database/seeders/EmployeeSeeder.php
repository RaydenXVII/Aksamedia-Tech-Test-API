<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = Division::all();

        foreach ($divisions as $division) {
            Employee::create([
                'id' => Str::uuid(),
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'image' => null,
                'position' => 'Staff',
                'division_id' => $division->id,
            ]);
        }
    }
}
