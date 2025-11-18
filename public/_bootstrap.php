<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\ParkingService;
use App\Domain\ParkingCalculator;
use App\Domain\ParkingValidator;
use App\Domain\Policies\CarPolicy;
use App\Domain\Policies\TruckPolicy;
use App\Domain\Policies\MotorcyclePolicy;
use App\Infra\SqliteParkingRepository;

$pdo = new PDO('sqlite:' . __DIR__ . '/../storage/database.sqlite');

$calculator = new ParkingCalculator([
    'carro'    => new CarPolicy(),
    'moto'     => new MotorcyclePolicy(),
    'caminhão' => new TruckPolicy(),
]);

$repo = new SqliteParkingRepository($pdo);
$validator = new ParkingValidator();

$service = new ParkingService($repo, $validator, $calculator);