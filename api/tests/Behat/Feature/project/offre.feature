Feature: _offre_
  Background:
    Given the following fixtures files are loaded:
      | user          |
      | offre         |


  Scenario: USER - logged as ROLE_CANDIDAT and requests for offres
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"

    Then I request "GET /offres"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_CANDIDAT and requests for wrong offer URL
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"

    Then I request "GET /offer"
    Then the response status code should be 404
