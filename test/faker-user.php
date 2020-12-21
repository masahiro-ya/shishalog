<?php
    require_once '../db_connect.php';
    require_once '../vendor/autoload.php';

    $faker = Faker\Factory::create('ja_JP');
    $data = [];
  for ($i = 0; $i < 10; $i++) {
    $data = [];
    $data[] = $faker->name;
    $data[] = mb_substr($faker->address, 9);
    $data[] = $faker->date;
    $data[] = $faker->time;
    $data[] = $faker->time;
    $sql =
      "INSERT INTO shop (
        shopName,
        address,
        openDate,
        openTime,
        closeTime
        )
      VALUES (
        :shopName,
        :address,
        :openDate,
        :openTime,
        :closeTime
      )";
    $stmt = connect()->prepare($sql);
    $stmt->bindValue(':shopName', $shopName);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':openDate', $openDate);
    $stmt->bindValue(':openTime', $openTime);
    $stmt->bindValue(':closeTime', $closeTime);
    $stmt->execute();
  }
  var_dump($data);

