<?php
session_start();
require_once 'include.php';

// Если уже авторизован, редирект на главную
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Неверный пароль';
        }
    } else {
        $error = 'Пользователь не найден';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Вход в личный кабинет SportShop. Авторизуйтесь, чтобы отслеживать заказы, оставлять отзывы и пользоваться всеми преимуществами магазина.">
    <link rel="stylesheet" href="./css/style.css">
    <title>Вход - SportShop</title>
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
                <a href="login.php"><li class="el">Вход/Регистрация</li></a>
            </div>
        </div>
    </header>

    <div class="auth-container">
        <div class="auth-form">
            <h4 style="margin: 0 0 30px;">Вход</h4>
            
            <?php if ($error): ?>
                <div style="color: red; text-align: center; margin-bottom: 20px; font-size: 18px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="poles">
                    <input type="email" name="email" class="pole" placeholder="E-mail" required>
                    <input type="password" name="password" class="pole" placeholder="Пароль" required>
                </div>
                <div class="knp">
                    <button type="submit" class="button_login">Войти</button>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="register.php" style="color: #9e958a;">Нет аккаунта? Зарегистрируйтесь</a>
                </div>
            </form>
        </div>
    </div>

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