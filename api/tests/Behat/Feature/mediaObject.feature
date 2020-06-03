Feature: _mediaObject_
  Background:
    Given the following fixtures files are loaded:
      | user          |
      | mediaObject   |

  Scenario: USER - logged as ROLE_CANDIDAT and requests for media objects
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /media_objects"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_CANDIDAT and requests for one media object
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /media_objects/1"
    Then the response status code should be 404