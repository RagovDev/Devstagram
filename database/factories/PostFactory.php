<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Los factories sirven para hacer testing a la base de datos (tipos de datos, tablas, etc) atraves de mi aplicativo. Esto sirve durando el proceso de desarrollo para hacer todas las pruebas necesarias secuencialmente y no tener que hacerlas manualmente una a una

            //Faker es una biblioteca de generación de datos falsos (fake data) en PHP. Esta biblioteca permite crear datos ficticios que pueden ser utilizados para llenar bases de datos de prueba, realizar pruebas de software, generar contenido de muestra y otros casos en los que se necesite información simulada. Faker es ampliamente utilizado en el desarrollo de aplicaciones web y pruebas automatizadas, y es compatible con varios lenguajes de programación, incluido PHP.

            'titulo' => $this->faker->sentence(5),
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg',
            'user_id' => $this->faker->randomElement([4,5,6]),
        ];
    }
}
