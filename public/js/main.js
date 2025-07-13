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

// public/js/main.js

// public/js/main.js

// public/js/main.js

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

    // Inne skrypty, jeśli masz
});