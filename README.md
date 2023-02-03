# ChocoWeek

ChocoWeek is a student project which aims to draw a person among the registered and the person who is drawn must bring a chocolatine to all the other registered

## Install

- Clone this project
- Run composer install
- Run yarn install
- Run yarn encore dev to build assets

### Working

- Run ``symfony server:start`` to launch your local php web server
- Run ``yarn dev-server`` to launch your local server for assets (or yarn dev-server do the same with Hot Module Reload activated)

### Modify the .env file

- Create an .env.local file from the .env
- Add your credentials on DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"

### Database and migrations

- Run ``php bin/console doctrine:database:create``
- Run ``php bin/console doctrine:make:migration``
- Run ``php bin/console doctrine:migrations:migrate``

### Credentials

_admin :_
- **username :** admin
- **password :** admin

_user :_
- **username :** user0
- **password :** user

## Author
* **Yazid Hamzi** _alias_ [@yazidham](https://github.com/yazidham)
