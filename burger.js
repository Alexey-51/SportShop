// burger.js
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burger');
    const menu = document.getElementById('header-list');
    const overlay = document.createElement('div');
    
    // Создаем оверлей
    overlay.className = 'menu-overlay';
    document.body.appendChild(overlay);
    
    // Функция открытия/закрытия меню
    function toggleMenu() {
        burger.classList.toggle('active');
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }
    
    // Открытие/закрытие по клику на бургер
    if (burger) {
        burger.addEventListener('click', toggleMenu);
    }
    
    // Закрытие по клику на оверлей
    overlay.addEventListener('click', toggleMenu);
    
    // Закрытие по клику на ссылку в меню
    const menuLinks = menu ? menu.querySelectorAll('a') : [];
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (menu.classList.contains('active')) {
                toggleMenu();
            }
        });
    });
    
    // Закрытие при изменении размера экрана (если стали больше 768px)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            if (menu && menu.classList.contains('active')) {
                burger.classList.remove('active');
                menu.classList.remove('active');
                overlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        }
    });
});