<?php
require_once __DIR__ . '/utils/Auth.php';

$auth = new Auth();
$currentUser = $auth->getCurrentUser();

include __DIR__ . '/views/layout/header.php';
?>

<div class="jumbotron bg-light p-5 rounded">
    <h1 class="display-4"><i class="bi bi-calendar-event"></i> Sistema Prenotazione Sale</h1>
    <p class="lead">Gestisci le prenotazioni delle sale riunioni in modo semplice ed efficiente.</p>
    
    <?php if ($auth->isLoggedIn()): ?>
        <hr class="my-4">
        <p>Benvenuto, <strong><?= htmlspecialchars($currentUser['name']) ?></strong>!</p>
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-door-closed display-4 text-primary"></i>
                        <h5>Visualizza Sale</h5>
                        <p>Consulta le sale disponibili</p>
                        <a href="/rooms/index.php" class="btn btn-primary">Vedi Sale</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-calendar-plus display-4 text-success"></i>
                        <h5>Nuova Prenotazione</h5>
                        <p>Prenota una sala</p>
                        <a href="/bookings/create.php" class="btn btn-success">Prenota</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-calendar-check display-4 text-info"></i>
                        <h5>Le Mie Prenotazioni</h5>
                        <p>Gestisci le tue prenotazioni</p>
                        <a href="/bookings/index.php" class="btn btn-info">Vedi Prenotazioni</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <hr class="my-4">
        <p>Accedi o registrati per iniziare a prenotare le sale.</p>
        <a class="btn btn-primary btn-lg me-2" href="/auth/login.php" role="button">
            <i class="bi bi-box-arrow-in-right"></i> Accedi
        </a>
        <a class="btn btn-outline-secondary btn-lg" href="/auth/register.php" role="button">
            <i class="bi bi-person-plus"></i> Registrati
        </a>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/views/layout/footer.php'; ?>