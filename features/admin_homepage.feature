Feature: See admin dashboard
    In order to view recent order list
    As administrator
    I need to be able to open a dashboard

    Background:
        Given I am logged in as admin

    Scenario: Open admin dashboard
         Then I should be on store homepage
          And I follow "Dashboard"
          And I should see "Sylius dashboard"

    Scenario: Todo
        Given I am on admin dashboard
          And I follow "Create category"

