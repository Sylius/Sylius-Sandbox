Feature: See homepage
    In order to view recent product list
    As a visitor
    I need to be able to visit homepage

    Scenario: Visit home page
        Given I am on store homepage
         Then I should be on store homepage
          And I should see "Recent products"
