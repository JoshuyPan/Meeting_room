# ISTRUZIONI INSTALLAZIONE

## Prerequisiti
- Docker e Docker Compose
- 2GB di RAM libera
- Porte 8080 e 3306 libere

## Installazione

1. **Clona o scarica il progetto**
   ```bash
   git clone https://github.com/JoshuyPan/Meeting_room.git
   cd meeting-room-booking
   ```

2. **Avvia i container Docker**
```bash
    docker compose up -d
```

3. **Attendi l'inizializzazione (1-2 minuti)**
```bash
    docker compose ps
    docker compose logs db
```

4. **Accedi all'applicazione**

-> URL: http://localhost:8080

    Account admin predefinito:

        Email: admin@example.com

        Password: admin123

## Testare

```bash
    # Test database
    curl http://localhost:8080/tests/test_database.php

    # Test autenticazione  
    curl http://localhost:8080/tests/test_auth.php
```