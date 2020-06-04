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
    And the "hydra:member" property should be an array
    And the "hydra:member" property should contain 10 items
    And the "hydra:totalItems" property should be an integer equalling "10"
    Then scope into the "hydra:search" property
    And the "hydra:template" property should equal "/offres{?user.email,user.email[]}"
    # set reference manager static cachedData
    And save result in context as "offres"


  Scenario: USER - logged as ROLE_CANDIDAT and requests for one offre
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /offres" with context "@id"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_RECRUTEUR and requests for offres
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Then I request "GET /offres"
    Then the response status code should be 200
    And the "hydra:member" property should be an array
    And the "hydra:member" property should contain 10 items
    And the "hydra:totalItems" property should be an integer equalling "10"
    Then scope into the "hydra:search" property
    And the "hydra:template" property should equal "/offres{?user.email,user.email[]}"

  Scenario: USER - logged as ROLE_CANDIDAT and requests for wrong offer URL
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /offer"
    Then the response status code should be 404

  Scenario: USER - logged as ROLE_RECRUTEUR and requests for wrong offer URL
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Then I request "GET /offer"
    Then the response status code should be 404

  Scenario: USER - logged as ROLE_CANDIDAT and requests /offer with email as query param
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /offres?user.email=candidat%40candidat.com&page=1"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_RECRUTEUR and requests /offer with email as query param
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "GET /offres?user.email=candidat%40candidat.com&page=1"
    Then the response status code should be 200

  Scenario: USER - logged as ROLE_CANDIDAT can't add new offer (unauthorized)
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Given I have the payload
    """
       {
        "name": "string",
        "description": "string",
        "companyDescription": "string",
        "startAt": "2020-06-03T09:11:19.920Z",
        "workingPlace": "string"
      }
    """
    Then I request "POST /offres"
    Then the response status code should be 403

  Scenario: USER - logged as ROLE_RECRUTEUR can add new offer
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Given I have the payload
    """
       {
        "name": "string",
        "description": "string",
        "companyDescription": "string",
        "startAt": "2020-06-03T09:11:19.920Z",
        "workingPlace": "string"
      }
    """
    Then I request "POST /offres"
    Then the response status code should be 201

  Scenario: USER - logged as ROLE_RECRUTEUR update (PUT disabled)
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Given I have the payload
    """
       {
        "name": "new value",
      }
    """
    Then I request "PUT /offres"
    Then the response status code should be 405


  Scenario: USER - logged as ROLE_CANDIDAT can't udpate offer (PUT disabled)
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Given I have the payload
    """
       {
        "name": "new value",
      }
    """
    Then I request "PUT /offres"
    Then the response status code should be 405


  Scenario: USER - logged as ROLE_RECRUTEUR update (DELETE disabled)
    Given I authenticate with user "recruteur@recruteur.com" and password "recruteur"
    Then I have the role "ROLE_RECRUTEUR"
    Then I request "DELETE /offres"
    Then the response status code should be 405


  Scenario: USER - logged as ROLE_CANDIDAT can't udpate offer (DELETE disabled)
    Given I authenticate with user "candidat@candidat.com" and password "candidat"
    Then I have the role "ROLE_CANDIDAT"
    Then I request "DELETE /offres"
    Then the response status code should be 405




