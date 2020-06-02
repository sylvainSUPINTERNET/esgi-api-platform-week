Feature: _User_
  Background:
    Given the following fixtures files are loaded:
      | parameters     |
      | users          |

  Scenario: test post user
    Given I have the payload
    """
    {
        email: "test@test.com"
        password: "$argon2id$v=19$m=65536,t=4,p=1$cMH2swfacaqZCwGA5JWOPA$J09JznitkqUp0uGDsslacn63HhhNEikbhjbZtuYm4ns"
        isValide: true
    }
    """
    Given I request "POST /users"
    When the response status code should be 201
    Then print last response
