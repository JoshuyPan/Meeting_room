<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-gear"></i> Gestione Sale</h2>
    <a href="/rooms/create.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuova Sala
    </a>
</div>

<?php if (empty($rooms)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Nessuna sala configurata.
        <a href="/rooms/create.php" class="alert-link">Crea la prima sala</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Capacità</th>
                    <th>Servizi</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><?= htmlspecialchars($room['name']) ?></td>
                        <td><?= htmlspecialchars($room['description']) ?></td>
                        <td><?= $room['capacity'] ?></td>
                        <td><?= htmlspecialchars($room['amenities']) ?></td>
                        <td>
                            <?php if ($room['is_active']): ?>
                                <span class="badge bg-success">Attiva</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Disattivata</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/rooms/edit.php?id=<?= $room['id'] ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Modifica
                                </a>
                                <?php if ($room['is_active']): ?>
                                    <form method="POST" action="/rooms/delete.php" style="display: inline;">
                                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Sei sicuro di voler disattivare questa sala?')">
                                            <i class="bi bi-trash"></i> Disattiva
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>