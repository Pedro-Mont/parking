<?php
    declare(strict_types=1);

    namespace App\Domain;

    interface ParkingPolicy
    {
        public function calculate(int $hours): float;
    }