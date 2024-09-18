<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LeaveApplication;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveApplication>
 */
class LeaveApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeaveApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->numberBetween(1, 10), // Assuming 10 users exist
            'name' => $this->faker->name(),
            'username' => $this->faker->userName(),
            'leave_type' => $this->faker->word(),
            'start_date' => $this->faker->dateTimeBetween('-30 days', '+30 days'),
            'end_date' => $this->faker->dateTimeBetween('start_date', '+30 days'),
            'start_half' => $this->faker->randomElement(['AM', 'PM']),
            'end_half' => $this->faker->randomElement(['AM', 'PM']),
            'number_of_days' => $this->faker->numberBetween(1, 5),
            'rejection_reason' => $this->faker->optional()->sentence(),
            'reason' => $this->faker->sentence(),
            'total_leave' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'on_date' => $this->faker->date(),
            'on_time' => $this->faker->time(),
        ];
    }
}