# Drupal 8 testing and CI demo

This repository contains:

- A demo module with a [unit and kernel test](web/modules/custom/demo_module/tests/src).
- A demo [Behat test](tests).
- CircleCI integration to run the above [on every pull request](https://circleci.com/gh/juampynr/d8cidemo).

## Unit and Kernel tests

Demo https://www.youtube.com/watch?v=Uc3vI8ztsqU

### Setup
1. Run `composer install` from the repository root.
2. Copy `core/phpunit.xml.dist` to `core/phpunit.xml`.
3. Set the `SIMPLETESTDB` environment variable:
![](docs/images/phpunit.png)

4. Run unit and kernel tests in the `modules/custom` directory:
```bash
    cd web
    ../vendor/bin/phpunit -c core --verbose --debug modules/custom
```
![](docs/images/phpunit-run.png)

## Behat tests

Demo https://www.youtube.com/watch?v=XoxRv8x5ZIs

Full docs at https://behat-drupal-extension.readthedocs.io/en/3.1/localinstall.html

### Setup

#### Download Selenium Standalone Server

Open http://www.seleniumhq.org/download and download it to a sub-directory of your home directory.

#### Download Chromedriver

1. Download it from https://sites.google.com/a/chromium.org/chromedriver/downloads into a temporary directory.
2. Place it in a directory listed by the `$PATH` variable. For example, in Ubuntu you could
run `sudo mv /tmp/chromedriver /usr/local/bin`.

#### Start selenium
```bash
[juampy@carboncete ~/Software]$ java -jar selenium-server-standalone-3.6.0.jar
```

#### Install drupalextension
```bash
    cd /path/to/composer.json
    composer require --dev drupal/drupal-extension:master-dev
```

### Run tests
```bash
    [juampy@carboncete /var/www/drupal/d8cidemo/web (master)]$ ../vendor/bin/behat --verbose -c ../tests/behat.yml
```
 
## CI with CircleCI

Sample job run: https://circleci.com/gh/juampynr/d8cidemo/11

## Links
- An overview of testing in Drupal 8
