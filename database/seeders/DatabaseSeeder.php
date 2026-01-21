<?php

public function run(): void
{
    $this->call([
        DummyUserSeeder::class,
        KelasSeeder::class,
    ]);
}