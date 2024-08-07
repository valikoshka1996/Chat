# Chat Application

Цей проект є простим чат-додатком, який використовує PHP та Workerman для серверної частини, а також HTML, CSS, JavaScript та Bootstrap для фронтенду.

## Вимоги

- PHP 7.2 або новішої версії
- Composer для керування залежностями PHP

## Встановлення

1. **Клонуйте репозиторій**:

    ```sh
    git clone https://github.com/valikoshka1996/Chat.git
    cd Chat
    ```

2. **Ініціалізуйте Composer**:

    ```sh
    composer install
    ```

## Запуск

1. **Запустіть Workerman сервер**:

    ```sh
    php chat_server.php start
    ```

    Якщо ви хочете запустити сервер у фоновому режимі, використовуйте:

    ```sh
    php chat_server.php start -d
    ```

2. **Відкрийте `index.html` у вашому браузері**:

    Відкрийте файл `index.html` у вашому веб-браузері, щоб почати користуватися чатом.

## Використання

1. **Авторизація**:
    - Введіть ваше ім'я у полі введення та натисніть кнопку "Login" або натисніть клавішу Enter.

2. **Спілкування в чаті**:
    - Після авторизації ви можете надсилати повідомлення, вводячи їх у поле введення та натискаючи кнопку "Send" або клавішу Enter.

3. **Перегляд активних користувачів**:
    - Натисніть кнопку "Show All Users", щоб переглянути список активних користувачів у спливаючому вікні.

## Структура файлів

- `chat_server.php`: Серверна частина, що використовує Workerman для обробки WebSocket з'єднань.
- `index.html`: Фронтенд частина з HTML, CSS, JS та Bootstrap.
- `README.md`: Цей файл з інструкціями щодо запуску та використання чату.

## Ліцензія

Цей проект ліцензовано під MIT License.
