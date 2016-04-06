MKATOLIKI  API DEFINITION AND RESPONSE FORMATS

THE ARCHANGEL INTERACTIVE AGENCY
PREPARED BY: JAMES KAROKI
DATE: 4/4/2016

NB: What this definition does NOT contain:

	1. Subscription via MPESA
	2. Password resets and account recovery

NB: Client should define their local storage schema from the fields returned in the api JSON respsponses.
NB: Tables relationships listed at the end of the api definition
NB: Foreign keys definitions have been highlighted in the api definition responses
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
        "created_at": "2016-04-06 13:50:00",
        "updated_at": "2016-04-06 13:50:00"
      }
    }

2(c) Get the Authenticated user parishes

GET: /api/auth/user/parishes HTTP/1.1
HOST:  api.mkatoliki.com
token: “Bearer" token
Accept: application/json

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close

	{
      "user-parishes": {
        "id": 1
        "user_id": 1,
        "parish_id": 1
      }
    }

2(d) Get the Authenticated user parishes

GET: /api/auth/user/out-stations HTTP/1.1
HOST:  api.mkatoliki.com
token: “Bearer" token
Accept: application/json

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close

	{
      "user-outstations": {
        "id": 1
        "user_id": 1,
        "parish_id": 1
      }
    }

2(d) Get the Authenticated user parishes and outstations

GET: /api/auth/user/parishes/out-stations HTTP/1.1
HOST:  api.mkatoliki.com
token: “Bearer" token
Accept: application/json

HTTP/1.1 200 OK
HOST: api.mkatoliki.com
Connection: close

	{
      "user-outstations": {
        "id": 1
        "user_id": 1,
        "parish_id": 1,
        'outstation_id'
      }
    }


3. NEW DATA RESOURCE COLLECTION



GET /api/new-data/{2016-05-06 13:50:00}
HOST: api.mkatoliki.com
token: “Bearer” jwt.token
Accept: application/json

RESPONSE 200 OK
HTTP/1.1 200 OK
HOST api.mkatoliki.com
Connection: close

