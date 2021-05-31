<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'           => rand(2,11),
            'person_name'       => $this->faker->name,
            'date_of_death'     => $this->faker->dateTimeBetween('-1 month', '-01 days' ),
            'relation'          => $this->faker->name,
            'number'            => $this->faker->numerify('##########'),
            'approval_status'   => config('constant.APPROVAL_STATUS.UNKNOWN'),
        ];
    }
}
