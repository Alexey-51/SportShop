<?php
session_start();
require_once 'include.php';

// Проверка прав администратора
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Обработка действий с отзывами
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $stmt = $conn->prepare("UPDATE reviews SET status = 'active' WHERE id = ?");
        $stmt->bind_param("i", $_POST['review_id']);
        $stmt->execute();
    } elseif (isset($_POST['hide'])) {
        $stmt = $conn->prepare("UPDATE reviews SET status = 'hidden' WHERE id = ?");
        $stmt->bind_param("i", $_POST['review_id']);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $_POST['review_id']);
        $stmt->execute();
    }
}

// Получение всех отзывов
$reviews = [];
$result = $conn->query("SELECT r.*, u.email FROM reviews r LEFT JOIN users u ON r.user_id = u.id ORDER BY FIELD(r.status, 'pending', 'active', 'hidden'), r.date DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Управление отзывами - SportShop</title>
    <style>
        /* ============= ОСНОВНЫЕ СТИЛИ АДМИНКИ ============= */
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            background: linear-gradient(135deg, #2c3e50, #4a6572);
            color: white;
            padding: 25px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .admin-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .admin-title h1 {
            font-size: 32px;
            color: white;
            margin: 0;
        }

        .admin-actions {
            display: flex;
            gap: 15px;
        }

        .admin-btn {
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .admin-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }

        .admin-btn.logout {
            background-color: #e74c3c;
        }

        .admin-btn.logout:hover {
            background-color: #c0392b;
        }

        /* ============= ТАБЛИЦА ============= */
        .table-wrapper {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        .reviews-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        .reviews-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #dee2e6;
            font-size: 16px;
        }

        .reviews-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
            font-size: 15px;
        }

        .reviews-table tr:hover {
            background-color: #f8f9fa;
        }

        /* Статусы */
        .review-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            min-width: 100px;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-hidden {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Рейтинг звездами */
        .rating-stars {
            color: #FFD700;
            font-size: 18px;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        /* Кнопки действий */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            min-width: 40px;
            text-align: center;
        }

        .action-btn.approve {
            background: #27ae60;
            color: white;
        }

        .action-btn.approve:hover {
            background: #229954;
            transform: translateY(-2px);
        }

        .action-btn.hide {
            background: #f39c12;
            color: white;
        }

        .action-btn.hide:hover {
            background: #d68910;
            transform: translateY(-2px);
        }

        .action-btn.delete {
            background: #e74c3c;
            color: white;
        }

        .action-btn.delete:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* Текст отзыва */
        .review-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #555;
        }

        /* Email */
        .user-email {
            color: #666;
            font-size: 13px;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Пустое состояние */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state h3 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        /* ============= МЕДИА-ЗАПРОСЫ ============= */

        /* Планшеты 992px - 1199px */
        @media (max-width: 1199px) {
            .admin-container {
                padding: 15px;
            }

            .admin-header {
                padding: 20px;
            }

            .admin-title h1 {
                font-size: 28px;
            }

            .admin-btn {
                padding: 10px 20px;
                font-size: 15px;
            }
        }

        /* Планшеты 768px - 991px */
        @media (max-width: 991px) {
            .admin-title {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .admin-btn {
                flex: 1;
                text-align: center;
                max-width: 200px;
            }

            .table-wrapper {
                padding: 15px;
            }

            .reviews-table {
                min-width: 900px;
            }

            .reviews-table th,
            .reviews-table td {
                padding: 12px 10px;
                font-size: 14px;
            }

            .rating-stars {
                font-size: 16px;
            }

            .review-status {
                padding: 4px 8px;
                font-size: 12px;
                min-width: 80px;
            }

            .action-btn {
                padding: 6px 10px;
                font-size: 13px;
                min-width: 35px;
            }
        }

        /* Мобильные 576px - 767px */
        @media (max-width: 767px) {
            .admin-container {
                padding: 10px;
            }

            .admin-header {
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .admin-title h1 {
                font-size: 24px;
            }

            .admin-actions {
                flex-direction: column;
                gap: 10px;
            }

            .admin-btn {
                max-width: 100%;
                width: 100%;
                padding: 12px;
                font-size: 16px;
            }

            .table-wrapper {
                padding: 10px;
                border-radius: 10px;
            }

            .reviews-table {
                min-width: 800px;
            }

            .reviews-table th,
            .reviews-table td {
                padding: 10px 8px;
                font-size: 13px;
            }

            .reviews-table th {
                font-size: 13px;
            }

            .rating-stars {
                font-size: 14px;
                letter-spacing: 1px;
            }

            .review-status {
                padding: 3px 6px;
                font-size: 11px;
                min-width: 70px;
            }

            .action-buttons {
                gap: 4px;
            }

            .action-btn {
                padding: 5px 8px;
                font-size: 12px;
                min-width: 30px;
            }

            .user-email {
                font-size: 12px;
                max-width: 120px;
            }
        }

        /* Маленькие мобильные 480px - 575px */
        @media (max-width: 575px) {
            .admin-title h1 {
                font-size: 22px;
            }

            .table-wrapper {
                padding: 8px;
            }

            .reviews-table {
                min-width: 700px;
            }

            .reviews-table th,
            .reviews-table td {
                padding: 8px 5px;
                font-size: 12px;
            }

            .reviews-table th {
                font-size: 12px;
            }

            .rating-stars {
                font-size: 12px;
            }

            .review-status {
                padding: 2px 4px;
                font-size: 10px;
                min-width: 60px;
            }

            .action-btn {
                padding: 4px 6px;
                font-size: 11px;
                min-width: 28px;
            }

            .user-email {
                font-size: 11px;
                max-width: 100px;
            }

            .review-text {
                max-width: 200px;
                font-size: 11px;
            }
        }

        /* Очень маленькие мобильные до 479px */
        @media (max-width: 479px) {
            .admin-container {
                padding: 5px;
            }

            .admin-header {
                padding: 12px;
            }

            .admin-title h1 {
                font-size: 20px;
            }

            .table-wrapper {
                padding: 5px;
            }

            .reviews-table {
                min-width: 600px;
            }

            .reviews-table th,
            .reviews-table td {
                padding: 6px 4px;
                font-size: 11px;
            }

            .reviews-table th {
                font-size: 11px;
            }

            .rating-stars {
                font-size: 11px;
            }

            .review-status {
                padding: 2px 3px;
                font-size: 9px;
                min-width: 50px;
            }

            .action-btn {
                padding: 3px 4px;
                font-size: 10px;
                min-width: 25px;
            }

            .user-email {
                font-size: 10px;
                max-width: 80px;
            }

            .review-text {
                max-width: 150px;
                font-size: 10px;
            }
        }

        /* Альбомная ориентация на мобильных */
        @media (max-width: 900px) and (orientation: landscape) {
            .admin-container {
                padding: 10px;
            }

            .admin-header {
                padding: 15px;
            }

            .reviews-table {
                min-width: 900px;
            }

            .admin-actions {
                flex-direction: row;
            }

            .admin-btn {
                max-width: 150px;
            }
        }

        /* Высокие разрешения */
        @media (min-width: 1920px) {
            .admin-container {
                max-width: 1600px;
            }

            .admin-title h1 {
                font-size: 36px;
            }

            .admin-btn {
                padding: 15px 30px;
                font-size: 18px;
            }

            .reviews-table th,
            .reviews-table td {
                padding: 20px;
                font-size: 18px;
            }

            .rating-stars {
                font-size: 22px;
            }

            .review-status {
                padding: 8px 15px;
                font-size: 15px;
            }

            .action-btn {
                padding: 10px 15px;
                font-size: 16px;
            }
        }
    </style>
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
                <a href="index.php"><li class="el">На главную</li></a>
                <a href="logout.php"><li class="el">Выйти</li></a>
            </div>
        </div>
    </header>

    <main class="admin-container">
        <div class="admin-header">
            <div class="admin-title">
                <h1>Управление отзывами</h1>
                <div class="admin-actions">
                    <a href="index.php" class="admin-btn">На главную</a>
                    <a href="logout.php" class="admin-btn logout">Выйти</a>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <?php if (empty($reviews)): ?>
                <div class="empty-state">
                    <i>📝</i>
                    <h3>Нет отзывов</h3>
                    <p>Пока нет ни одного отзыва</p>
                </div>
            <?php else: ?>
                <table class="reviews-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Дата</th>
                            <th>Оценка</th>
                            <th>Отзыв</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td>#<?php echo $review['id']; ?></td>
                            <td><?php echo htmlspecialchars($review['name']); ?></td>
                            <td class="user-email"><?php echo htmlspecialchars($review['email'] ?? 'Гость'); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($review['date'])); ?></td>
                            <td>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <?php echo $i < $review['rating'] ? '★' : '☆'; ?>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td class="review-text" title="<?php echo htmlspecialchars($review['text']); ?>">
                                <?php echo htmlspecialchars($review['text']); ?>
                            </td>
                            <td>
                                <span class="review-status status-<?php echo $review['status']; ?>">
                                    <?php 
                                        echo $review['status'] === 'active' ? 'Активен' : 
                                            ($review['status'] === 'pending' ? 'На модерации' : 'Скрыт'); 
                                    ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                        <?php if ($review['status'] !== 'active'): ?>
                                            <button type="submit" name="approve" class="action-btn approve" title="Опубликовать">✓</button>
                                        <?php endif; ?>
                                        <?php if ($review['status'] !== 'hidden'): ?>
                                            <button type="submit" name="hide" class="action-btn hide" title="Скрыть">👁️</button>
                                        <?php endif; ?>
                                        <button type="submit" name="delete" class="action-btn delete" title="Удалить" onclick="return confirm('Удалить отзыв?')">✗</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

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