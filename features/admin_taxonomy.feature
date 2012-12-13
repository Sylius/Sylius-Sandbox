Feature: Taxonomy management
    As an Administrator
    I want to be able to manage taxonomies and taxons

    Background:
        Given I am logged in as admin
          And there are following taxonomies:
            | taxonomy | taxons              |
            | Category | T-Shirts, Stickers  |
            | Brand    | Mugland, Bookmania  |
    Scenario: Create taxonomy
        Given I am on admin dashboard
          And I follow "Create taxonomy"
         Then I should be on create taxonomy
          And I should see "Creating taxonomy"
         When I fill in the following:
              | Name | Material |
          And I press "create taxonomy"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Material"

    Scenario: Update taxonomy
        Given I am on admin dashboard
          And I follow "List taxonomies"
          And I follow "edit"
#         Then I should be on update taxonomy
          And I should see "Taxonomy updating"
         When I fill in the following:
              | Name | Material |
          And I press "save changes"
         Then I should be on list taxonomies
          And I should see "Material"

    Scenario: Delete taxonomy
        Given I am on admin dashboard
          And I follow "List taxonomies"
          And I follow "delete"
          And I should see "Taxonomies list"
          And I should not see "Brand"

    Scenario: Create taxon
        Given I am on admin dashboard
          And I follow "List taxonomies"
          And I follow "add new one"
         Then I should be on create taxon
          And I should see "Creating taxon"
         When I fill in the following:
              | Name | Mugs |
          And I select "Brand" from "Taxonomy"
          And I press "create taxon"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Brand"
          And I should see "Mug"

    Scenario: Update taxon
        Given I am on admin dashboard
        And I follow "Create taxonomy"
         When I fill in the following:
              | Name | Brand |
          And I press "create taxonomy"
          And I follow "add new one"
          And I fill in the following:
              | Name | Mugs |
          And I select "Brand" from "Taxonomy"
          And I press "create taxon"
          And I follow "edit"
#         Then I should be on update taxon
          And I should see "Taxon updating"
         When I fill in the following:
              | Name | Stickers |
          And I select "Brand" from "Taxonomy"
          And I press "save changes"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Brand"
          And I should see "Stickers"
          And I should not see "Mug"

    Scenario: Delete taxon
        Given I am on admin dashboard
        And I follow "Create taxonomy"
         When I fill in the following:
              | Name | Brand |
          And I press "create taxonomy"
          And I follow "add new one"
          And I fill in the following:
              | Name | Mugs |
          And I select "Brand" from "Taxonomy"
          And I press "create taxon"
          And I follow "delete"
          And I should see "Taxonomies list"
          And I should see "Brand"
          And I should not see "Mugs"
