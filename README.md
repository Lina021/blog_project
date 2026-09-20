# Laravel Blog Project

A blog website for sharing tech topics, where users can register, publish posts with images and tags, and discuss them in comments. Visitors can browse, search and filter posts without an account. The project covers CRUD, authentication, authorization, a REST API, file uploads, email notifications and tests.

## Features

- **Posts**: create, edit, delete and view posts, each with an optional image
- **Tags**: attach tags to posts
- **Search and filter**: search by title, content or tag, and filter posts by tag
- **Comments**: logged-in users can comment on posts and delete their own comments
- **Email notifications**: the post author is notified when someone comments (queued)
- **Authentication**: register, log in and log out
- **Authorization**: policies make sure users can only edit or delete their own posts and comments
- **My Activity**: a page showing the logged-in user's own posts and comments
- **REST API**: token-based API (Laravel Sanctum) for posts, comments, tags and auth
- **Tests**: feature tests written with Pest

## Tech stack

- PHP 8.4 and Laravel 13
- MySQL
- Blade templates, Tailwind CSS 4 and Vite
- Laravel Sanctum for API authentication
- Pest for testing

## Setup

```sh
git clone https://github.com/Lina021/blog_project.git
cd blog-project

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Set the database details in `.env`. The default in `.env.example` is SQLite. For MySQL, change `DB_CONNECTION` to `mysql` and fill in the `DB_*` values.

Then create the tables and link the storage folder for uploaded images:

```sh
php artisan migrate --seed
php artisan storage:link
```

Alternatively, import the sample data in [database/backup.sql](database/backup.sql) into a MySQL database called `blog`.

## Running the app

```sh
php artisan serve
npm run dev
php artisan queue:work
```

The queue worker is needed to send comment notification emails. Emails are written to the log (`MAIL_MAILER=log`) by default, so check `storage/logs/laravel.log`.

## Web routes

| Method | URL | Description |
|---|---|---|
| GET | `/posts` | List posts (supports `?q=` search and `?tag=` filter) |
| GET | `/posts/{post}` | Show a post |
| GET/POST | `/posts/create`, `/posts` | Create a post (login required) |
| GET/PUT | `/posts/{post}/edit`, `/posts/{post}` | Edit a post (owner only) |
| DELETE | `/posts/{post}` | Delete a post (owner only) |
| POST | `/posts/{post}/comments` | Add a comment |
| DELETE | `/comments/{comment}` | Delete a comment (owner only) |
| GET | `/my-activity` | Your posts and comments |

## API

All routes are under `/api`. Send the token as `Authorization: Bearer <token>`.

| Method | URL | Auth |
|---|---|---|
| POST | `/register`, `/login` | No |
| GET | `/posts`, `/posts/{post}`, `/posts/{post}/comments`, `/tags` | No |
| GET | `/user` | Yes |
| POST | `/logout` | Yes |
| POST | `/posts` | Yes |
| PUT/PATCH | `/posts/{post}` | Yes (owner) |
| DELETE | `/posts/{post}` | Yes (owner) |
| POST | `/posts/{post}/comments` | Yes |
| DELETE | `/comments/{comment}` | Yes (owner) |

## Running tests

```sh
php artisan test
```

