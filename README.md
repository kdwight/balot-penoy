# Balot Penoy

`factory.foo.create(5, { status: "private" });`


```factory.foo.create(5, { status: "private" });```


```js
factory.foo.create(5, { status: "private" });
```


```js
[
    {
        "title": "foo bar baz",
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        "status": "private"
    },
    ...
]
```

## Stack

- Laravel 8
- Inertia.js
- Vue 3
- Tailwind CSS 3

## Environment setup

- mysql 8
- php 8
- node 18.14
- npm 9.3

## Instructions

- `composer install`
- `php artisan key:generate`
- `cp .env.examp .env`
- create database
- fill up `DB_` creds on `.env` file
- `php artisan migrate:fresh --seed`
- `npm install && npm run dev`
