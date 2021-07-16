# Book Service (test)

### Task

Сервис для работы с книгами
Книга имеет одного или несколько авторов.
А так же к книге можно прикреплять комментарии.

##### Реализовать API для 
- создания авторов и книг
- получения списка книг по автору/авторам
- получение информации о конкретном авторе со списком его книг
- получение информации о конкретной книге с ее авторами и комментариями
- для комментариев сделать поддержку пагинации
- удаление книги / автора

### Запуск проекта для разработки
- `composer install` установка зависимостей
- `php artisan migrate` установка миграций в базу
- `php artisan serve` запуск проекта
- `php artisan test` запуск тестов

> Проверить API можно встроенным интерфейсом на главной сранице

<details>
    <summary>Подсказки по коммандам</summary>
    ```
        // Генерация компонентов шаблонов
        php artisan make:component Page
        php artisan make:component Forms/Input

        // Генерация коллекций
        php artisan make:resource AuthorCollection

        // Генерация контроллера, ключ --api генерит контроллер с шаблоном для работы API
        php artisan make:controller BookReviewController --api

        // Генерация файла модели, ключи: -m - миграции, -f - фабрики -c - контроллера, -s - сидинг
        // Возможно указание нескольких ключей: -mfc
        php artisan make:model BookReviews -m

        // Миграция с очисткой
        php artisan migrate:fresh
        // Миграция одной таблицы
        php artisan make:migration create_autor_to_book_table
    ```
</details>