{
  "data": {
    "readings": [
      {
        "id": 1,
        "readings_date": "1459950600000",
        "first_reading_title": "This is the first reading",
        "first_reading_verse": "This is the first reading",
        "first_reading_body": "first_reading_title",
        "second_reading_title": "second_reading_title",
        "second_reading_verse": "second_reading_book",
        "second_reading_body": "second_reading_body",
        "responsorial_psalm_tatle": "responsorial_title",
        "responsorial_bible_verse": "responsorial_book",
        "responsorial_psalm_bible_verse": "responsorial_psalm_verse",
        "responsorial_psalm_response": "responsorial_psalm_response",
        "responsorial_psalm_body": "responsorial_body_two",
        "gospel_title": "gospel_title",
        "gospel_body": "gospel_body"
      },
      {
        "id": 2,
        "readings_date": "1459950600000",
        "first_reading_title": "This is the first reading",
        "first_reading_verse": "This is the first reading",
        "first_reading_body": "first_reading_title",
        "second_reading_title": "second_reading_title",
        "second_reading_verse": "second_reading_book",
        "second_reading_body": "second_reading_body",
        "responsorial_bible_verse": "responsorial_book",
        "responsorial_psalm_bible_verse": "responsorial_psalm_verse",
        "responsorial_psalm_response": "responsorial_psalm_response",
        "responsorial_psalm_body": "responsorial_body_two",
        "gospel_title": "gospel_title",
        "gospel_body": "gospel_body"
      },
        ...
    ],
    "prayers": [
      {
        "id": 1,
        "prayer_title": "prayer_title",
        "prayer_body": "prayer_body",
        "prayer_type": "prayer_type"
      },
      {
        "id": 2,
        "prayer_title": "prayer_title",
        "prayer_body": "prayer_body",
        "prayer_type": "prayer_type"
      },
      {
        "id": 3,
        "prayer_title": "prayer_title",
        "prayer_body": "prayer_body",
        "prayer_type": "prayer_type"
      },
        ...
    ],
    "reflections": [
      {
        "id": 2,
        "reflection_body": "reflection_body",
        "reflection_date": "reflection_date",
        "reading_id" : "1"


      },
      {
        "id": 3,
        "reflection_body": "reflection_body",
        "reflection_date": "reflection_date",
        "reading_id" : "1"

      },
        ...
    ],
    "happenings": [
       {
          "id": 1,
          "event_title": "event_title",
          "event_body": "event_body",
          "event_excerpt": "event_excerpt",
          "event_date": "event_date"
       },
       {
           "id": 2
           "event_title": "event_title",
           "event_body": "event_body",
           "event_excerpt": "event_excerpt",
           "event_date": "event_date"
       }
    ],
    "raw_jumuiyas": [
      {
        "id": 1,
        "jumuiya_name": "jumuiya_name",
        "jumuiya_image_link": "jumuiya_image_link"
      },
      {
        "id": 2
        "jumuiya_name": "jumuiya_name",
        "jumuiya_image_link": "jumuiya_image_link"
      },
        ...
    ],
    "jumuiya_events": [
      {
        "id": 1,
        "jumuiya_location": "location",
        "jumuiya_event_date": "2016-04-06 13:50:00",
        "more_details": "jumuiya_more_details",
        "jumuiya_day_event_title": "jumuiya_day_event_title"
        "raw_jumuiya_id": 1 (NB: foreing_key for relationship with the raw_jumuiyas table)
      },
      {
        "id": 2
        "jumuiya_location": "location",
        "jumuiya_event_date": "2016-04-06 13:50:00",
        "more_details": "jumuiya_more_details",
        "jumuiya_day_event_title": "jumuiya_day_event_title"
        "raw_jumuiya_id": 1 (NB: foreing_key for relationship with the raw_jumuiyas table)
      },
      {
        "id": 3
        "jumuiya_location": "location",
        "jumuiya_event_date": "2016-04-06 13:50:00",
        "more_details": "jumuiya_more_details",
        "jumuiya_day_event_title": "jumuiya_day_event_title"
        "raw_jumuiya_id": 1 (NB: foreing_key for relationship with the raw_jumuiyas table)
      },
      {
        "id": 4
        "jumuiya_location": "location",
        "jumuiya_event_date": "2016-04-06 13:50:00",
        "more_details": "jumuiya_more_details",
        "jumuiya_day_event_title": "jumuiya_day_event_title"
        "raw_jumuiya_id": 1 (NB: foreing_key for relationship with the raw_jumuiyas table)
      },
        ...
    ],
    "parishes": [
      {
        "id": 1,
        "parish_name": "parish_name"
      },
      {
        "id": 2,
        "parish_name": "parish_name"
      },
      {
        "id": 3,
        "parish_name": "parish_name"
      }
    ],
    "out-stations": [
      {
        "id": 1,
        "station_name": "station_name",
        "parish_id": 1 (NB: foreing_key for relationship with the parish table)
      },
      {
        "id": 2,
        "station_name": "station_name",
        "parish_id": 1 (NB: foreing_key for relationship with the parish table)
      },
      {
        "id": 3,
        "station_name": "station_name",
        "parish_id": 1 (NB: foreing_key for relationship with the parish table)
      },
      {
        "id": 4,
        "station_name": "station_name",
        "parish_id": 1 (NB: foreing_key for relationship with the parish table)
      },
      {
        "id": 5,
        "station_name": "station_name",
        "parish_id": 1 (NB: foreing_key for relationship with the parish table)
      }
    ]
  }
}

NB::

TABLE RELATIONSHIPS IN THE SERVER

1. readings_table -- reflections_table
    one          --      one

2. raw_jumuiyas_table -- jumuiya_events_table
    one             --   many

3. parishes_table   -- outstations_table
    one         ---   many

4. users_table    -- parishes_table
       many    --    many

5. users_table  -- outstations_table
     many       --     many



