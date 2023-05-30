document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('nav ul').classList.toggle('show');
});

document.querySelector('.dark-mode-toggle').addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
});
