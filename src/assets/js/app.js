class BookingSystem {
    constructor() {
        this.init();
    }

    init() {
        this.initDatePickers();
        this.initTimeValidation();
        this.initAutoLogout();
    }

    initDatePickers() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.min = new Date().toISOString().split('T')[0];

            input.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    this.setCustomValidity('Non puoi selezionare una data passata');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    }

    initTimeValidation() {
        const startTimeInputs = document.querySelectorAll('input[name="start_time"]');
        const endTimeInputs = document.querySelectorAll('input[name="end_time"]');

        startTimeInputs.forEach((startInput, index) => {
            const endInput = endTimeInputs[index];
            
            startInput.addEventListener('change', () => this.validateTimeRange(startInput, endInput));
            endInput.addEventListener('change', () => this.validateTimeRange(startInput, endInput));
        });
    }

    validateTimeRange(startInput, endInput) {
        const startTime = startInput.value;
        const endTime = endInput.value;

        if (startTime && endTime) {
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(`2000-01-01T${endTime}`);

            if (end <= start) {
                endInput.setCustomValidity('L\'orario di fine deve essere successivo all\'orario di inizio');
            } else {
                endInput.setCustomValidity('');
            }

            const diffMinutes = (end - start) / (1000 * 60);
            if (diffMinutes < 15) {
                endInput.setCustomValidity('La prenotazione deve essere di almeno 15 minuti');
            } else {
                endInput.setCustomValidity('');
            }
        }
    }

    initAutoLogout() {
        let timeout;
        const logoutTime = 60 * 60 * 1000; 

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (confirm('Sei stato inattivo per un po\'. Vuoi mantenere la sessione attiva?')) {
                    resetTimer();
                } else {
                    window.location.href = '/auth/logout.php';
                }
            }, logoutTime);
        }

        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetTimer, false);
        });

        resetTimer();
    }

    async checkAvailability(roomId, date, startTime, endTime) {
        try {
            const response = await fetch('/bookings/check_availability.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `room_id=${roomId}&date=${date}&start_time=${startTime}&end_time=${endTime}`
            });

            return await response.json();
        } catch (error) {
            console.error('Errore nel controllo disponibilità:', error);
            return { available: false, message: 'Errore di connessione' };
        }
    }

    showNotification(message, type = 'info') {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    window.bookingApp = new BookingSystem();
});

function formatDate(dateString) {
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return new Date(dateString).toLocaleDateString('it-IT', options);
}

function formatTime(timeString) {
    return timeString.substring(0, 5); 
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}