<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Фитнес-блог SportShop. Полезные статьи о тренировках, спортивном питании, здоровом образе жизни, витаминах и восстановлении после нагрузок.">
    <link rel="stylesheet" href="./css/style.css">
    <title>Блог - SportShop</title>
    <style>
        /* Доп стили для блога */
        .blog-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .blog-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .blog-row .blogs {
            width: calc(33.333% - 20px);
            min-width: 300px;
            flex: 1 1 300px;
        }
        
        @media (max-width: 768px) {
            .blog-row .blogs {
                width: 100%;
                max-width: 500px;
            }
            .info_blog p {
                display: none;
            }
        }

         @media (max-width: 480px) {
            .info_blog h1 {
                font-size: 44px;
                margin-bottom: 200px;
            }
}
    </style>
</head>

<body>
    <header class="header">
        <div class="header_container">
            <a href="./index.php"><img src="./img/logo.png" class="header_logo" alt="SportPit Logo"></a>
            <p>SportShop</p>
            
            
            <div class="burger" id="burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            
            <div class="header-list" id="header-list">
                <a href="tovar.php">
                    <li class="el">Каталог</li>
                </a>
                <a href="order.php">
                    <li class="el">Производство</li>
                </a>
                <a href="blog.php">
                    <li class="el">Блог</li>
                </a>
                <a href="login.php">
                    <li class="el">Вход/Регистрация</li>
                </a>
            </div>
        </div>
    </header> 
    
    <div class="main">
        <div class="container">
            <img src="./img/blog.jpg" alt="Фитнес блог">
        </div>
        <div class="info_blog">
            <h1>Фитнес блог SportShop</h1>
            <p>Интересные и полезные материалы о тренировках,<br>
               спортивном питании и здоровом образе жизни</p>
        </div>
    </div>
    
    <h4>Последние статьи</h4>
    
    <div class="blog-container">
        <!-- Первая строка - 3 карточки -->
        <div class="blog-row">
            <div class="blogs">
                <img src="./img/blog1.jpg" alt="Низкоуглеводные диеты">
                <p class="blog_p1">Низкоуглеводные диеты и здоровье костей</p>
                <p class="blog_p2">Диеты с низким содержанием углеводов и высоким содержанием жиров могут негативно влиять на костную ткань.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">29.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog2.webp" alt="Витамины D и Е">
                <p class="blog_p1">Комбинация витаминов D и Е помогают избавиться от экземы</p>
                <p class="blog_p2">Узнайте, как добавки витамина D и витамина Е могут уменьшить симптомы экземы на 64%. Эта комбинация значительно эффективнее в лечении экземы.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">29.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog3.jpg" alt="Вечерние тренировки">
                <p class="blog_p1">Вечерние тренировки снижают риск заболеваний сердца</p>
                <p class="blog_p2">Вечерние тренировки снижают риск сердечных заболеваний и диабета. Результаты показывают, что вечерняя активность наиболее полезна для здоровья.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">28.11.2024</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Вторая строка - 3 карточки -->
        <div class="blog-row">
            <div class="blogs">
                <img src="./img/blog4.webp" alt="Цинк при COVID-19">
                <p class="blog_p1">Противовирусный эффект цинка при COVID-19</p>
                <p class="blog_p2">Низкий уровень цинка увеличит вероятность тяжёлого течения болезни COVID-19. Результаты свидетельствуют о важности учёта концентрации цинка в крови.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">27.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog5.jpg" alt="Дроп-сеты">
                <p class="blog_p1">Влияние дроп-сетов на гипертрофию скелетных мышц</p>
                <p class="blog_p2">Узнайте, как дроп-сеты могут помочь вам быстрее нарастить массу при мышечной гипертрофии и сократить время тренировок.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">27.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog6.webp" alt="Кето-диета">
                <p class="blog_p1">Кето-диета для улучшения психического здоровья</p>
                <p class="blog_p2">Узнайте, как кето-диета помогает улучшить психическое состояние пациентов с биполярным расстройством и шизофренией, снижая симптомы депрессии.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">26.11.2024</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Третья строка - 3 карточки -->
        <div class="blog-row">
            <div class="blogs">
                <img src="./img/blog7.webp" alt="Витамин С">
                <p class="blog_p1">Эффективность витамина С в заживлении манжеты плеча</p>
                <p class="blog_p2">Витамин С способствует лучшему заживлению поврежденной ткани после операции на плече. Читайте результаты исследования из Европейского журнала.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">26.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog8.jpg" alt="L-карнитин">
                <p class="blog_p1">Эффективность L-карнитина при нейро заболеваниях</p>
                <p class="blog_p2">Может ли добавка L-карнитина улучшить когнитивные функции при нейродегенеративных заболеваниях? Читайте результаты исследований.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">25.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog9.webp" alt="Коэнзим Q10">
                <p class="blog_p1">Добавка Q10 повышает чувствительность к инсулину</p>
                <p class="blog_p2">Узнайте, как добавки коэнзима Q10 улучшают чувствительность клеток к инсулину и помогают в контроле уровня сахара в крови.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">25.11.2024</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Четвертая строка - 3 карточки -->
        <div class="blog-row">
            <div class="blogs">
                <img src="./img/blog10.webp" alt="Таурин">
                <p class="blog_p1">Может ли таурин защитить наш мозг от алкоголя?</p>
                <p class="blog_p2">Исследование 2024 года показывает, что таурин помогает предотвратить гибель нейронов в мозге при употреблении алкоголя. Узнайте, как это возможно.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">23.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog11.webp" alt="Омега-3">
                <p class="blog_p1">Дефицит омега-3 затрудняет мыслительный процесс веганов</p>
                <p class="blog_p2">Узнайте, как дефицит омега-3 жирных кислот может повлиять на мыслительные процессы у веганов и вегетарианцев.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">23.11.2024</p>
                    </div>
                </div>
            </div>
            
            <div class="blogs">
                <img src="./img/blog12.webp" alt="Интервальное голодание">
                <p class="blog_p1">Влияет ли интервальное голодание на здоровье костей?</p>
                <p class="blog_p2">Интервальное голодание не оказывает негативного влияния на плотность костной массы, утверждают испанские ученые.</p>
                <div class="kevin">
                    <img src="./img/kevin.jpg" alt="Кевин Левроне">
                    <div class="kevin_p">
                        <p id="name">Кевин Левроне</p>
                        <p id="data">22.11.2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <div class="footer_container">
            <a href="./index.html"><img src="./img/logo.png" class="header_logo" alt="SportPit Logo"></a>
            <p>SportShop</p>
            <div class="footer-list">
                <li class="el_f">E-mail: SportShop62@gmail.com</li>
                <li class="el_f">Телефон: 8 (4912) 110-203</li>
            </div>
            <div class="imgg">
                
                <a href="#"><img src="./img/insta.png" class="messend" alt="Instagram"></a>
                <a href="#"><img src="./img/tg.png" class="messend" alt="Telegram"></a>
            </div>
        </div>
    </footer>
    
    <script src="js/burger.js"></script>
</body>
</html>