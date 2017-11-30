# Drupal 8 testing and CI demo

[![CircleCI](https://circleci.com/gh/juampynr/d8cidemo.svg?style=svg)](https://circleci.com/gh/juampynr/d8cidemo)

This is a working demo that integrates CircleCI with a Drupal 8 site using
the installation script from https://github.com/juampynr/drupal8ci.

You can see its test runs at https://circleci.com/gh/juampynr/d8cidemo.

It contains:

- A demo module with a [unit and kernel test](web/modules/custom/demo_module/tests/src).
- A demo [Behat test](tests).
- CircleCI integration to run the above [on every pull request](https://circleci.com/gh/juampynr/d8cidemo).


If you want to test and individul module and not a whole Drupal site, see
[drupal_tests](https://github.com/deviantintegral/drupal_tests).
