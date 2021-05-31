<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $temp_name = $this->faker->name;

        return [
            'acc_id'        => strtoupper(substr($temp_name, 0, 2)."-".rand(1111,9999)),
            'fname'         => $temp_name,
            'lname'         => $this->faker->name,
            'email'         => $this->faker->unique()->safeEmail,
//            'password'      => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password'      => \Hash::make('Pass@123'), // Pass@123
            'mobile'        => $this->faker->unique()->numerify('##########'),
            'dob'           => $this->faker->dateTimeBetween('-30 years', '-01 days' ),
            'adhaar'        => $this->faker->unique()->numerify('################'),
            'lat'           => $this->faker->latitude,
            'long'          => $this->faker->longitude,
            'block_status'  => config('constant.STATUS.UNBLOCK'),
            'delete_status' => config('constant.DEL_STATUS.UNDELETED'),
            'adhaar_file'   => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
