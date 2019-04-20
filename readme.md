## Introduction

Reliqui ambulatory is outpatient care platform carefully designed to meet the needs of outpatient services in health care facilities. [Learn more about ambulatory care](https://www.rasmussen.edu/degrees/nursing/blog/what-is-ambulatory-care/)

<p align="center"><img src="https://res.cloudinary.com/dave24hwj8/image/upload/v1552329523/Screen_Shot_2019-03-12_at_01.21.34.png"></p>

## Installation

Reliqui ambulatory runs on any Laravel application, it uses a separate database connection and authentication system so that you don't have to modify any of your project code.

Install Reliqui ambulatory via Composer:

```
composer require reliqui/ambulatory
```

Once Composer is done, run the following command.

```
php artisan reliqui:install
```

Create a symbolic link to ensure file uploads are publicly accessible from the web:

```
php artisan storage:link
```

Check `config/reliqui.php` and configure the database connection reliqui is going to be using, after that go run:

```
php artisan reliqui:migrate
```

Head to `yourproject.test/reliqui` and use the provided email and password to log in.

## Road map

Reliqui ambulatory is still under heavy development, I decided to ship it in this early stage so you can help me make it better.

Here's the plan for what's coming:

- [ ] Improve the flow of doctor's schedule (@davidhsianturi)
- [ ] Design a better logo
- [ ] Optimize CSS
- [ ] Add text search inside listings
- [ ] Enhance date-time picker component
- [ ] Add markdown mail template
- [ ] Add tests

Ideas that need to be discussed:

- [ ] Health check services
- [ ] Consult online services
- [ ] Home care services

And here are some ideas I'm still not sure about:

- [ ] Convert to TailwindCSS
- [ ] Localization
- [ ] Health records


## License

Reliqui ambulatory is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
