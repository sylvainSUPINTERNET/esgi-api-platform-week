Feature: _applies_
  Background:
    Given the following fixtures files are loaded:
      | user          |
      | offre         |
      | apply         |

  Scenario: USER - logged as ROLE_CANDIDAT and requests for apply
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /applies"
    Then the response status code should be 200
    And the "hydra:member" property should be an array
    And the "hydra:member" property should contain 10 items
    And the "hydra:totalItems" property should be an integer equalling "10"
    #cached data
    Then save result in context as "applies"

  Scenario: USER - logged as ROLE_RECRUTEUR and requests for offres
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Then I request "GET /applies"
    Then the response status code should be 200
    And the "hydra:member" property should be an array
    And the "hydra:member" property should contain 10 items
    And the "hydra:totalItems" property should be an integer equalling "10"

  Scenario: USER - logged as ROLE_RECRUTEUR and requests for one apply
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Then I request "GET /applies" with context "@id"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_CANDIDAT and requests for wrong offer URL
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /apply"
    Then the response status code should be 404

  Scenario: USER - logged as ROLE_RECRUTEUR and requests for wrong offer URL
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Then I request "GET /apply"
    Then the response status code should be 404

  Scenario: USER - logged as ROLE_CANDIDAT add new apply with wrong body
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Given I have the payload
    """
      {
        "name": "string",
        "firstname": "string",
        "sexe": "string",
        "email": "string",
        "age": "string",
        "adresse": "string",
        "motivation": "string",
        "salary": "string",
        "status": "string",
      }
    """
    Then I request "POST /applies"
    Then the response status code should be 400

  Scenario: USER - logged as ROLE_CANDIDAT add new apply with wrong body
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Given I have the payload
    """
      {
        "name": "string",
        "firstname": "string",
        "sexe": "string",
        "email": "string",
        "age": "string",
        "adresse": "string",
        "motivation": "string",
        "salary": "string",
        "status": "string",
      }
    """
    Then I request "POST /applies"
    Then the response status code should be 400

  Scenario: USER - logged as ROLE_RECRUTEUR add new apply
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Given I have the payload
    """
      {
        "name": "string",
        "firstname": "string",
        "sexe": "string",
        "email": "string",
        "age": "string",
        "adresse": "string",
        "motivation": "string",
        "salary": "string",
        "status": "string",
        "user": ""
      }
    """
    Then I request "POST /applies" with fields "user" equal "users=user_recruteur_ctx"
    Then the response status code should be 201
    #Then I request "POST /applies" with context body "user"





