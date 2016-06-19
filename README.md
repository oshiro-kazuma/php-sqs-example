# php-sqs-example

## install ##

```sh
# install dependencies
curl -sS https://getcomposer.org/installer | php
./composer.phar install

# publish to sqs
php runner.php producer

# consume sqs messages
php runner.php consumer
```
