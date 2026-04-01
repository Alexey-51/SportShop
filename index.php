<?php
session_start();
require_once 'include.php';

// Получаем активные отзывы
$reviews = [];
$result = $conn->query("SELECT * FROM reviews WHERE status = 'active' ORDER BY date DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Обработка добавления отзыва
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_review'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    
    $name = $_SESSION['user_name'];
    $rating = (int)$_POST['rating'];
    $text = trim($_POST['text']);
    $date = date('Y-m-d');
    
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, name, date, rating, text, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issis", $_SESSION['user_id'], $name, $date, $rating, $text);
    $stmt->execute();
    
    $message = 'Отзыв отправлен на модерацию!';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SportShop — интернет-магазин спортивных товаров и питания. Широкий ассортимент, выгодные цены и быстрая доставка.">
    <link rel="stylesheet" href="./css/style.css">
    <title>SportShop - Спортивные товары</title>
</head>
<body>
    <header class="header">
        <div class="header_container">
            <a href="./index.php"><img src="./img/logo.png" class="header_logo" alt=""></a>
            <p>SportShop</p>
            <div class="burger" id="burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="header-list" id="header-list">
                <a href="tovar.php"><li class="el">Каталог</li></a>
                <a href="order.php"><li class="el">Производство</li></a>
                <a href="blog.php"><li class="el">Блог</li></a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php"><li class="el">Выйти (<?php echo $_SESSION['user_name']; ?>)</li></a>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin.php"><li class="el">Админ панель</li></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="login.php"><li class="el">Вход/Регистрация</li></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="menu-overlay" id="menuOverlay"></div>
    </header>

    <div class="main">
        <div class="container">
            <img src="./img/gym.jpg" alt="">
            <div class="info">
                <h1>Только лучшее качество!</h1>
                <p>Тысячи покупок и положительных отзывов о наших товарах</p>
                <a href="./tovar.php"><button class="button">Перейти к товарам</button></a>
            </div>
        </div>
    </div>

    <h3>Почему именно наша продукция?</h3>
    <div class="diff">
        <div class="text">
            <p>В нашем магазине всегда лучшее качество и приятные цены. Покупая нашу продукцию не стоит бояться за её состав, так как он проходит несколько этапов проверок.</p>
        </div>
    </div>

    <hr>

    <h3>Покупайте больше за меньшие деньги!</h3>
    <div class="index-cards">
        <div class="index-card">
            <img src="./img/gantel.png" alt="">
            <p class="inf">Покупай все сразу!</p>
            <p class="inf1">При покупке 3-х товаров 4-ий в подарок.</p>
            <a href="tovar.php"><button class="btn">Перейти к товарам</button></a>
        </div>
        <div class="index-card">
            <img src="./img/card2.jpg" alt="">
            <p class="inf">Оплачивай нашей картой</p>
            <p class="inf1">Оплачивайте товар картой SportPit и копите баллы.</p>
            <a href="tovar.php"><button class="btn">Перейти к товарам</button></a>
        </div>
        <div class="index-card">
            <img src="./img/gyra.png" alt="">
            <p class="inf">Шейкер в подарок</p>
            <p class="inf1">При покупке от 2500р шейкер в подарок.</p>
            <a href="tovar.php"><button class="btn">Перейти к товарам</button></a>
        </div>
    </div>

    <h3>Отзывы наших посетителей</h3>
    
    <?php if (isset($message)): ?>
        <div style="text-align: center; color: green; font-size: 20px; margin: 20px 0;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Форма добавления отзыва (только для авторизованных) -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div style="max-width: 800px; margin: 0 auto 40px; padding: 30px; background: white; border-radius: 20px; border: 2px solid #DCDCDC;">
        <h4 style="margin: 0 0 20px; font-size: 32px;">Оставить отзыв</h4>
        <form method="POST">
            <input type="hidden" name="add_review" value="1">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 20px; margin-bottom: 10px;">Оценка:</label>
                <select name="rating" required style="width: 200px; padding: 15px; font-size: 18px; border-radius: 10px; border: 1px solid #ddd;">
                    <option value="5">★★★★★ (5)</option>
                    <option value="4">★★★★☆ (4)</option>
                    <option value="3">★★★☆☆ (3)</option>
                    <option value="2">★★☆☆☆ (2)</option>
                    <option value="1">★☆☆☆☆ (1)</option>
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 20px; margin-bottom: 10px;">Ваш отзыв:</label>
                <textarea name="text" required style="width: 100%; padding: 15px; font-size: 18px; border-radius: 10px; border: 1px solid #ddd; min-height: 150px;" placeholder="Напишите ваш отзыв..."></textarea>
            </div>
            <button type="submit" style="background: #9e958a; color: white; font-size: 20px; padding: 15px 40px; border: none; border-radius: 10px; cursor: pointer;">Отправить отзыв</button>
        </form>
    </div>
    <?php else: ?>
    <div style="text-align: center; margin: 30px 0; font-size: 20px;">
        <p>Чтобы оставить отзыв, <a href="login.php" style="color: #9e958a;">войдите</a> или <a href="register.php" style="color: #9e958a;">зарегистрируйтесь</a></p>
    </div>
    <?php endif; ?>

    <!-- Отображение отзывов -->
    <?php for ($i = 0; $i < count($reviews); $i += 2): ?>
    <div class="otzyv">
        <?php for ($j = $i; $j < min($i + 2, count($reviews)); $j++): ?>
        <div class="otzyvs">
            <div class="stars">
                <p class="p1"><?php echo htmlspecialchars($reviews[$j]['name']); ?></p>
                <div class="star">
                    <?php for ($k = 0; $k < 5; $k++): ?>
                        <?php echo $k < $reviews[$j]['rating'] ? '★' : '☆'; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <p class="p2"><?php echo date('d.m.Y', strtotime($reviews[$j]['date'])); ?></p>
            <p class="p3"><?php echo htmlspecialchars($reviews[$j]['text']); ?></p>
        </div>
        <?php endfor; ?>
    </div>
    <?php endfor; ?>

    <footer class="footer">
        <div class="footer_container">
            <a href="./index.php"><img src="./img/logo.png" class="header_logo" alt=""></a>
            <p>SportShop</p>
            <div class="footer-list">
                <li class="el_f">E-mail: SportShop62@gmail.com</li>
                <li class="el_f">Телефон: 8 (4912) 110-203</li>
            </div>
            <div class="imgg">
                <a href="./index.php"><img src="./img/croissant.png" class="logo_header__logo" alt=""></a>
                <a href="#"><img src="./img/insta.png" class="messend" alt=""></a>
                <a href="#"><img src="./img/tg.png" class="messend" alt=""></a>
            </div>
        </div>
    </footer>

    <script src="js/burger.js"></script>
</body>
</html>