define({ "api": [
  {
    "version": "0.0.1",
    "type": "post",
    "url": "/password/request",
    "title": "Create a reset password request",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Users's description</p>"
          }
        ]
      }
    },
    "name": "CreatePasswordResetRequest",
    "group": "Password",
    "description": "<p>This service should create a new password reset request. It will send an e-mail to the request with an token and a link to set a new password.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>email</code> was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Conflict",
            "description": "<p>There's a request to reset password already</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 410 Conflict",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/PasswordController.php",
    "groupTitle": "Password"
  },
  {
    "version": "0.0.1",
    "type": "post",
    "url": "/password/reset",
    "title": "Update an user password",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Users's description</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Users's description</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password_confirmation",
            "description": "<p>Users's description</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reset_token",
            "description": "<p>Users's description</p>"
          }
        ]
      }
    },
    "name": "UpdateUserPassword",
    "group": "Password",
    "description": "<p>This service should update an user password by given new password. It requires a valid token that is sent by email.</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No Content",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>email</code> was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Gone",
            "description": "<p>The token was expired</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 410 Gone",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/PasswordController.php",
    "groupTitle": "Password"
  },
  {
    "type": "post",
    "url": "/session/",
    "title": "Create a Session",
    "version": "0.0.1",
    "name": "CreateSession",
    "group": "Session",
    "description": "<p>This service should create a new user session for a login authentication attempt.</p> <p>It will return the basic session's information when the user logged in.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User's password</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "api_token",
            "description": "<p>Session api_token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"name\": \"Daniel Salvagni\",\n  \"email\": \"danielsalvagni@gmail.com\",\n  \"api_token\": \"...\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>user</code> are not authenticated</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/SessionController.php",
    "groupTitle": "Session"
  },
  {
    "type": "get",
    "url": "/session/",
    "title": "Request a Session",
    "version": "0.0.1",
    "name": "GetSession",
    "group": "Session",
    "description": "<p>This service returns information about the current user session. It returns pretty basic information and should stays like this.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "api_token",
            "description": "<p>Session api_token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"name\": \"Daniel Salvagni\",\n  \"email\": \"danielsalvagni@gmail.com\",\n  \"api_token\": \"...\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>user</code> are not authenticated</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/SessionController.php",
    "groupTitle": "Session"
  },
  {
    "type": "post",
    "url": "/tags",
    "title": "Create a tag",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      }
    },
    "name": "CreateTag",
    "group": "Tags",
    "description": "<p>This service should create a Tag. An user can only create tags to his own.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/TagsController.php",
    "groupTitle": "Tags"
  },
  {
    "type": "delete",
    "url": "/tags/:id",
    "title": "Delete a tag",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's unique ID.</p>"
          }
        ]
      }
    },
    "name": "DeleteTag",
    "group": "Tags",
    "description": "<p>This service should delete a tag by a given id. It will be able to only delete tags from the logged user.</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TagNotFound",
            "description": "<p>The <code>id</code> of the Tag was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the Tag wasn't related to the requester</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/TagsController.php",
    "groupTitle": "Tags"
  },
  {
    "type": "get",
    "url": "/tags/:id",
    "title": "Request a tag",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's unique ID.</p>"
          }
        ]
      }
    },
    "name": "GetTag",
    "group": "Tags",
    "description": "<p>This service should return a Tag by a given id. It will return only if it is related to the logged user.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TagNotFound",
            "description": "<p>The <code>id</code> of the Tag was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the Tag wasn't related to the requester</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/TagsController.php",
    "groupTitle": "Tags"
  },
  {
    "type": "get",
    "url": "/tags",
    "title": "Request all user's tags",
    "version": "0.0.1",
    "name": "GetTags",
    "group": "Tags",
    "description": "<p>This service should return all tags from (and only) a logged user. It will return all registers, without any kind of pagination.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n[{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\"\n},\n{\n  \"id\": 2,       \n  \"user_id\": 1,\n  \"description\": \"Ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\"\n},\n...]",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/TagsController.php",
    "groupTitle": "Tags"
  },
  {
    "type": "put",
    "url": "/tags/:id",
    "title": "Update a tag",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      }
    },
    "name": "UpdateTag",
    "group": "Tags",
    "description": "<p>This service should update a given tag. It must be able to remove only related logged user's tag.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Tag's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Tag's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Tag created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Tag updated time</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TagNotFound",
            "description": "<p>The <code>id</code> of the Tag was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the Tag wasn't related to the requester</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/TagsController.php",
    "groupTitle": "Tags"
  },
  {
    "type": "put",
    "url": "/me",
    "title": "Update an User",
    "version": "0.0.1",
    "description": "<p>This service should update the user information based in the new data inputs. It can be used to update the user password, as well.</p> <p>(*) Password confirmation is only required when <code>password</code> is sent.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "password",
            "description": "<p>User's password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "password_confirmation",
            "description": "<p>User's password confirmation</p>"
          }
        ]
      }
    },
    "name": "CreateUser",
    "group": "Users",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"name\": \"Daniel Salvagni\",\n  \"email\": \"danielsalvagni@gmail.com\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the User wasn't related to the requester token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users",
    "title": "Create an User",
    "version": "0.0.1",
    "description": "<p>This service should register a new user to the system. It will return a token to the client and it must be used on each request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User's password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password_confirmation",
            "description": "<p>User's password confirmation</p>"
          }
        ]
      }
    },
    "name": "CreateUser",
    "group": "Users",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "api_token",
            "description": "<p>Session's Token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"name\": \"Daniel Salvagni\",\n  \"email\": \"danielsalvagni@gmail.com\",\n  \"api_token\": \"...\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "delete",
    "url": "/me",
    "title": "Delete an user",
    "version": "0.0.1",
    "name": "DeleteUser",
    "group": "Users",
    "description": "<p>This service will soft-delete the logged user. It means that the user won't be removed from the database. There's no option to undo this action.</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the User wasn't related to the requester token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "get",
    "url": "/me",
    "title": "Request the logged user",
    "version": "0.0.1",
    "name": "GetUser",
    "group": "Users",
    "description": "<p>This service should return the current information about the logged user.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User's name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"name\": \"Daniel Salvagni\",\n  \"email\": \"danielsalvagni@gmail.com\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the User wasn't related to the requester token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/worklogs",
    "title": "Create a worklog",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's unique ID.</p>"
          }
        ]
      }
    },
    "name": "CreateWorklog",
    "group": "Worklogs",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Worklog's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Worklog's created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Worklog's updated time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "started_at",
            "description": "<p>Worklog's started time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "finished_at",
            "description": "<p>Worklog's finished time</p>"
          },
          {
            "group": "Success 200",
            "type": "Tag[]",
            "optional": false,
            "field": "tags",
            "description": "<p>Related worklog's tags</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\",\n  \"started_at\": \"2016-08-01 13:59:59\",\n  \"finished_at\": \"2016-08-01 13:59:59\",\n  \"tags\": [{Tag}]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/WorkLogsController.php",
    "groupTitle": "Worklogs"
  },
  {
    "type": "delete",
    "url": "/worklogs/:id",
    "title": "Delete a worklog",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's unique ID.</p>"
          }
        ]
      }
    },
    "name": "DeleteWorklog",
    "group": "Worklogs",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "WorklogNotFound",
            "description": "<p>The <code>id</code> of the Worklog was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the Worklog wasn't related to the requester</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/WorkLogsController.php",
    "groupTitle": "Worklogs"
  },
  {
    "type": "get",
    "url": "/worklogs/:id",
    "title": "Request all user's worklogs",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's unique ID.</p>"
          }
        ]
      }
    },
    "name": "GetWorklog",
    "group": "Worklogs",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Worklog's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Worklog's created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Worklog's updated time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "started_at",
            "description": "<p>Worklog's started time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "finished_at",
            "description": "<p>Worklog's finished time</p>"
          },
          {
            "group": "Success 200",
            "type": "Tag[]",
            "optional": false,
            "field": "tags",
            "description": "<p>Related worklog's tags</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\",\n  \"started_at\": \"2016-08-01 13:59:59\",\n  \"finished_at\": \"2016-08-01 13:59:59\",\n  \"tags\": [{Tag}]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "WorkLogNotFound",
            "description": "<p>The <code>id</code> of the Worklog was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the Worklog wasn't related to the requester</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/WorkLogsController.php",
    "groupTitle": "Worklogs"
  },
  {
    "type": "get",
    "url": "/worklogs",
    "title": "Request all user's worklogs",
    "name": "GetWorklogs",
    "group": "Worklogs",
    "version": "0.0.1",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Worklog's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Worklog's created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Worklog's updated time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "started_at",
            "description": "<p>Worklog's started time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "finished_at",
            "description": "<p>Worklog's finished time</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n[{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\",\n  \"started_at\": \"2016-08-01 13:59:59\",\n  \"finished_at\": \"2016-08-01 13:59:59\"\n},\n{\n  \"id\": 2,\n  \"user_id\": 1,\n  \"description\": \"Ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\",\n  \"started_at\": \"2016-08-01 13:59:59\",\n  \"finished_at\": \"2016-08-01 13:59:59\"\n},\n...]",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/WorkLogsController.php",
    "groupTitle": "Worklogs"
  },
  {
    "type": "put",
    "url": "/worklogs/:id",
    "title": "Update a worklog",
    "version": "0.0.1",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's unique ID.</p>"
          }
        ]
      }
    },
    "name": "UpdateWorklog",
    "group": "Worklogs",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Worklog's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Worklog's description</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Worklog's created time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Worklog's updated time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "started_at",
            "description": "<p>Worklog's started time</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "finished_at",
            "description": "<p>Worklog's finished time</p>"
          },
          {
            "group": "Success 200",
            "type": "Tag[]",
            "optional": false,
            "field": "tags",
            "description": "<p>Related worklog's tags</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"user_id\": 1,\n  \"description\": \"Lorem ipsum dolor sit amet\",\n  \"created_at\": \"2016-08-01 13:59:59\",\n  \"updated_at\": \"2016-08-02 13:59:59\",\n  \"started_at\": \"2016-08-01 13:59:59\",\n  \"finished_at\": \"2016-08-01 13:59:59\",\n  \"tags\": [{Tag}]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "WorklogNotFound",
            "description": "<p>The <code>id</code> of the Worklog was not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p>The <code>id</code> of the Worklog wasn't related to the requester</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Forbidden",
          "type": "json"
        }
      ]
    },
    "filename": "api/app/Http/Controllers/v1/WorkLogsController.php",
    "groupTitle": "Worklogs"
  }
] });
