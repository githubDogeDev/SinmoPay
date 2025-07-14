// Stara funkcja do przełączania trybu jasnego/ciemnego
// $(document).ready(function() {
//     // Sprawdź preferencje użytkownika z localStorage lub systemu
//     const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
//     const storedTheme = localStorage.getItem('theme');

//     // Ustaw początkowy tryb na podstawie localStorage lub preferencji systemu
//     if (storedTheme === 'dark' || (storedTheme === null && prefersDarkMode)) {
//         $('body').addClass('dark-mode');
//     }

//     // Obsługa kliknięcia przycisku przełączania trybu
//     $('#theme-toggle').on('click', function() {
//         $('body').toggleClass('dark-mode'); // Przełącz klasę 'dark-mode' na body

//         // Zapisz wybór użytkownika w localStorage
//         if ($('body').hasClass('dark-mode')) {
//             localStorage.setItem('theme', 'dark');
//         } else {
//             localStorage.setItem('theme', 'light');
//         }
//         // Opcjonalnie: zmień tekst przycisku
//         $(this).text($('body').hasClass('dark-mode') ? 'Tryb Jasny' : 'Tryb Ciemny');
//     });

//     // Ustaw początkowy tekst przycisku po załadowaniu strony
//     $('#theme-toggle').text($('body').hasClass('dark-mode') ? 'Tryb Jasny' : 'Tryb Ciemny');
// });

$(document).ready(function() {
    const themeToggleBtn = $('#theme-toggle');
    const body = $('body');

    // Sprawdź preferencje motywu z localStorage przy ładowaniu strony
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        body.removeClass('dark-mode light-mode').addClass(savedTheme);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        body.addClass('dark-mode');
        localStorage.setItem('theme', 'dark-mode');
    } else {
        body.addClass('light-mode');
        localStorage.setItem('theme', 'light-mode');
    }

    themeToggleBtn.on('click', function() {
        if (body.hasClass('dark-mode')) {
            body.removeClass('dark-mode').addClass('light-mode');
            localStorage.setItem('theme', 'light-mode');
            // Usunięto linie związane ze zmianą ikon
        } else {
            body.removeClass('light-mode').addClass('dark-mode');
            localStorage.setItem('theme', 'dark-mode');
            // Usunięto linie związane ze zmianą ikon
        }
    });

     // --- NOWA Logika Powiadomień Banerowych ---

    // Funkcja do dynamicznego wyświetlania banera
    function displayNotificationBanner(message, type = 'info', duration = 5000, dismissible = true) {
        if (!message) {
            return; // Nie wyświetlaj, jeśli brak wiadomości
        }

        // Znajdź lub stwórz główny kontener dla wszystkich powiadomień
        let $container = $('.notification-container');
        if ($container.length === 0) {
            $container = $('<div class="notification-container"></div>');
            $('body').append($container);
        }

        // Stwórz element banera
        const $banner = $('<div class="notification-banner"></div>');
        $banner.addClass('notification--' + type); // Dodaj klasę typu (success, error, info, warning)

        // Dodaj treść wiadomości
        const $messageContent = $('<span></span>').html(message);
        $banner.append($messageContent);

        // Dodaj przycisk zamykający, jeśli jest dismissible
        if (dismissible) {
            const $closeBtn = $('<button class="notification__close-btn">&times;</button>'); // &times; to symbol 'x'
            $banner.append($closeBtn);
            $closeBtn.on('click', function() {
                $banner.removeClass('show').slideUp(300, function() {
                    $(this).remove();
                    // Po usunięciu banera, sprawdź czy kontener jest pusty i usuń go
                    if ($container.children().length === 0) {
                        $container.remove();
                    }
                });
            });
        }

        // Dodaj baner do kontenera i pokaż go z animacją
        $container.append($banner);
        // Wywołaj animację po krótkim opóźnieniu, aby CSS transitions zadziałały
        setTimeout(() => {
            $banner.addClass('show');
        }, 10);


        // Automatyczne zamykanie, jeśli duration jest większe od 0
        if (duration > 0) {
            setTimeout(function() {
                $banner.removeClass('show').slideUp(300, function() {
                    $(this).remove();
                    // Po usunięciu banera, sprawdź czy kontener jest pusty i usuń go
                    if ($container.children().length === 0) {
                        $container.remove();
                    }
                });
            }, duration);
        }
    }

    // --- Inicjalizacja powiadomienia z danych serwera (z hidden div) ---
    const $initialNotificationData = $('#initial-notification-data');
    if ($initialNotificationData.length) {
        try {
            // Jawnie odczytujemy wartość atrybutu i parsjemy JSON
            const notificationJsonString = $initialNotificationData.attr('data-notification');
            const notificationData = JSON.parse(notificationJsonString); // Jawne parsowanie JSON

            // Wywołaj funkcję wyświetlającą baner z odczytanymi danymi
            displayNotificationBanner(
                notificationData.message,
                notificationData.type,
                notificationData.duration,
                notificationData.dismissible
            );
        } catch (e) {
            console.error('Błąd parsowania danych powiadomienia:', e); // To właśnie widzisz w konsoli
            displayNotificationBanner('Wystąpił błąd podczas ładowania powiadomienia.', 'error', 7000);
        }
        // Usuń ukryty div po odczytaniu, aby nie "wisiał" w DOM
        $initialNotificationData.remove();
    }

    // --- Dla celów testowych w example_components.php: ---
    // Dodaj globalną dostępność funkcji displayNotificationBanner
    // UWAGA: W środowisku produkcyjnym unika się globalnych funkcji,
    // ale to jest tylko do testowania komponentu.
    window.displayNotificationBanner = displayNotificationBanner;
});




