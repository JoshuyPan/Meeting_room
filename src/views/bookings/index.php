<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-check"></i> Le Mie Prenotazioni</h2>
    <a href="/bookings/create.php" class="btn btn-primary">
        <i class="bi bi-calendar-plus"></i> Nuova Prenotazione
    </a>
</div>

<?php if (empty($bookings)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Non hai ancora effettuato nessuna prenotazione.
        <a href="/bookings/create.php" class="alert-link">Crea la tua prima prenotazione</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sala</th>
                    <th>Titolo</th>
                    <th>Data</th>
                    <th>Orario</th>
                    <th>Partecipanti</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['room_name']) ?></td>
                        <td><?= htmlspecialchars($booking['title']) ?></td>
                        <td><?= date('d/m/Y', strtotime($booking['booking_date'])) ?></td>
                        <td><?= date('H:i', strtotime($booking['start_time'])) ?> - <?= date('H:i', strtotime($booking['end_time'])) ?></td>
                        <td><?= $booking['participants'] ?></td>
                        <td>
                            <?php if ($booking['status'] === 'confirmed'): ?>
                                <span class="badge bg-success">Confermata</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Cancellata</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($booking['status'] === 'confirmed'): ?>
                                <form method="POST" action="/bookings/cancel.php" style="display: inline;">
                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Sei sicuro di voler cancellare questa prenotazione?')">
                                        <i class="bi bi-x-circle"></i> Cancella
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>