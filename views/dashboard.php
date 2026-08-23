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

            <!-- Grupo de botões à direita -->
            <div class="d-flex gap-2">
                <!-- Dropdown de Ordenação -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ordenar por
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= ($_GET['sort'] ?? '') === 'id_desc' ? 'active' : '' ?>" href="index.php?route=dashboard&sort=id_desc">Mais Recentes</a></li>
                        <li><a class="dropdown-item <?= ($_GET['sort'] ?? '') === 'id_asc' ? 'active' : '' ?>" href="index.php?route=dashboard&sort=id_asc">Mais Antigos</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item <?= ($_GET['sort'] ?? '') === 'nome_asc' ? 'active' : '' ?>" href="index.php?route=dashboard&sort=nome_asc">Nome (A-Z)</a></li>
                        <li><a class="dropdown-item <?= ($_GET['sort'] ?? '') === 'nome_desc' ? 'active' : '' ?>" href="index.php?route=dashboard&sort=nome_desc">Nome (Z-A)</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item <?= ($_GET['sort'] ?? '') === 'preco_asc' ? 'active' : '' ?>" href="index.php?route=dashboard&sort=preco_asc">Menor Preço</a></li>
                        <li><a class="dropdown-item <?= ($_GET['sort'] ?? '') === 'preco_desc' ? 'active' : '' ?>" href="index.php?route=dashboard&sort=preco_desc">Maior Preço</a></li>
                    </ul>
                </div>

                <a href="index.php?route=cadastrar_produto" class="btn btn-primary">Novo Produto</a>
            </div>
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
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($produtos)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Nenhum produto cadastrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($produtos as $p): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($p['codigo']) ?></td>
                                    <td>
                                        <!-- Miniatura na tabela -->
                                        <?php if (!empty($p['imagem'])): ?>
                                            <img src="uploads/<?= $p['imagem'] ?>" style="width:30px; height:30px; object-fit:cover" class="rounded me-2">
                                        <?php endif; ?>
                                        <span class="fw-semibold"><?= htmlspecialchars($p['nome']) ?></span>
                                    </td>
                                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                    <td><?= $p['quantidade'] ?> un</td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modal-<?= $p['id'] ?>">
                                            Ver Informações
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Completo de Edição -->
                                <div class="modal fade" id="modal-<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="index.php?route=editar_produto" method="POST" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detalhes do Produto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                    <input type="hidden" name="imagem_antiga" value="<?= htmlspecialchars($p['imagem'] ?? '') ?>">

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Código</label>
                                                            <input type="text" name="codigo" class="form-control" value="<?= htmlspecialchars($p['codigo']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Nome</label>
                                                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($p['nome']) ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Preço (R$)</label>
                                                            <input type="number" step="0.01" name="preco" class="form-control" value="<?= $p['preco'] ?>" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Quantidade</label>
                                                            <input type="number" name="quantidade" class="form-control" value="<?= $p['quantidade'] ?>" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Categoria</label>
                                                            <select name="categoria" class="form-select" required>
                                                                <?php if (!empty($categorias)): ?>
                                                                    <?php foreach ($categorias as $c): ?>
                                                                        <option value="<?= $c['id'] ?>" <?= (isset($p['categoria_id']) && $p['categoria_id'] == $c['id']) ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($c['nome']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <option value="1">Geral</option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Descrição</label>
                                                        <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($p['descricao'] ?? '') ?></textarea>
                                                    </div>

                                                    <!-- VISUALIZAÇÃO DA IMAGEM E UPLOAD -->
                                                    <div class="row bg-light p-3 rounded mb-3 mx-1 border">
                                                        <div class="col-md-4 text-center">
                                                            <label class="form-label fw-bold">Imagem Atual</label><br>
                                                            <?php if (!empty($p['imagem'])): ?>
                                                                <img src="uploads/<?= $p['imagem'] ?>" alt="Imagem do Produto" class="img-thumbnail" style="max-height: 120px; object-fit: contain;">
                                                            <?php else: ?>
                                                                <div class="text-muted small mt-4">Nenhuma imagem.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-md-8 d-flex flex-column justify-content-center">
                                                            <label class="form-label">Trocar Imagem (Opcional)</label>
                                                            <input type="file" name="imagem" class="form-control" accept="image/*">
                                                            <small class="text-muted mt-1">Deixe em branco para manter a imagem atual.</small>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer d-flex justify-content-between">
                                                    <a href="index.php?route=excluir_produto&id=<?= $p['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">
                                                        Excluir do Estoque
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>