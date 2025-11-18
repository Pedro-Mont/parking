<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Registro - Estacionamento do Dev</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { gold: { 500: '#f59e0b', 600: '#d97706' } } } }
        }
    </script>
</head>
<body class="bg-gray-900 text-gray-200 font-sans">

    <header class="bg-gray-800 border-b border-gray-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-wider">
                    <i class="fa-solid fa-square-parking text-gold-500 mr-2"></i>Estacionamento do Dev
                </h1>
            </div>
            <a href="report.php" class="text-gold-500 hover:text-gold-600 font-bold">
                <i class="fa-solid fa-list mr-1"></i> Ver Relatório
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700 max-w-4xl mx-auto">
            <h2 class="text-xl font-semibold text-white mb-6 border-b border-gray-600 pb-2">
                Registrar Entrada
            </h2>
            
            <form action="store.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Placa do Veículo</label>
                    <input type="text" name="plate" placeholder="ABC-1234" required
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Tipo</label>
                    <select name="vehicle_type" class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 focus:border-blue-500 outline-none">
                        <option value="carro">Carro (R$ 5/h)</option>
                        <option value="moto">Moto (R$ 3/h)</option>
                        <option value="caminhao">Caminhão (R$ 10/h)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Data/Hora Entrada</label>
                    <input type="datetime-local" name="entry_time" required
                           value="<?= date('Y-m-d\TH:i', strtotime('-1 hour')) ?>"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 focus:border-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Data/Hora Saída</label>
                    <input type="datetime-local" name="exit_time" required
                           value="<?= date('Y-m-d\TH:i') ?>"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 focus:border-blue-500 outline-none">
                </div>

                <div class="md:col-span-2 mt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded shadow-md transition duration-200">
                        <i class="fa-solid fa-check mr-2"></i> Calcular e Salvar
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>