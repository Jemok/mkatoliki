		MKATOLIKI  API DEFINITION AND RESPONSE FORMATS

THE ARCHANGEL INTERACTIVE AGENCY
PREPARED BY: JAMES KAROKI
DATE: 4/4/2016

NB: What this definition does NOT contain:

	1. Subscription via MPESA
	2. Password resets and account recovery

NB: Client should define their local storage schema from the fields returned in the api JSON respsponses.

NB: API server does not handle logout.

DEFINITION

1. REGISTER A NEW USER

POST :  /api/auth/signup HTTP /1.1
HOST:  api.matoliki.com
BODY: “name”, “email”, “phone_number”, “password”
Accept:  application/json

RESPONSE 200  OK

HTTP /1.1 200 OK
HOST: api.mkatoliki.com
Connection: close

	{
		“token” : “jwt.token”
	}

RESPONSE  ERROR 422 (Unprocessable entity)

HTTP /1.1 422 Unprocessable entity
HOST: api.mkatoliki.com
Connection: close
	{
		“error”:{
			“message” : “422 Unprocessable Entity”,
			“errors”       : [
						[
						“error_one”
						],
						[
						“error_two”
						], ...
					],
			“status_code” : 422
			}
	}


2(a). LOGIN A USER

POST: /api/auth/login-phone HTTP/1.1
HOST:  api.mkatoliki.com
BODY: “phone_number”, “password”
Accept: application/json

RESPONSE 200 OK

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close

		{
			“token”, “jwt.token”
		}

RESPONSE ERROR 401 (Unauthorized)

HTTP/1.1 401 Unauthorized
HOST: api.mkatoliki.com
Connection: clsose

                     {
		 “error” :{
				“message” :  “Unauthorized”,
				“status_code” : 401
			}
		}


RESPONSE ERROR 422 (Unprocessable Entity)
	{
                “error” : {
		“message” : “422 Unprocessable Entity”,
		“errors” : [
				[
                     “error_one”
				],
				[
                    “error_two”
				],
				...
			],
		“status_code” : 422
			}
	}

2(b) Get the Authenticated user

GET: /api/auth/user HTTP/1.1
HOST:  api.mkatoliki.com
token: “Bearer" token
Accept: application/json

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close

	{
      "user": {
        "id": 1,
        "name": "user",
        "email": "user@mkatoliki.com",
        "phone_number": "0712675071",
        "phone_notification_token": "",
        "parish_id": 1,
        "station_id": 1,
        "created_at": "2016-04-06 13:50:00",
        "updated_at": "2016-04-06 13:50:00"
      }
    }



3(a) DAILY READING RESOURCE

GET /api/readings/{client_last_date_to_the_server}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json

RESPONSE 200 OK

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close
                      {
                          “data” : [
				{
				“first_reading” : “first_reading”,
				“second_reading” : “second_reading”,
				“responsorial_psalm” : “responsorial_psalm”,
				“reading_date” : “reading_date”,
				“created_at”    :  “created_at”,
				“updated_at”	:  “updated_at”
				},
				{
				“first_reading” : “first_reading”,
				“second_reading” : “second_reading”,
				“responsorial_psalm” : “responsorial_psalm”,
				“reading_date” : “reading_date”,
				“created_at”    :  “created_at”,
				“updated_at”	:  “updated_at”
				},
				...
			],
			“paginator” : {
					“total” : 39,
					“per_page” : 5
					“current_page” : 1
					“last_page” : 8,
					“next_page_url” : “next_page_url”,
					“prev_page_url” : “prev_page_url”,
					“from”: 5
				},
			“meta” : {
					“server_date”: “server_date”
				}
		}



3(b) DAILY READING RESPONSE ERROR

HTTP /1.1 404 NOT FOUND
HOST: api.mkatoliki.com
Connection: close
	{
                “error”: {
		“message” : “404 Not Found”,
		“status_code” : 404
		}
	}

	or 401 (Unauthorized)

	{
	    “error” : {
                         “message” : “Unauthorized”,
		“status_code”: 401
		}
	}


4 PRAYER RESOURCE

GET /api/prayers/{client_last_date_to_server}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json

