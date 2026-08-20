<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4 p-3">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand fw-bold" href="index.php?route=dashboard">StockControl</a>
            <div class="text-light">
                Olá, <?= htmlspecialchars($_SESSION['user_nome'] ?? 'Admin') ?> |
                <a href="index.php?route=logout" class="text-danger text-decoration-none ms-2">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Visão Geral</h3>
            <a href="index.php?route=cadastrar_produto" class="btn btn-primary">Novo Produto</a>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-0 border-start border-primary border-4">
                    <h6 class="text-muted text-uppercase small">Itens Distintos</h6>
                    <h2 class="fw-bold"><?= $metricas['total_itens'] ?? 0 ?></h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-0 border-start border-success border-4">
                    <h6 class="text-muted text-uppercase small">Total de Produtos (Qtd)</h6>
                    <h2 class="fw-bold text-success"><?= $metricas['total_estoque'] ?? 0 ?></h2>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($produtos)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Nenhum produto cadastrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($produtos as $p): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($p['codigo']) ?></td>
                                    <td>
                                        <?php if ($p['imagem']): ?>
                                            <img src="uploads/<?= $p['imagem'] ?>" style="width:30px; height:30px; object-fit:cover" class="rounded me-2">
                                        <?php endif; ?>
                                        <span class="fw-semibold"><?= htmlspecialchars($p['nome']) ?></span>
                                    </td>
                                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                    <td><?= $p['quantidade'] ?> un</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>