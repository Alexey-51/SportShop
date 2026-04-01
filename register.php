<?php
session_start();
require_once 'include.php';

// Если уже авторизован, редирект на главную
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Заполните все поля';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен быть не менее 6 символов';
    } else {
        // Проверка существования email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Пользователь с таким email уже существует';
        } else {
            // Регистрация
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $registered = date('Y-m-d');
            
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, registered) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed, $registered);
            
            if ($stmt->execute()) {
                $success = 'Регистрация успешна! Теперь вы можете войти.';
            } else {
                $error = 'Ошибка при регистрации';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Создайте аккаунт в SportShop и получайте доступ к личному кабинету, отзывам и специальным предложениям.">
    <link rel="stylesheet" href="./css/style.css">
    <title>Регистрация - SportShop</title>
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
            <h4 style="margin: 0 0 30px;">Регистрация</h4>
            
            <?php if ($error): ?>
                <div style="color: red; text-align: center; margin-bottom: 20px; font-size: 18px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div style="color: green; text-align: center; margin-bottom: 20px; font-size: 18px;">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="poles">
                    <input type="text" name="name" class="pole" placeholder="Имя" required>
                    <input type="email" name="email" class="pole" placeholder="E-mail" required>
                    <input type="password" name="password" class="pole" placeholder="Пароль" required>
                    <input type="password" name="confirm_password" class="pole" placeholder="Подтвердите пароль" required>
                </div>
                <div class="knp">
                    <button type="submit" class="button_register">Зарегистрироваться</button>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="login.php" style="color: #9e958a;">Уже есть аккаунт? Войдите</a>
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