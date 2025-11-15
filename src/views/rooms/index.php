<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-xl-4">
    <h2><i class="bi bi-door-closed"></i> Sale Disponibili</h2>
    <?php if ($auth->isAdmin()): ?>
        <a href="/rooms/admin.php" class="btn btn-outline-primary">
            <i class="bi bi-gear"></i> Gestione Sale
        </a>
    <?php endif; ?>
</div>
<div class="row">
    <?php if (empty($rooms)): ?>
        <div class="col-12">
            <div class="alert alert-info">Nessuna sala disponibile al momento.</div>
        </div>
    <?php else: ?>
        <?php foreach ($rooms as $room): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card room-card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0 text-center"><?= htmlspecialchars($room['name']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($room['description']) ?></p>
                        <ul class="list-unstyled">
                            <li><strong>Capacità:</strong> <?= $room['capacity'] ?> persone</li>
                            <li><strong>Servizi:</strong> <?= htmlspecialchars($room['amenities']) ?></li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/bookings/create.php?room_id=<?= $room['id'] ?>" 
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-calendar-plus"></i> Prenota
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>