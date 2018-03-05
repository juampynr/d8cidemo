<?php

// @codingStandardsIgnoreStart

/**
 * Base tasks for setting up a module to test within a full Drupal environment.
 *
 * This file expects to be called from the root of a Drupal site.
 *
 * @class RoboFile
 * @codeCoverageIgnore
 */
class RoboFile extends \Robo\Tasks {

  /**
   * RoboFile constructor.
   */
  public function __construct() {
    // Treat this command like bash -e and exit as soon as there's a failure.
    $this->stopOnFail();
  }

  /**
   * Install Drupal.
   *
   * @param string $db_url
   *   The database URL.
   */
  public function installDrupal($db_url) {
    $task = $this->drush()
      ->args('site-install')
      ->option('verbose')
      ->option('yes')
      ->option('db-url', $db_url, '=');

    // Sending email will fail, so we need to allow this to always pass.
    $this->stopOnFail(FALSE);
    $task->run();
    $this->stopOnFail();
  }

  /**
   * Checks coding standards.
   */
  public function checkCodingStandards() {
    return $this->taskExecStack()
      ->stopOnFail()
      ->exec('vendor/bin/phpcs --config-set installed_paths vendor/drupal/coder/coder_sniffer')
      ->exec('vendor/bin/phpcs --standard=Drupal web/modules/custom')
      ->exec('vendor/bin/phpcs --standard=DrupalPractice web/modules/custom')
      ->run();
  }

  /**
   * Runs unit tests.
   */
  public function runUnitTests() {
    $this->taskFilesystemStack()
      ->copy('.travis/config/phpunit.xml', 'web/core/');
    $this->taskExecStack()
      ->dir('web')
      ->exec('../vendor/bin/phpunit -c core --debug --coverage-clover ../build/logs/clover.xml --verbose modules/custom');
  }

  /**
   * Return drush with default arguments.
   *
   * @return \Robo\Task\Base\Exec
   *   A drush exec command.
   */
  protected function drush() {
    // Drush needs an absolute path to the docroot.
    $docroot = $this->getDocroot() . '/web';
    return $this->taskExec('vendor/bin/drush')
      ->option('root', $docroot, '=');
  }

  /**
   * Get the absolute path to the docroot.
   *
   * @return string
   */
  protected function getDocroot() {
    $docroot = (getcwd());
    return $docroot;
  }


  /**
   * Run PHPUnit and simpletests for the module.
   *
   * @param string $module
   *   The module name.
   */
  public function test($module) {
    $this->phpUnit($module)
      ->run();
  }

  /**
   * Return a configured phpunit task.
   *
   * This will check for PHPUnit configuration first in the module directory.
   * If no configuration is found, it will fall back to Drupal's core
   * directory.
   *
   * @param string $module
   *   The module name.
   *
   * @return \Robo\Task\Testing\PHPUnit
   */
  private function phpUnit($module) {
    return $this->taskPhpUnit('vendor/bin/phpunit')
      ->option('verbose')
      ->option('debug')
      ->configFile('web/core')
      ->group($module);
  }


}
