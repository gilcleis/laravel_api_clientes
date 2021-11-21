<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'telefone'=> $this->faker->numerify('###########'),
            'cpf' => $this->faker->numerify('###########'),
            'placa_carro'=> strtoupper($this->faker->bothify('???-#?###', 'ABCDE')),
        ];
    }
}
