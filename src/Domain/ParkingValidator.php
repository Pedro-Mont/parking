<?php
declare(strict_types=1);

namespace App\Domain;

final class ParkingValidator
{
    /**
     * @param array{
     *   plate?:string,
     *   vehicle_type?:string,
     *   entryTimestamp?:string|int,
     *   exitTimestamp?:string|float,
     * } $input
     * @return string[]
     */

    public function validate(array $input): array
    {
        $errors = [];

        $plate = strtoupper(trim((string)($input['plate'] ?? '')));
        $vt = strtolower(trim((string)($input['vehicle_type'] ?? '')));
        $allowed = ['carro', 'caminhao', 'moto']; 

        if ($plate === '' || !preg_match('/^[A-Z0-9-]{5,10}$/', $plate)) {
            $errors[] = 'Placa inválida (use letras/números e hífen, 5-10 chars).';
        }
        if (!in_array($vt, $allowed, true)) {
            $errors[] = 'Tipo de veículo inválido (deve ser: car, truck, motorcycle).';
        }
        if (empty($input['entry_time']) || !is_numeric($input['entry_time'])) {
            $errors[] = 'O horário de entrada (entry_time) é obrigatório e deve ser um timestamp numérico.';
        }
        if (empty($input['exit_time']) || !is_numeric($input['exit_time'])) {
            $errors[] = 'O horário de saída (exit_time) é obrigatório e deve ser um timestamp numérico.';
        }
        if (is_numeric($input['entry_time'] ?? 0) && is_numeric($input['exit_time'] ?? 0)) {
            if ((int)$input['exit_time'] < (int)$input['entry_time']) {
                $errors[] = 'O horário de saída não pode ser anterior ao de entrada.';
            }
        }
        return $errors;
    }
}