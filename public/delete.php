<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

$id = (int)($_GET['id'] ?? 0);
$result = $service->delete($id);
$success = $result['ok'] ?? false;
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Deletando...</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <body class="bg-gray-900">
    <?php if ($success): ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Excluído',
          background: '#1f2937', color: '#fff', confirmButtonColor: '#2563eb',
          timer: 1500, showConfirmButton: false
        }).then(() => { window.location.href = 'report.php'; });
      </script>
    <?php else: ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Erro ao excluir',
          background: '#1f2937', color: '#fff', confirmButtonColor: '#dc2626'
        }).then(() => { window.location.href = 'report.php'; });
      </script>
    <?php endif; ?>
  </body>
</html>