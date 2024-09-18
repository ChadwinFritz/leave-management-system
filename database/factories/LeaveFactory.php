<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Leave;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Leave::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->numberBetween(1, 10), // Assuming 10 users exist
            'username' => $this->faker->userName(),
            'application_id' => $this->faker->uuid(),
            'total_leave' => $this->faker->numberBetween(1, 5),
            'start_date' => $this->faker->dateTimeBetween('-30 days', '+30 days'),
            'end_date' => $this->faker->dateTimeBetween('start_date', '+30 days'),
            'start_half' => $this->faker->randomElement(['AM', 'PM']),
            'end_half' => $this->faker->randomElement(['AM', 'PM']),
            'on_date' => $this->faker->date(),
            'on_time' => $this->faker->time(),
            'leave_type' => $this->faker->word(),
        ];
    }
}