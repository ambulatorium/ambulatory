## Introduction

Reliqui ambulatory is outpatient care platform carefully designed to meet the needs of outpatient services in health facilities. [Learn more about ambulatory care](https://www.rasmussen.edu/degrees/nursing/blog/what-is-ambulatory-care/)

<p align="center"><img src="https://res.cloudinary.com/dave24hwj8/image/upload/v1552329523/Screen_Shot_2019-03-12_at_01.21.34.png"></p>

## Installation

Reliqui ambulatory runs on any Laravel application, it uses a separate database connection and authentication system so that you don't have to modify any of your project code.

Install Reliqui ambulatory via Composer:

```
composer require reliqui/ambulatory
```

Once Composer is done, run the following command.

```
php artisan ambulatory:install
```

Create a symbolic link to ensure file uploads are publicly accessible from the web:

```
php artisan storage:link
```

Check `config/ambulatory.php` and configure the database connection Reliqui ambulatory is going to be using, after that go run:

```
php artisan ambulatory:migrate
```

Head to `yourproject.test/ambulatory` and use the provided email and password to log in.

## Road map

Reliqui ambulatory is still under heavy development, I decided to ship it in this early stage so you can help me make it better.

Here's the plan for what's coming:

- [x] Add tests.
- [ ] Design a better logo. @davidhsianturi
- [ ] Optimize CSS, move to TailwindCSS ?
- [ ] Health check services. @davidhsianturi
- [ ] Add text search inside listings.
- [ ] Enhance date-time picker component.
- [ ] Add markdown mail template.

Ideas that need to be discussed:

- [ ] Consult online services
- [ ] Home care services

And here are some ideas I'm still not sure about:

- [ ] Localization
- [ ] Health records


## License

Reliqui ambulatory is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