RESPONSE 200 OK

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close
	{
 		“data” : [
			{
				“prayer_name” : “prayer_name”,
				“prayer_body” : “prayer_body”,
				“prayer_type” : “prayer_type”,
				“created_at”  : “created_at”,
				“updated_at” : “updated_at”
			},
			{
				“prayer_name” : “prayer_name”,
				“prayer_body” : “prayer_body”,
				“prayer_type” : “prayer_type”,
				“created_at”  : “created_at”,
				“updated_at” : “updated_at”
			},
			…
		],
		“paginator” : {
					“total” : 39,
					“per_page” : 5
					“current_page” : 1
					“last_page” : 8,
					“next_page_url” : “next_page_url”,
					“prev_page_url” : “prev_page_url”,
					“from”: 5
				},
		“meta” : {
			“server_date” : “server_date”
		}
	}



4(b) PRAYER RESPONSE ERROR

HTTP /1.1 404 NOT FOUND
HOST: api.mkatoliki.com
Connection: close
	{
                “error”: {
		“message” : “404 Not Found”,
		“status_code” : 404
		}
	}

	or 401 (Unauthorized)

	{
	    “error” : {
                         “message” : “Unauthorized”,
		“status_code”: 401
		}
	}



5. JUMUIYA RESOURCE

GET /api/jumuiya/{client_last_date_to_server}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json

RESPONSE OK

HTTP /1.1 200 OK
HOST: api.mkatoliki.com
Connection: close
	{
		“data” : [
				{
					“jumuiya_name” : “jumuiya_name”,
					“jumuiya_location” : “jumuiya_location”,
					“jumuiya_event_date” : “jumuiya_event_date”,
					“mass” : true,
					“created_at” : “created_at”,
					“updated_at”: “updated_at”
				},
				{
					“jumuiya_name” : “jumuiya_name”,
					“jumuiya_location” : “jumuiya_location”,
					“jumuiya_event_date” : “jumuiya_event_date”,
					“mass” : true,
					“created_at” : “created_at”,
					“updated_at”: “updated_at”
				},
				…
			],
		“paginator” : {
					“total” : 39,
					“per_page” : 5,
					“current_page” : 1,
					“last_page” : 8,
					“next_page_url” : “next_page_url”,
					“prev_page_url” : “prev_page_url”,
					“from” : 5
				},
		“meta”	 : {
				“server_date” : “server_date”
			}
		}



5(b) JUMUIYA RESPONSE ERROR

HTTP /1.1 404 NOT FOUND
HOST: api.mkatoliki.com
Connection: close
	{
                “error”: {
		“message” : “404 Not Found”,
		“status_code” : 404
		}
	}

	or 401 (Unauthorized)

	{
	    “error” : {
                         “message” : “Unauthorized”,
		“status_code”: 401
		}
	}



6. HAPPENING TODAY RESOURCE

GET /api/happenings/{client_last_date_to_server}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json
Connection: close
	{
		“data” : [
			{
				“event_title” : “event_title”,
				“event_body” : “event_body”,
				“excerpt” :  “excerpt”,
				“created_at” : “created_at”,
				“updated_at” : “updated_at”
			},
			{
				“event_title” : “event_title”,
				“event_body” : “event_body”,
				“excerpt” :  “excerpt”,
				“created_at” : “created_at”,
				“updated_at” : “updated_at”
			},
			...
		],
		“paginator” : {
				“total” : 39,
				“per_page” : 5,
				“current_page” : 1,
				“last_page” : 8,
				“next_page_url” : “next_page_url”,
				“prev_page_url” : “prev_page_url”,
				“from” : 5
			},
		“meta” : {
			“server_date” : “server_date”
			}
		}



6(b) HAPPENING RESPONSE ERROR

HTTP /1.1 404 NOT FOUND
HOST: api.mkatoliki.com
Connection: close
	{
                “error”: {
		“message” : “404 Not Found”,
		“status_code” : 404
		}
	}

	or 401 (Unauthorized)

	{
	    “error” : {
                         “message” : “Unauthorized”,
		“status_code”: 401
		}
	}



7. REFLECTION RESOURCE

GET /api/reflections/{client_last_date_to_server}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json

RESPONSE 200 OK
HTTP/1.1 200 OK
HOST api.mkatoliki.com
Connection: close
	{
		“data” : [
			{
				“reflection_body” : “reflection_body”,
				“created_at” : “created_at”,
				“updated_at” : “updated_at”
			},
			…
		],
		“paginator” : {
			“total” : 39,
			“per_page” : 5,
			“current_page” : 1,
			“last_page” : 8,
			“next_page_url” : “next_page_url”,
			“prev_page_url” : “prev_page_url”,
			“from” : 5
		},
		“meta” : {
			“server_date” : “server_date”
			}
	}



