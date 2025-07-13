$(document).ready(function() {
    // Sprawdź preferencje użytkownika z localStorage lub systemu
    const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const storedTheme = localStorage.getItem('theme');

    // Ustaw początkowy tryb na podstawie localStorage lub preferencji systemu
    if (storedTheme === 'dark' || (storedTheme === null && prefersDarkMode)) {
        $('body').addClass('dark-mode');
    }

    // Obsługa kliknięcia przycisku przełączania trybu
    $('#theme-toggle').on('click', function() {
        $('body').toggleClass('dark-mode'); // Przełącz klasę 'dark-mode' na body

        // Zapisz wybór użytkownika w localStorage
        if ($('body').hasClass('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
        // Opcjonalnie: zmień tekst przycisku
        $(this).text($('body').hasClass('dark-mode') ? 'Tryb Jasny' : 'Tryb Ciemny');
    });

    // Ustaw początkowy tekst przycisku po załadowaniu strony
    $('#theme-toggle').text($('body').hasClass('dark-mode') ? 'Tryb Jasny' : 'Tryb Ciemny');
});