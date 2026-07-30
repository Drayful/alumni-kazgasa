# Карта проекта alumni.kazgasa.kz

Этот файл — рабочая навигация по проекту. Его стоит обновлять при добавлении крупных модулей, маршрутов или интеграций.

## Что это

Сайт выпускников KAZGASA на **Laravel 12 / PHP 8.2**. Интерфейс собран на Blade, Vite, Tailwind CSS и Alpine.js. Поддерживаются языки `kk`, `ru`, `en` (по умолчанию — `ru`).

Главные сценарии:

- публичная главная, архив, вклад выпускников и раздел достижений;
- регистрация и личный кабинет выпускника;
- проверка выпускника и заполнение учебных данных через БД iPortal;
- публичная цифровая alumni-карта и ссылки на Apple/Google Wallet;
- вакансии из iPortal (после авторизации);
- подача заявок на партнёрство и проекты;
- кабинет суперадмина: пользователи, заявки, проекты, партнёры карты, фотоархив, статистика.

## Быстрый старт

```powershell
composer install
npm install
npm run build
php artisan serve
```

Для разработки фронтенда вместо сборки: `npm run dev`.

Полная команда `composer run dev` одновременно запускает Laravel, очередь, логи и Vite. Подробности подключения к удалённым БД — в [LOCAL-DEV.md](LOCAL-DEV.md).

## Основные каталоги

| Путь | Назначение |
| --- | --- |
| `app/Http/Controllers/` | HTTP-логика: публичные страницы, профиль, админка, авторизация, Wallet. |
| `app/Models/` | Модели домена: пользователь, профиль выпускника, проекты, заявки, фотоархив, партнёры карты. |
| `app/Services/` | Интеграции и прикладные сервисы: iPortal-вакансии, фото iPortal, Apple/Google Wallet. |
| `app/Http/Middleware/` | Выбор языка (`SetLocale`) и доступ суперадмина (`SuperAdmin`). |
| `app/Http/Requests/` | Валидация профиля, данных выпускника и входа. |
| `app/Mail/` | Письма об одобрении/отклонении заявки. |
| `routes/web.php` | Все основные маршруты приложения. |
| `routes/auth.php` | Стандартные маршруты Laravel Breeze для авторизации. |
| `resources/views/` | Blade-шаблоны страниц, макетов и компонентов. |
| `resources/css/app.css`, `resources/js/app.js` | Точка входа фронтенда. |
| `lang/{kk,ru,en}/` | Переводы сайта и раздела достижений. |
| `database/migrations/` | Схема основной БД. |
| `database/seeders/` | Начальные данные: суперадмин, проекты, партнёры alumni-карты. |
| `config/` | Настройки Laravel, локализации, двух Wallet-интеграций и подключений БД. |
| `public/images/` | Публичные изображения сайта и карты. |
| `docs/iportal-tables.md` | Справочник таблиц iPortal и логика поиска выпускника. |
| `scripts/` | Одноразовые/служебные скрипты синхронизации и перевода. |

## Маршруты и интерфейс

| Раздел | Путь | Контроллер / шаблоны |
| --- | --- | --- |
| Главная | `/` | `HomeController`, `welcome.blade.php` |
| Архив | `/archive` | `ArchiveGalleryController`, `archive/` |
| Вклад выпускников | `/contributions` | `ContributionController`, `contributions/` |
| Известные выпускники | `/faces` | маршрут с данными в `routes/web.php`, `faces/` |
| Цифровая карта | `/card/{publicId}` | `AlumniCardController`, `alumni/` и `components/alumni-card.blade.php` |
| Apple / Google Wallet | `/wallet/apple/{publicId}`, `/wallet/google/{publicId}` | `Wallet/*Controller`, соответствующие сервисы |
| Вакансии | `/vacancies` | `JobController`, `jobs/`; требуется авторизация |
| Профиль | `/profile` | `ProfileController`, `profile/`; требуется авторизация |
| Суперадмин | `/super-admin/*` | `SuperAdmin/*Controller`, `super-admin/`; middleware `auth`, `super.admin` |

