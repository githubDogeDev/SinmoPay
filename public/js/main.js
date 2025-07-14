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

    // --- Funkcja do wyświetlania pop-upów z wiadomościami ---
    function displayMessagePopup(message, type) {
        if (!message || !type) {
            return;
        }

        const $overlay = $('<div class="popup-overlay"></div>');
        const $messageBox = $('<div class="popup-message"></div>');
        $messageBox.addClass('popup--' + type);
        $messageBox.html(message); // Używamy .html(), bo PHP używa htmlspecialchars

        $overlay.append($messageBox);
        $('body').append($overlay);

        $overlay.hide().fadeIn(300);

        $overlay.on('click', function(e) {
            if ($(e.target).is($overlay)) {
                $overlay.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });

        setTimeout(function() {
            $overlay.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000); // 5 sekund
    }

    // --- Inicjalizacja pop-upu przy ładowaniu strony ---
    const $serverMessageInput = $('#server-message');
    if ($serverMessageInput.length) {
        const message = $serverMessageInput.data('message');
        const type = $serverMessageInput.data('type');
        displayMessagePopup(message, type);
        $serverMessageInput.remove(); // Usuń ukryty input po odczytaniu
    }
});




