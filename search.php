<?php
// Подключение к базе данных
$servername = "localhost"; // Имя сервера
$username = "root";        // Имя пользователя БД
$password = "";            // Пароль пользователя БД
$dbname = "books";       // Имя базы данных

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем параметр поиска из формы
    $search = $conn->real_escape_string($_POST['search']);

    // SQL-запрос для поиска книги
    $sql = "SELECT * FROM Книги WHERE Наименование LIKE '%$search%' OR Автор LIKE '%$search%' OR Жанр LIKE '%$search%' OR Год_издания LIKE '%$search%' OR Издательство LIKE '%$search%'";
    $result = $conn->query($sql);

    // Проверяем, есть ли результаты
    if ($result->num_rows > 0) {
        echo "<style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Высота экрана */
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Цвет фона */
        }
        .container {
            text-align: center;
            background-color: white; /* Цвет фона контейнера */
            padding: 20px;
            border-radius: 8px; /* Скругление углов */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Тень */
        }
        table {
            margin: 20px auto; /* Центрирование таблицы */
            border-collapse: collapse; /* Убирает двойные границы */
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd; /* Цвет границы */
        }
        th {
            background-color: #f2f2f2; /* Цвет фона заголовков */
        }
    </style>";

echo "<div class='container'>";
echo "<h2>Результаты поиска:</h2>";
echo "<table>
        <tr>
            <th>Номер</th>
            <th>Наименование</th>
            <th>Автор</th>
            <th>Жанр</th>
            <th>Год издания</th>
            <th>Издательство</th>
        </tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row["Номер"] . "</td>
            <td>" . $row["Наименование"] . "</td>
            <td>" . $row["Автор"] . "</td>
            <td>" . $row["Жанр"] . "</td>
            <td>" . $row["Год_издания"] . "</td>
            <td>" . $row["Издательство"] . "</td>
          </tr>";
}
echo "</table>";
echo "</div>";
    } else {
        echo "<p>Книги не найдены.</p>";
    }
}

// Закрываем подключение
$conn->close();
?>