## Доменная модель

- `User` — учётная запись; связана один-к-одному с `AlumniProfile`, один-ко-многим с `ArchivePhoto`.
- `AlumniProfile` — данные выпускника, в том числе ИИН, год выпуска, учебные сведения, публичный ID карты и фото.
- `Project` и `ProjectApplication` — проекты сообщества и заявки на участие/поддержку.
- `PartnerApplication` — входящие заявки на партнёрство; обрабатываются суперадминистратором.
- `AlumniCardPartner` — партнёры/предложения для alumni-карты, с сортировкой и флагом активности.
- `ArchivePhoto` — фотографии архива, привязанные к пользователю и десятилетию.
- `LegacyEducationProgram` — архивный каталог ОП из Excel, привязанный к году выпуска; выбранная ОП сохраняется в профиле отдельно от идентификаторов iPortal.

## Ключевые потоки

### Регистрация и проверка выпускника

`RegisteredUserController` ищет выпускника в подключении БД `iportal` по ИИН и году выпуска. При успехе создаётся профиль с данными обучения; при отсутствии совпадения профиль можно заполнить вручную. Детали запросов и таблиц — в `docs/iportal-tables.md`.

### Профиль и alumni-карта

`ProfileController` обновляет персональные и образовательные поля. Фото обслуживает `Profile/PhotoController` и `PortalPhotoService`. Карта доступна по `public_id`; Apple и Google Wallet формируются отдельными сервисами.

### Архивные ОП и ГОП

Миграции `2026_07_30_120000_create_legacy_education_programs_table.php` и `2026_07_30_120100_add_2001_2010_legacy_education_programs.php` создают локальный каталог ОП и загружают данные из файлов «Выпуск 1991–2000» и «Выпуск 2001–2010». При регистрации и обновлении профиля ОП проверяется по выбранному году выпуска. ГОП рассчитывается на сервере через `LegacyEducationProgramService`, поэтому значение из формы не принимается: для 1957–1979 это ПГС, а для остальных архивных ОП — категория из каталога. Если iPortal и каталог не дают связанного значения, поля ОП, ГОП и группы можно заполнить вручную.

### Администрирование

Маршруты сгруппированы в `routes/web.php` под префиксом `super-admin`. Отсюда управляются пользователи и их статусы, входящие заявки, проекты, партнёры карты и фотоархив. Выгрузка пользователей — `app/Exports/SuperAdmin/UsersExport.php`.

## Интеграции и конфигурация

- Основная БД задаётся стандартными `DB_*` переменными Laravel.
- iPortal подключён как отдельное соединение `iportal` в `config/database.php`; используется для проверки выпускников, справочников профиля и вакансий.
- Настройки Wallet расположены в `config/apple-wallet.php` и `config/google-wallet.php`.
- Языковая конфигурация — `config/localization.php`; переключатель — `LocaleController`.

Не размещайте учётные данные, ключи Wallet или содержимое `.env` в документации и коммитах. При изменении настроек используйте `.env`, а не значения по умолчанию в исходном коде.

## Где искать изменения

- Новая публичная страница: маршрут в `routes/web.php` → контроллер в `app/Http/Controllers` → шаблон в `resources/views` → переводы в `lang/*`.
- Новая сущность: миграция → модель → контроллер/валидация → шаблоны → маршрут.
- Изменение формы профиля: `ProfileController`, `AlumniProfileUpdateRequest`, `resources/views/profile/partials/update-alumni-profile-form.blade.php`, `AlumniProfile`.
- Изменение цифровой карты: `AlumniCardController`, `resources/views/alumni/`, `resources/views/components/alumni-card.blade.php`, `app/Services/*WalletPassService.php`.
- Изменение данных iPortal: сначала свериться с `docs/iportal-tables.md`, затем с `RegisteredUserController`, `ProfileController` и `JobService`.

## Проверки перед передачей изменений

```powershell
php artisan test
npm run build
```

При изменении схемы БД также выполните нужные миграции в корректном окружении. Перед работой с iPortal убедитесь, что SSH-туннель поднят, если используется удалённая БД.
