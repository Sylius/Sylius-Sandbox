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
        Given I am on create taxonomy
         When I fill in "Name" with "Material"
          And I press "create taxonomy"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Material"

    Scenario: Trying to create taxonomy without name
        Given I am on create taxonomy
         When I press "create taxonomy"
         Then I should be on create taxonomy
          And I should see "Please enter taxon name"

    Scenario: Update taxonomy
        Given I am on list taxonimies
          And I follow edit taxonomy "Brand"
         Then I should be on update taxonomy "Brand"
          And I should see "Taxonomy updating"
         When I fill in "Name" with "Material"
          And I press "save changes"
         Then I should be on list taxonomies
          And I should see "Material"
          And I should not see "Brand"

    Scenario: Delete taxonomy
        Given I am on list taxonimies
         When I follow delete taxonomy "Brand"
         Then I should see "Taxonomies list"
          And I should not see "Brand"

    Scenario: Browse taxon products
        Given I am on browse "Bookmania" taxon products
         Then I should see "Assortment by brand"
          And I should see "List of all products categorized under \"Bookmania\""

    Scenario: Create taxon
        Given I am on list taxonimies
          And I follow create taxon
         Then I should be on create taxon
          And I should see "Creating taxon"
         When I fill in "Name" with "SuperTees"
          And I select "Brand" from "Taxonomy"
          And I press "create taxon"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Brand"
          And I should see "SuperTees"

    Scenario: Trying to create taxon without name
        Given I am on create taxon
         When I press "create taxon"
         Then I should be on create taxon
          And I should see "Please enter taxon name"

    Scenario: Update taxon
        Given I am on list taxonimies
          And I follow edit taxon "Bookmania"
         Then I should be on update taxon "Bookmania"
          And I should see "Taxon updating"
         When I fill in "Name" with "SuperTees"
          And I select "Brand" from "Taxonomy"
          And I press "save changes"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Brand"
          And I should see "SuperTees"
          And I should not see "Bookmania"

    Scenario: Delete taxon
        Given I am on list taxonimies
         When I follow delete taxon "Bookmania"
         Then I should see "Taxonomies list"
          And I should see "Brand"
          And I should not see "Bookmania"
