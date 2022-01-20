<?php

namespace Modules\User\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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
        $name = $this->faker->unique()->name();
        return [
            'nik' => $this->faker->unique()->numerify('3209############'),
            'name' => $name,
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat' => $this->faker->streetAddress(),
            'agama' => $this->faker->randomElement(['Islam', 'Protestan', 'Katolik', 'Hindu', 'Budha', 'Konghuchu', 'Kepercayaan Lainnya']),
            'perkawinan' => $this->faker->randomElement(['Kawin', 'Cerai Mati', 'Cerai Hidup', 'Belum Kawin']),
            'pekerjaan' => $this->faker->jobTitle(),
            'negara' => 'Indonesia',
            'username' => Str::slug($name, "-"),
            'phone' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('qweqweqwe'),
            'remember_token' => Str::random(10),
        ];
    }
}
