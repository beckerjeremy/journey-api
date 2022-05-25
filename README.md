# Journey API

## Build Setup
```bash
# install dependencies
$ composer install

# generate jwt secret
$ php artisan jwt:secret

# migrate and seed database
$ php artisan migrate:fresh --seed

# run the server
$ php artisan serve
```