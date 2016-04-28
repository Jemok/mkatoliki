# MKATOLIKI  API DEFINITION AND RESPONSE FORMATS

## DESCRIPTION

THE ARCHANGEL INTERACTIVE AGENCY
PREPARED BY: JAMES KAROKI
CREATED ON: DATE: 4/4/2016

## NB: What this definition does NOT contain:

Subscription via MPESA
Password resets and account recovery

NB: Client should define their local storage schema from the fields returned in the api JSON respsponses.
NB: Tables relationships listed at the end of the api definition
NB: Foreign keys definitions have been highlighted in the api definition responses

## DEFINITION

### REGISTER A NEW USER

    POST :  /api/auth/signup HTTP /1.1
    HOST:  api.matoliki.com
    Content-Type:  application/json

    {
        "name" : "name_here",
        "email": "email_here",
        "phone_number": "phone_number_here",
        "password" : "password_here"
    }

    RESPONSE 200  OK

    HTTP /1.1 200 OK
    HOST: api.mkatoliki.com
    Connection: close

	{
      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjUsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhcL3NpZ251cCIsImlhdCI6MTQ1OTk5MDQ2OSwiZXhwIjoxNDU5OTk0MDY5LCJuYmYiOjE0NTk5OTA0NjksImp0aSI6ImNlNDkzYjQwOTNiMTVmNjk5M2U1N2FjYzllZTRlOTAxIn0.nXsuuWU07o8YguGZvyM15fslNUUbnyiggAQ9nfLlxgQ",
      "user": {
        "id": 5,
        "name": "Jemo",
        "email": "user@email.com",
        "phone_number": "0712879467",
        "phone_notification_token": "",
        "parish_id": 1,
        "station_id": 1,
        "created_at": "2016-04-07 00:54:29",
        "updated_at": "2016-04-07 00:54:29"
      }
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


### LOGIN A USER

    POST: /api/auth/login-phone HTTP/1.1
    HOST:  api.mkatoliki.com
    Content-Type: application/json

    {
        "phone_number" : "phone_number_here",
        "password"     : "password_here"
    }

    RESPONSE 200 OK

    HTTP/1.1 200 OK
    HOST: api.mkatoliki.com
    Connection: close

		{
          "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjUsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhcL3NpZ251cCIsImlhdCI6MTQ1OTk5MDQ2OSwiZXhwIjoxNDU5OTk0MDY5LCJuYmYiOjE0NTk5OTA0NjksImp0aSI6ImNlNDkzYjQwOTNiMTVmNjk5M2U1N2FjYzllZTRlOTAxIn0.nXsuuWU07o8YguGZvyM15fslNUUbnyiggAQ9nfLlxgQ",
          "user": {
            "id": 5,
            "name": "Jemo",
            "email": "user@email.com",
            "phone_number": "0712879467",
            "phone_notification_token": "",
            "parish_id": 1,
            "station_id": 1,
            "created_at": "2016-04-07 00:54:29",
            "updated_at": "2016-04-07 00:54:29"
          }
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

### Get the Authenticated user

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST:  api.mkatoliki.com
    GET: /api/auth/user HTTP/1.1

    RESPONSE 200 OK

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

### Get the collection of all parishes and outstations

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST:  api.mkatoliki.com
    GET: /api/parishes-outstations HTTP/1.1

    HTTP/1.1 200 OK
    HOST: api.mkatoliki.com
    Connection: close

    {
        "data": {
        "parishes": [
        {
         "id": 1,
         "parish_name": "Aut."
        },
        {
         "id": 2,
         "parish_name": "Sit et."
        },...
       ],
     "out-stations": [
       {
         "id": 1,
         "station_name": "Porro totam.",
         "parish_id": 25
       },
       {
         "id": 2,
         "station_name": "Alias aliquam.",
         "parish_id": 25
       },...
     ]
   }
 }

### Store a user parish and outstation

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST:  api.mkatoliki.com
    POST: /api/auth/user/parish-station HTTP/1.1

    {
        "parish_id"  : "parish id here",
        "station_id" : "station id here"
    }

    RESPONSE OK 201 Created

    RESPONSE 401 Unauthorized

        {
		 “error” :{
				“message” :  “Unauthorized”,
				“status_code” : 401
			}
		}

        RESPONSE 500 Internal Server Error

        {
		 “error” :{
				“message” :  “could_not_create_user_parish_station”,
				“status_code” : 500
			}
		}

### NEW DATA RESOURCE COLLECTION

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST: api.mkatoliki.com
    GET /api/new-data/{2016-05-06 13:50:00}

    RESPONSE 200 OK
    HTTP/1.1 200 OK
    HOST api.mkatoliki.com
    Connection: close

    {
      "meta": {
        "to_server_last_date": {
          "date": "2016-04-07 12:21:37",
          "timezone_type": 3,
          "timezone": "Africa/Khartoum"
        }
      },
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
          },...
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

          }, ...
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
          },...
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
          },...
        ],
        "parishes": [
          {
            "id": 1,
            "parish_name": "parish_name"
          },
          {
            "id": 2,
            "parish_name": "parish_name"
          },...
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
          },..
        ],
        "prayer_types": [
              {
                "id": 1,
                "prayer_type_name": "Sapiente consectetur.",
                "prayer_type_description": "Quo laudantium reiciendis animi deleniti iste. Quo aliquam neque ut blanditiis qui. Modi maiores a eos aut exercitationem sed dignissimos. Exercitationem pariatur aut nihil qui omnis sed cum numquam. Ratione sed dicta et consequatur ut est veritatis. Necessitatibus sunt et aut quibusdam. Est qui est iste sint explicabo optio nulla. Ratione porro et illo eum beatae nobis. Numquam nemo voluptatibus optio ea eos repellat ipsa. Autem omnis vel error aut commodi magni. Aliquam magnam in deserunt harum eveniet aperiam. Sed distinctio est consequatur saepe qui libero mollitia. Aspernatur itaque eos harum rerum. Facilis et harum dolore voluptatibus suscipit libero qui."
              },
              {
                "id": 2,
                "prayer_type_name": "Ducimus.",
                "prayer_type_description": "Ut quidem ratione ratione eum tenetur vel qui reiciendis. Tenetur delectus maiores nesciunt mollitia. Mollitia magnam unde harum cumque eaque sunt. Est sunt velit quia voluptates corrupti. Exercitationem dolores quidem necessitatibus quibusdam. Saepe saepe hic temporibus exercitationem vitae hic saepe. Quia porro qui vitae cumque at voluptas. Sunt explicabo rerum modi laborum qui ad asperiores. Eum recusandae et veniam. Dolorum quia laborum in esse vel et. Dolorum aspernatur praesentium cumque vero praesentium laborum tempora."
              },...
        ]
      }
    }

### Submit Phone GCM token

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST:  api.mkatoliki.com
    POST: /api/gcm/tokens HTTP/1.1

    {
        "token" : "gcm token here"
    }

    RESPONSE 201 Created

### LOGOUT ENDPOINT

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST:  api.mkatoliki.com
    POST: /api/auth/logout HTTP/1.1

    RESPONSE 200 OK

    HTTP/1.1 200 OK
    HOST: api.mkatoliki.com
    Connection: close

		{
			“token”, “expired_jwt token”
		}

### TABLE RELATIONSHIPS IN THE SERVER

## readings_table     -- reflections_table
    one               --    one

## raw_jumuiyas_table -- jumuiya_events_table
    one               --   many

## parishes_table     -- outstations_table
    one               --   many

## users_table        --  parishes_table
    many              --   many

## users_table        --  outstations_table
    many              --    many

## users_table        -- gcm_tokens_table
    one               --    one


