<?php

// @codingStandardsIgnoreStart
use Robo\Exception\TaskException;

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
   * The database URL.
   */
  const DB_URL = 'sqlite://tmp/site.sqlite';

  /**
   * RoboFile constructor.
   */
  public function __construct() {
    // Treat this command like bash -e and exit as soon as there's a failure.
    $this->stopOnFail();
  }

  /**
   * Command to run unit tests.
   */
  public function jobRunUnitTests() {
    $collection = $this->collectionBuilder();
    $collection->addTask($this->installDrupal());
    $collection->addTaskList($this->runUnitTests());
    $collection->run();
  }

  /**
   * Command to check coding standards.
   */
  public function jobCheckCodingStandards() {
    return $this->taskExecStack()
      ->stopOnFail()
      ->exec('vendor/bin/phpcs --config-set installed_paths vendor/drupal/coder/coder_sniffer')
      ->exec('vendor/bin/phpcs --standard=Drupal web/modules/custom')
      ->exec('vendor/bin/phpcs --standard=DrupalPractice web/modules/custom')
      ->run();
  }

  /**
   * Install Drupal.
   */
  private function installDrupal() {
    $db_url = static::DB_URL;
    $task = $this->drush()
      ->args('site-install')
      ->option('verbose')
      ->option('yes')
      ->option('db-url', $db_url, '=');
    return $task;
  }

  /**
   * Run unit tests
   */
  private function runUnitTests() {
    $tasks = [];
    $tasks[] = $this->taskFilesystemStack()
      ->copy('.travis/config/phpunit.xml', 'web/core/phpunit.xml');
    $tasks[] = $this->taskExecStack()
      ->dir('web')
      ->exec('../vendor/bin/phpunit -c core --debug --coverage-clover ../build/logs/clover.xml --verbose modules/custom');
    return $tasks;
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

}
