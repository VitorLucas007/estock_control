<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login - Estoque</title>
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
    <div class="card p-4 shadow-sm text-center" style="width: 400px; border-radius:12px;">
        <h4 class="fw-bold mb-3 text-primary">Sistema Estoque</h4>

        <?php if (isset($erro) && $erro): ?>
            <div class="alert alert-danger py-2 small">Credenciais inválidas!</div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success py-2 small">Cadastro realizado! Entre.</div>
        <?php endif; ?>

        <form action="index.php?route=login" method="POST">
            <input type="email" name="email" class="form-control mb-3" placeholder="E-mail" required>
            <input type="password" name="senha" class="form-control mb-4" placeholder="Senha" required>
            <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>
        </form>
        <a href="index.php?route=cadastrar_admin" class="small text-decoration-none">Criar conta ADM</a>
    </div>
</body>

</html>