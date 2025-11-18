<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

$success = false;
$errors = [];

if (!empty($_POST)) {
    $input = [
        'plate'        => $_POST['plate'] ?? '',
        'vehicle_type' => $_POST['vehicle_type'] ?? '',
        'entry_time'   => strtotime($_POST['entry_time'] ?? ''),
        'exit_time'    => strtotime($_POST['exit_time'] ?? ''),
    ];

    $result = $service->create($input);
    
    $success = $result['ok'] ?? false;
    $errors  = $result['errors'] ?? [];
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Processando...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white font-sans flex items-center justify-center h-screen">
    
    <div class="text-center">
        <i class="fa-solid fa-spinner fa-spin text-4xl text-blue-500"></i>
        <p class="mt-4 text-gray-400">Processando registro...</p>
    </div>

    <?php if ($success): ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Registrado!',
          text: 'Veículo registrado e tarifa calculada com sucesso.',
          background: '#1f2937', 
          color: '#fff', 
          confirmButtonColor: '#2563eb',
          confirmButtonText: 'Ver Relatório'
        }).then((result) => { 
            window.location.href = 'report.php'; 
        });
      </script>
    <?php elseif (!empty($_POST)): ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Erro ao Salvar',
          html: '<ul class="text-left list-disc pl-5 text-red-400"><?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul>',
          background: '#1f2937', 
          color: '#fff', 
          confirmButtonColor: '#dc2626',
          confirmButtonText: 'Corrigir'
        }).then(() => { 
            window.history.back(); 
        });
      </script>
    <?php else: ?>
        <script>window.location.href = 'create.php';</script>
    <?php endif; ?>

</body>
</html>