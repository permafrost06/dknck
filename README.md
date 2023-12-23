# SHAREE SALES
## Installation

Ensure you have php and composer installed

First install the required dependencies
```sh
composer install
```

Then copy the **.env.example** file to **.env**
```sh
cp .env.example .env
```

And then run this command to generate the application key
```sh
php artisan key:generate
```

## Database setup
Set up a mysql database and an account with privileges to use that database using phpMyAdmin or mysql-cli then set these values in your `.env` file
>DB_DATABASE=&lt;your database name&gt;

>DB_USERNAME=&lt;DB username&gt;

>DB_PASSWORD=&lt;DB password&gt;

__Note: Replace `<your database name>`, `<DB username>`, `<DB password>` with ones you created__

## Migration

Run this command to create the tables and seed the testing data
```sh
php artisan migrate:fresh --seed
```

Then run this to make the storage accessible
```sh
php artisan storage:link
```

## Development Server

Now run this command to start the development server
```sh
php artisan serve
```

Then go to the address shown in your browser (e.g. http://127.0.0.1:8000)
