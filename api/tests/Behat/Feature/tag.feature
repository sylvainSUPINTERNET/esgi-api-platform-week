Feature: _Tag_
  Background:
    Given the following fixtures files are loaded:
      | parameters     |
      | tags          |

  Scenario: test post tag
    Given I have the payload
      """
      {
          "name": "tag's name"
      }
      """
    When I request "POST /tags"
    Then the response status code should be 201
    Then print last response
