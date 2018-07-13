@managing_brands
Feature: Editing a brand
  In order to change brand details
  As an Administrator
  I want to be able to edit a brand

  Background:
    Given The store has a brand "Levis"
    And I am logged in as an administrator

  @ui
  Scenario: Renaming a brand
    Given I want to modify the "Levis" brand
    When I rename it to "G-Star"
    And I save my changes
    Then I should be notified that it has been successfully edited
    And this brand name should be "G-Star"