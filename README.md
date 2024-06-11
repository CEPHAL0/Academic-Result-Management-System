# ARMS - Academic Result Management System

ARMS is a academic result management system developed by the Digital Media Team. Built with Laravel10 and MySQL. This system was designed to be used by Deerwalk Sifal School. It assists the teachers and admins to track the marks of each student and
also provides marksheet generation of each student.


## Requirements
- Laravel 10 or higher
- PHP 8.1 or higher
- Composer
## Prerequisites
- Download & install composer from the link [here](https://getcomposer.org/download/).
- Install XAAMP environment (version 8.1 or higher) from the link [here](https://www.apachefriends.org/download.html).
- Create a database named result_sifal.  


## Run Locally

1. Clone the project

```bash
  git clone https://github.com/dwitrnd/result_sifal.git
```

2. Go to the project directory

```bash
cd result_sifal
```
3. Update dependencies *(Optional)*
```bash
composer update
```

4. Install dependencies

```bash
composer install
```
5. Setup environment
```bash
cp .env.example .env
```
6. Generate key
```bash
php artisan key:generate
```

7. Set the database credentials in the **.env** file 


8. Migrate database locally
```bash
php artisan migrate
```

9. Start the server

```bash
 php artisan serve
```

## Database Schema
This is the database schema for ARMS project.

![ARMS_Database](https://github.com/dwitrnd/result_sifal/assets/103591323/bbe5a3b4-6761-4a68-b943-5063f9f67ccb)


## License

The project was developed using laravel framework which is an open-source software licensed under the [MIT licence](https://choosealicense.com/licenses/mit/).
