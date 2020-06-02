Feature: _Tag_
  Background:
    Given the following fixtures files are loaded:
      | parameters     |
      | tags          |

  Scenario: test post tag
    Given I have the payload
    """
    {
        name: "tag's name"
    }
    """
    Given I request "POST /tags"
    When the response status code should be 201
    Then print last response
