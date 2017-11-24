# Call Log IT

#### Download packages
    $ composer install
    $ composer update
    $ npm install

#### Migrate db
    Tạo database call_log_it, chạy lệnh sau để fake data
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
    
#####Fake users for testing: 
    7 first employees
    Password: test