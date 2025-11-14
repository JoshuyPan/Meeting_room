<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 class="mb-4"><i class="bi bi-list-check"></i> Tutte le Prenotazioni</h2>

<?php if (empty($bookings)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Nessuna prenotazione trovata.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Utente</th>
                    <th>Sala</th>
                    <th>Titolo</th>
                    <th>Data</th>
                    <th>Orario</th>
                    <th>Partecipanti</th>
                    <th>Stato</th>
                    <th>Data Creazione</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['user_name']) ?></td>
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
                        <td><?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>