7(b) REFLECTION RESPONSE ERROR

HTTP /1.1 404 NOT FOUND
HOST: api.mkatoliki.com
Connection: close
	{
                “error”: {
		“message” : “404 Not Found”,
		“status_code” : 404
		}
	}

	or 401 (Unauthorized)

	{
	    “error” : {
                         “message” : “Unauthorized”,
		“status_code”: 401
		}
	}

UPDATED

8. NEW DATA RESOURCE COLLECTION

GET /api/new-data/{client_last_date_to_server}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json

RESPONSE 200 OK
HTTP/1.1 200 OK
HOST api.mkatoliki.com
Connection: close

 [
	 {
                          “readings” : [
				{
				“first_reading” : “first_reading”,
				“second_reading” : “second_reading”,
				“responsorial_psalm” : “responsorial_psalm”,
				“reading_date” : “reading_date”,
				“created_at”    :  “created_at”,
				“updated_at”	:  “updated_at”
				},
				{
				“first_reading” : “first_reading”,
				“second_reading” : “second_reading”,
				“responsorial_psalm” : “responsorial_psalm”,
				“reading_date” : “reading_date”,
				“created_at”    :  “created_at”,
				“updated_at”	:  “updated_at”
				},
				...
			],
			“paginator” : {
					“total” : 39,
					“per_page” : 5
					“current_page” : 1
					“last_page” : 8,
					“next_page_url” : “next_page_url”,
					“prev_page_url” : “prev_page_url”,
					“from”: 5
				},
			“meta” : {
					“server_date”: “server_date”
				},
		{
 		“prayers” : [
			{
				“prayer_name” : “prayer_name”,
				“prayer_body” : “prayer_body”,
				“prayer_type” : “prayer_type”,
				“created_at”  : “created_at”,
				“updated_at” : “updated_at”
			},
			{
				“prayer_name” : “prayer_name”,
				“prayer_body” : “prayer_body”,
				“prayer_type” : “prayer_type”,
				“created_at”  : “created_at”,
				“updated_at” : “updated_at”
			},
			…
		],
		“paginator” : {
					“total” : 39,
					“per_page” : 5
					“current_page” : 1
					“last_page” : 8,
					“next_page_url” : “next_page_url”,
					“prev_page_url” : “prev_page_url”,
					“from”: 5
				}

	},
	{
		“jumuiya” : [
				{
					“jumuiya_name” : “jumuiya_name”,
					“jumuiya_location” : “jumuiya_location”,
					“jumuiya_event_date” : “jumuiya_event_date”,
					“mass” : true,
					“created_at” : “created_at”,
					“updated_at”: “updated_at”
				},
				{
					“jumuiya_name” : “jumuiya_name”,
					“jumuiya_location” : “jumuiya_location”,
					“jumuiya_event_date” : “jumuiya_event_date”,
					“mass” : true,
					“created_at” : “created_at”,
					“updated_at”: “updated_at”
				},
				…
			],
		“paginator” : {
					“total” : 39,
					“per_page” : 5,
					“current_page” : 1,
					“last_page” : 8,
					“next_page_url” : “next_page_url”,
					“prev_page_url” : “prev_page_url”,
					“from” : 5
				}
		},

	{
		“happening_today” : [
			{
				“event_title” : “event_title”,
				“event_body” : “event_body”,
				“excerpt” :  “excerpt”,
				“created_at” : “created_at”,
				“updated_at” : “updated_at”
			},
			{
				“event_title” : “event_title”,
				“event_body” : “event_body”,
				“excerpt” :  “excerpt”,
				“created_at” : “created_at”,
				“updated_at” : “updated_at”
			},
			...
		],
		“paginator” : {
				“total” : 39,
				“per_page” : 5,
				“current_page” : 1,
				“last_page” : 8,
				“next_page_url” : “next_page_url”,
				“prev_page_url” : “prev_page_url”,
				“from” : 5
			}
		},
	{
		“reflections” : [
			{
				“reflection_body” : “reflection_body”,
				“created_at” : “created_at”,
				“updated_at” : “updated_at”
			},
			…
		],
		“paginator” : {
			“total” : 39,
			“per_page” : 5,
			“current_page” : 1,
			“last_page” : 8,
			“next_page_url” : “next_page_url”,
			“prev_page_url” : “prev_page_url”,
			“from” : 5
		}
	},
	“meta” : {
		“server_date” : “server_date”
	}
}

]




