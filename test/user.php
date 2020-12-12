<?php

    require_once './vendor/autoload.php';

    $faker = Faker\user::create('ja_JP');

    for($i=0; $i<10; $i++)
    {
        echo $faker->name."<br>";
        echo $faker->email."<br>";
        echo $faker->userName."<br>";
        echo $faker->password."<br>";
        echo $faker->token."<br>";
        echo $faker->birth($format='Y-m-d',$max='2000-11-20')."<br>";
        echo "<hr>";
    }