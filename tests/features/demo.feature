@javascript @api
Feature: Demo feature
  In order to test Drupal
  As an anonymous user
  I need to be able to see the homepage

  Scenario: Visit the homepage
    Given I am logged in as a user with the "anonymous" role
    When I visit "/"
    Then I should see "Welcome"
