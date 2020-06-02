Feature: _Usert_
  Background:
    Given the following fixtures files are loaded:
      | user          |
      | offre        |


  Scenario: USER - logged as ROLE_CANDIDAT and requests for offres
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I request "GET /offres"

