<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4 p-3">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand fw-bold" href="index.php?route=dashboard">StockControl</a>
            <a href="index.php?route=dashboard" class="text-light text-decoration-none">Voltar ao Dashboard</a>
        </div>
    </nav>

    <div class="container mb-5" style="max-width: 800px;">
        <h3 class="mb-4">Cadastrar Novo Produto</h3>
        <div class="card shadow-sm border-0 p-4">
            <form action="index.php?route=cadastrar_produto" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Código / SKU</label>
                        <input type="text" name="codigo" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Categoria</label>
                        <!-- O name deve ser categoria_id para bater com o seu ProdutoModel -->
                        <select name="categoria_id" class="form-select" required>
                            <option value="" disabled selected>Selecione uma categoria...</option>

                            <?php foreach (($categorias ?? []) as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantidade</label>
                        <input type="number" name="quantidade" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Imagem (opcional)</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <a href="index.php?route=dashboard" class="btn btn-light me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar Produto</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>