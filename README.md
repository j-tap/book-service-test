# Book Service (test)

### Task

Сервис для работы с книгами
Книга имеет одного или несколько авторов.
А так же к книге можно прикреплять комментарии.

##### Реализовать API для 
- [x] создания авторов и книг
- [x] получения списка книг по автору/авторам
- [x] получение информации о конкретном авторе со списком его книг
- [ ] получение информации о конкретной книге с ее авторами и комментариями
- [ ] для комментариев сделать поддержку пагинации
- [x] удаление книги / автора

> Проверить API можно встроенным интерфейсом на главной сранице

### Запуск проекта для разработки
- `composer install` установка зависимостей
- `php artisan migrate` установка миграций в базу
- `php artisan serve` запуск проекта
- `php artisan test` запуск тестов


<details>
    <summary>Подсказки по командам artisan</summary>

        Генерация компонентов шаблонов
        `php artisan make:component Page`
        `php artisan make:component Forms/Input`

        Генерация коллекций и ресурсов
        `php artisan make:resource BookCollection --collection`
        `php artisan make:resource BookResource`

        Генерация контроллера, ключ --api генерит контроллер с шаблоном для работы API
        `php artisan make:controller BookReviewController --api`

        Генерация валидатора
        `php artisan make:request BookStoreRequest`

        Генерация файла модели
        ключи: -m - миграции, -c - контроллера, -r - ресурс, -f - фабрики, -s - сидинг
        Возможно указание нескольких ключей: -mcr
        `php artisan make:model Book -m`

        Миграция с очисткой
        `php artisan migrate:fresh`
        Миграция одной таблицы
        `php artisan make:migration create_autor_to_book_table`
</details>
