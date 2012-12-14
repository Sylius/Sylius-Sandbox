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
         When I fill in "Name" with "Material"
          And I press "create taxonomy"
         Then I should be on list taxonomies
          And I should see "Taxonomies list"
          And I should see "Material"

    Scenario: Update taxonomy
        Given I am on admin list taxonimies
          And I follow edit taxonomy
#         Then I should be on update taxonomy
          And I should see "Taxonomy updating"
         When I fill in "Name" with "Material"
          And I press "save changes"
         Then I should be on list taxonomies
          And I should see "Material"
          And I should not see "Brand"

    Scenario: Delete taxonomy
        Given I am on admin list taxonimies
          And I follow delete taxonomy
          And I should see "Taxonomies list"
          And I should not see "Brand"

    Scenario: Create taxon
        Given I am on admin list taxonimies
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

    Scenario: Update taxon
        Given I am on admin list taxonimies
          And I follow edit taxon
#         Then I should be on update taxon
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
        Given I am on admin list taxonimies
          And I follow delete taxon
          And I should see "Taxonomies list"
          And I should see "Brand"
          And I should not see "Bookmania"
