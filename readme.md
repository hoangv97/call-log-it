# Call Log IT

### Deployment
1. Create file .env, copy from .env.example
2. Config file .env: change DB_USERNAME, DB_PASSWORD

#### Download packages
    $ composer install
    $ composer update
    $ npm install

#### Migrate db
    Create database call_log_it, fake data by running:
    $ php artisan migrate --seed
    $ php artisan key:generate

#### After config, clear cache:
    $ composer dump-autoload
    $ php artisan cache:clear
    $ php artisan config:cache
    
#### Run
    $ php artisan serve
    
#### Debug, print log
    $ tail -f storage/logs/laravel.log
    
#### PhpStorm plugin instructions
    Settings > Plugins > Browse repositories... > Tìm 'Laravel plugin' > Cài 
    Settings > Languages and Frameworks > Php > Laravel > Bật 'Enable plugin for this project'
    
##### Fake users for testing: 
    7 first employees
    Password: test
