<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'name' => 'task name',
        'description' => 'description',
        'status' => 'some status',
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'assigned_to' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
