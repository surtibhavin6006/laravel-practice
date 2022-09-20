<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->name(),
            'start_date' => fake()->dateTimeBetween('+0 days', '+3 days'),
        ];
    }

    public function withEndDateDaily()
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => fake()->dateTimeBetween('+4 days', '+5 days'),
            'repeat_on' => 'D'
        ]);
    }

    public function withEndDateWeekly()
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => fake()->dateTimeBetween('+4 days', '+5 days'),
            'repeat_on' => 'W',
            'repeat_week' => fake()->randomElement(array_keys(config('event.repeat_weeks')))
        ]);
    }

    public function withEndDateMonthly()
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => fake()->dateTimeBetween('+4 days', '+5 days'),
            'repeat_on' => 'M',
            'repeat_month' => fake()->randomElement(config('event.repeat_months'))
        ]);
    }

    public function withEndDateYearly()
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => fake()->dateTimeBetween('+4 days', '+5 days'),
            'repeat_on' => 'Y'
        ]);
    }

    public function withEndAfterNumOfOccurenceDaily()
    {
        return $this->state(fn (array $attributes) => [
            'end_after_occurrences' => fake()->numberBetween(1,20),
            'repeat_on' => 'D'
        ]);
    }

    public function withEndAfterNumOfOccurenceWeekly()
    {
        return $this->state(fn (array $attributes) => [
            'end_after_occurrences' => fake()->numberBetween(1,20),
            'repeat_on' => 'W',
            'repeat_week' => fake()->randomElement(array_keys(config('event.repeat_weeks')))
        ]);
    }

    public function withEndAfterNumOfOccurenceMonthly()
    {
        return $this->state(fn (array $attributes) => [
            'end_after_occurrences' => fake()->numberBetween(1,20),
            'repeat_on' => 'M',
            'repeat_month' => fake()->randomElement(config('event.repeat_months'))
        ]);
    }

    public function withEndAfterNumOfOccurenceYearly()
    {
        return $this->state(fn (array $attributes) => [
            'end_after_occurrences' => fake()->numberBetween(1,20),
            'repeat_on' => 'Y'
        ]);
    }
}
