<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Modifica Sala: <?= htmlspecialchars($room['name']) ?></h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Sala *</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="<?= htmlspecialchars($_POST['name'] ?? $room['name']) ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacità *</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" required
                                       value="<?= htmlspecialchars($_POST['capacity'] ?? $room['capacity']) ?>"
                                       min="1" max="1000">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? $room['description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="amenities" class="form-label">Servizi e Dotazioni</label>
                        <textarea class="form-control" id="amenities" name="amenities" rows="3"><?= htmlspecialchars($_POST['amenities'] ?? $room['amenities']) ?></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="/rooms/admin.php" class="btn btn-secondary me-md-2">Annulla</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salva Modifiche
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>