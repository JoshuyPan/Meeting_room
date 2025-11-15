<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-calendar-plus"></i> Nuova Prenotazione</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="bookingForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="room_id" class="form-label">Sala *</label>
                                <select class="form-select" id="room_id" name="room_id" required>
                                    <option value="">Seleziona una sala</option>
                                    <?php foreach ($rooms as $room): ?>
                                        <option value="<?= $room['id'] ?>" 
                                                <?= (isset($_POST['room_id']) && $_POST['room_id'] == $room['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($room['name']) ?> (Capacità: <?= $room['capacity'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titolo Prenotazione *</label>
                                <input type="text" class="form-control" id="title" name="title" required
                                       value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                                       placeholder="Riunione team, Presentazione, etc.">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Data *</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" required
                                       value="<?= htmlspecialchars($_POST['booking_date'] ?? '') ?>"
                                       min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Ora Inizio *</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required
                                       value="<?= htmlspecialchars($_POST['start_time'] ?? '09:00') ?>"
                                       min="08:00" max="20:00" step="900">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">Ora Fine *</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required
                                       value="<?= htmlspecialchars($_POST['end_time'] ?? '10:00') ?>"
                                       min="08:00" max="21:00" step="900">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="participants" class="form-label">Numero Partecipanti</label>
                                <input type="number" class="form-control" id="participants" name="participants" 
                                       value="<?= htmlspecialchars($_POST['participants'] ?? 1) ?>" min="1" max="100">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Note</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Note aggiuntive..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                    </div>

                    <div class="alert alert-info" id="availabilityAlert" style="display: none;">
                        <i class="bi bi-info-circle"></i> <span id="availabilityMessage"></span>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="/rooms/index.php" class="btn btn-secondary me-md-2">Annulla</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-calendar-check"></i> Crea Prenotazione
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.getElementById('room_id');
    const dateInput = document.getElementById('booking_date');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const availabilityAlert = document.getElementById('availabilityAlert');
    const availabilityMessage = document.getElementById('availabilityMessage');
    const submitBtn = document.getElementById('submitBtn');

    function checkAvailability() {
        const roomId = roomSelect.value;
        const date = dateInput.value;
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;

        if (!roomId || !date || !startTime || !endTime) {
            availabilityAlert.style.display = 'none';
            return;
        }

        availabilityAlert.className = 'alert alert-info';
        availabilityMessage.innerHTML = '<span class="loading"></span> Controllando disponibilità...';
        availabilityAlert.style.display = 'block';
        submitBtn.disabled = true;

        fetch('/bookings/check_availability.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `room_id=${roomId}&date=${date}&start_time=${startTime}&end_time=${endTime}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                availabilityAlert.className = 'alert alert-success';
                availabilityMessage.innerHTML = `<i class="bi bi-check-circle"></i> ${data.message}`;
                submitBtn.disabled = false;
            } else {
                availabilityAlert.className = 'alert alert-danger';
                availabilityMessage.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${data.message}`;
                submitBtn.disabled = true;
            }
        })
        .catch(error => {
            availabilityAlert.className = 'alert alert-warning';
            availabilityMessage.innerHTML = `<i class="bi bi-exclamation-triangle"></i> Errore nel controllo disponibilità`;
            submitBtn.disabled = false;
            console.error('Error:', error);
        });
    }

    roomSelect.addEventListener('change', checkAvailability);
    dateInput.addEventListener('change', checkAvailability);
    startTimeInput.addEventListener('change', checkAvailability);
    endTimeInput.addEventListener('change', checkAvailability);

    <?php if (empty($error)): ?>
        if (roomSelect.value && dateInput.value && startTimeInput.value && endTimeInput.value) {
            checkAvailability();
        }
    <?php endif; ?>

    if (window.history.replaceState && <?= !empty($error) ? 'false' : 'true' ?>) {
        window.history.replaceState(null, null, window.location.href);
    }
});
</script>

<style>
.loading {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 8px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?>