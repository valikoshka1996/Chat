"# Chat" 
Це приклад чату на PHP та фреймворці Workerman
Для того щоб запустити цей чат вам необіхдно налаштувати локальний вебсервер.
Бажана версія PHP: 7.2
Завантажуємо проєтк командою git clone https://github.com/valikoshka1996/Chat.git
В консолі вводимо команду php chat-server.php start
Налаштовуємо точку входу (відповідно до Вашого веб серверу)
переходимо на index
![image](https://github.com/valikoshka1996/Chat/assets/115169564/ae87d25a-b096-4321-a243-1462a73511ff)
Вводимо ім'я

![image](https://github.com/valikoshka1996/Chat/assets/115169564/b27f4907-3cad-4a20-8e9b-60b05621010a)
Переписуємось.

Якщо ви хочете розмістити цей чат на віддаленому сервері, зверніть увагу, що потрібно поміняти посилання на вебсокет в файлах chet-server.php та index.php
В стрічках:     ws = new WebSocket('ws://localhost:2346') та $ws_worker = new Worker("websocket://0.0.0.0:2346"); встановість IP адрес (чи домен) Вашого веб серверу.
