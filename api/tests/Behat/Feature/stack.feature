Feature: _Stack_
  Background:
    Given the following fixtures files are loaded:
      | parameters     |
      | users     |
      | tags     |
      | stacks     |

  Scenario: Get collection stacks no connection
    Then I request "GET /stacks"
    And the "hydra:member" property should be an array
    And the "hydra:member" property should contain 30 items
    And the "hydra:totalItems" property should be an integer equalling "50"
    Then scope into the "hydra:view" property
    And the "@id" property should equal "/stacks?page=1"
    Then print last response

  Scenario: Get fist stacks no connection
    Then print last response
