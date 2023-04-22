<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => 'Front-end developer',
            "icon" => 'uil uil-brackets=curly',
            "description" => "Service description ...."
        ];
    }
}
