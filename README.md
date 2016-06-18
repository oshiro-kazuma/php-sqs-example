# php-sqs-example

## install ##

```sh
# install dependencies
curl -sS https://getcomposer.org/installer | php
./composer.phar install

# publish to sqs
php producer.php

# consume sqs messages
php consumer.php
```
