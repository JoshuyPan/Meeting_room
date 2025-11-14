# DOCUMENTO FUNZIONALE - GESTIONE PRENOTAZIONI MEETING ROOM

## 1. SCOPO DEL SISTEMA
Sistema web per la gestione delle prenotazioni delle sale riunioni in un'azienda.

## 2. ATTORI DEL SISTEMA
- **Amministratore (Admin)**: Gestisce tutto il sistema
- **Utente Registrato**: Può prenotare le sale
- **Utente Non Registrato**: Può solo visualizzare le sale (senza prenotare)

## 3. REQUISITI FUNZIONALI

### 3.1 Gestione Autenticazione
- RF01: Registrazione nuovo utente
- RF02: Login utente esistente
- RF03: Logout
- RF04: Distinzione tra admin e utente normale

### 3.2 Gestione Sale (Solo Admin)
- RF05: Creazione nuova sala
- RF06: Modifica sala esistente
- RF07: Cancellazione sala (soft delete)
- RF08: Visualizzazione lista sale

### 3.3 Gestione Prenotazioni
- RF09: Prenotazione sala (utenti registrati)
- RF10: Visualizzazione prenotazioni personali
- RF11: Cancellazione prenotazione
- RF12: Controllo conflitti di prenotazione

### 3.4 Funzionalità Admin
- RF13: Visualizzazione tutte le prenotazioni
- RF14: Gestione completa sale

## 4. SCENARI D'USO DETTAGLIATI

### Scenario 1: Registrazione Utente
1. Utente clicca "Registrati"
2. Inserisce: Nome, Email, Password
3. Sistema verifica email unica
4. Sistema crea account con ruolo "user"
5. Reindirizzamento alla homepage

### Scenario 2: Prenotazione Sala
1. Utente loggato visualizza lista sale
2. Clicca "Prenota" su una sala
3. Inserisce: Data, Ora inizio, Ora fine, Titolo, Partecipanti
4. Sistema verifica disponibilità
5. Se disponibile, crea prenotazione
6. Se non disponibile, mostra errore

### Scenario 3: Gestione Sale (Admin)
1. Admin loggato visualizza lista sale
2. Clicca "Aggiungi Sala"
3. Inserisce: Nome, Descrizione, Capacità, Servizi
4. Sistema crea sala
5. Admin può modificare o disattivare sale esistenti