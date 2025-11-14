# ISTRUZIONI INSTALLAZIONE

## Prerequisiti
- Docker e Docker Compose
- 2GB di RAM libera
- Porte 8080 e 3306 libere

## Installazione

1. **Clona o scarica il progetto**
   ```bash
   git clone <repository-url>
   cd meeting-room-booking
   ```

2. **Avvia i container Docker**
```bash
    docker compose up -d
```

3. **Attendi l'inizializzazione (2-3 minuti)**
```bash
    # Verifica lo stato
    docker compose ps

    # Controlla i log del database
    docker compose logs db
```

4. **Accedi all'applicazione**
    URL: http://localhost:8080

    Account admin predefinito:

        Email: admin@example.com

        Password: admin123

## Struttura del Progetto

meeting-room-booking/
├── docker-compose.yml      # Configurazione Docker
├── nginx/                  # Configurazione web server
├── php/                    # Configurazione PHP
├── mysql/                  # Script inizializzazione DB
├── src/                    # Codice sorgente
│   ├── controllers/        # Controller MVC
│   ├── models/            # Modelli dati
│   ├── views/             # Template views
│   ├── utils/             # Utility classes
│   └── assets/            CSS/JS
└── docs/                  # Documentazione

## Testare

```bash
    # Test database
    curl http://localhost:8080/tests/test_database.php

    # Test autenticazione  
    curl http://localhost:8080/tests/test_auth.php
```