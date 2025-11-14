<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-person-plus"></i> Registrati al Sistema</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <form method="POST" id="registerForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                               placeholder="Inserisci il tuo nome e cognome">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               placeholder="esempio@email.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" required
                               minlength="6"
                               placeholder="Almeno 6 caratteri">
                        <div class="form-text">La password deve essere di almeno 6 caratteri.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Conferma Password *</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                               placeholder="Reinserisci la password">
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Registrati
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <p>Hai già un account? <a href="/auth/login.php">Accedi qui</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    form.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Le password non coincidono!');
            confirmPassword.focus();
        }
        
        if (password.value.length < 6) {
            e.preventDefault();
            alert('La password deve essere di almeno 6 caratteri!');
            password.focus();
        }
    });
    
    // Validazione in tempo reale
    confirmPassword.addEventListener('input', function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Le password non coincidono');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>