<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="card p-4 shadow-sm" style="width: 400px; border-radius:12px;">
        <h4 class="text-center fw-bold mb-3">Novo Admin</h4>

        <?php if (!empty($mensagemErro)): ?>
            <div class="alert alert-danger py-2 small"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>

        <form action="index.php?route=cadastrar_admin" method="POST">
            <div class="mb-3"><input type="text" name="nome" class="form-control" placeholder="Nome Completo" required></div>
            <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="E-mail" required></div>
            <div class="mb-3"><input type="password" name="senha" class="form-control" placeholder="Senha" required></div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Cadastrar</button>
            <div class="text-center"><a href="index.php?route=login" class="text-secondary small">Voltar para Login</a></div>
        </form>
    </div>
</body>

</html> 