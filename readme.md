## Introduction

**Ambulatory is outpatient care platform for your website.** Carefully designed to be consistent, fast, easy to use, and meet the needs of outpatient services in health facilities. [Learn more about ambulatory care >>>](https://www.rasmussen.edu/degrees/nursing/blog/what-is-ambulatory-care/)

## Installation

Ambulatory runs on any Laravel application, it uses a separate database connection and authentication system so that you don't have to modify any of your project code.

Install Ambulatory via Composer:

```
composer require ambulatory/ambulatory
```

Once Composer is done, run the following command.

```
php artisan ambulatory:install
```

Create a symbolic link to ensure file uploads are publicly accessible from the web:

```
php artisan storage:link
```

Check `config/ambulatory.php` and configure the database connection ambulatory is going to be using, after that go run:

```
php artisan ambulatory:migrate
```

Head to `yourproject.test/ambulatory` and use the provided email and password to log in.

## Road map

Ambulatory is still under heavy development, I decided to ship it in this early stage so you can help me make it better. [See the road map >>>](https://github.com/ambulatorycare/ambulatory/projects/1)

## Security Vulnerabilities

If you discover a security vulnerability within Ambulatory, please send an e-mail to [davidhsianturi@gmail.com](mailto:davidhsianturi@gmail.com). All security vulnerabilities will be promptly addressed.

## License

Ambulatory is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
