<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

$records = $service->all();

$totalBilling = 0.0;
$counts = ['carro' => 0, 'moto' => 0, 'caminhao' => 0];

foreach ($records as $rec) 
{
    $totalBilling += $rec->fee;
    
    if (isset($counts[$rec->vehicleType])) {
        $counts[$rec->vehicleType]++;
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Relatório Financeiro - Estacionamento do Dev</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { gold: { 500: '#f59e0b', 600: '#d97706' } } } } }
    </script>
</head>
<body class="bg-gray-900 text-gray-200 font-sans">
    
    <div class="max-w-7xl mx-auto px-4 py-10">
        
        <header class="flex items-center justify-between mb-8 border-b border-gray-700 pb-6">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-wider">
                    <i class="fa-solid fa-chart-pie text-gold-500 mr-2"></i>Relatório Gerencial
                </h1>
                <p class="text-gray-400 text-sm mt-1">Controle de faturamento e fluxo de veículos</p>
            </div>
            <a href="create.php" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-5 py-2.5 hover:bg-blue-700 transition shadow-md font-bold">
                <i class="fa-solid fa-plus"></i> Novo Registro
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-gray-800 p-5 rounded-lg border-l-4 border-gold-500 shadow-md">
                <h3 class="text-gray-400 text-sm uppercase font-bold">Faturamento Total</h3>
                <p class="text-2xl font-bold text-white mt-1">
                    R$ <?= number_format($totalBilling, 2, ',', '.') ?>
                </p>
            </div>
            
            <div class="bg-gray-800 p-5 rounded-lg border border-gray-700 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400 text-xs uppercase">Carros</h3>
                        <p class="text-xl font-bold text-blue-400 mt-1"><?= $counts['carro'] ?></p>
                    </div>
                    <i class="fa-solid fa-car text-gray-600 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gray-800 p-5 rounded-lg border border-gray-700 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400 text-xs uppercase">Motos</h3>
                        <p class="text-xl font-bold text-purple-400 mt-1"><?= $counts['moto'] ?></p>
                    </div>
                    <i class="fa-solid fa-motorcycle text-gray-600 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gray-800 p-5 rounded-lg border border-gray-700 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400 text-xs uppercase">Caminhões</h3>
                        <p class="text-xl font-bold text-green-400 mt-1"><?= $counts['caminhao'] ?></p>
                    </div>
                    <i class="fa-solid fa-truck text-gray-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400">
                    <thead class="bg-gray-700 text-gray-200 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Placa</th>
                            <th class="px-6 py-4">Veículo</th>
                            <th class="px-6 py-4">Entrada</th>
                            <th class="px-6 py-4">Saída</th>
                            <th class="px-6 py-4">Valor Total</th>
                            <th class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 text-sm">
                        <?php if (empty($records)): ?>
                            <tr><td colspan="6" class="px-6 py-4 text-center">Nenhum registro encontrado.</td></tr>
                        <?php else: ?>
                            <?php foreach ($records as $r): ?>
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 font-medium text-white"><?= htmlspecialchars($r->plate) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="bg-gray-600 text-gray-200 text-xs font-medium px-2.5 py-0.5 rounded uppercase">
                                            <?= htmlspecialchars($r->vehicleType) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4"><?= date('d/m H:i', $r->entryTimestamp) ?></td>
                                    <td class="px-6 py-4"><?= date('d/m H:i', $r->exitTimestamp) ?></td>
                                    <td class="px-6 py-4 font-bold text-green-400">
                                        R$ <?= number_format($r->fee, 2, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="confirmarExclusao(<?= $r->id() ?>)" 
                                                class="px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700 transition font-medium text-xs uppercase shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmarExclusao(id) {
            Swal.fire({
                title: 'Excluir registro?',
                text: 'Essa ação não pode ser desfeita.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4b5563',
                background: '#1f2937', color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete.php?id=' + id;
                }
            });
        }
    </script>
</body>
</html>