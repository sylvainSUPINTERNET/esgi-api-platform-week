Feature: _invit_
  Background:
    Given the following fixtures files are loaded:
      | user          |
      | invit         |
      | offre         |

  Scenario: USER - logged as ROLE_CANDIDAT and requests for invits
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /invits"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_RECRUTEUR adds new invit
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Given I have the payload
    """
       {
        "token": "string",
        "email": "test@test.com"
      }
    """
    Given I request "POST /invits"
    Then the response status code should be 201

  Scenario: USER - logged as ROLE_CANDIDAT gets one invit
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Given I request "GET /invits?invit.id=1&page=1"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_RECRUTEUR deletes one invit that doesn't exist
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Given I request "DELETE /invits"
    Then the response status code should be 405
