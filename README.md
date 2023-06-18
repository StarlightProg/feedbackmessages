<p>Стандартный модуль auth, где пользователи разделены на менеджеров и клиентов.</p>
<p>Клиенты могут оставлять одну заявку в день с возможностью прикрепления файла, который будет сохранён на сервере(файл должен быть меньше 3Мб и не быть исполняемым).</p>
<p>При создании заявки, её содержимое отправляется письмом на почту менеджера</p>
<p>Менеджеры в личном кабинете могут просматривать все оставленные заявки. Для удобства реализована пагинация с динамическим выбором необходимого кол-ва элементов на одной странице, а также сортировка по времени создании заявки</p>
<p>Есть Seeder для генерации тестовых данных</p>
<p>Реализовано на фреймворке Laravel</p>

Установка:
1) Создать .env 
2) composer install
3) php artisan migrate --seed
4) php artisan serve
5) npm install
6) npm run dev
