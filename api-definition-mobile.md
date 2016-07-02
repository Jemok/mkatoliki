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
      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE2LCJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9zaWdudXAiLCJpYXQiOjE0NjY5MjAwMzYsImV4cCI6MTQ2NjkyMDA5NiwibmJmIjoxNDY2OTIwMDM2LCJqdGkiOiJjZTFjYWM5MjY4MGZiZGZhNTM2ZGRjMDZiZmZlNDVjYiJ9.kYisCP2Rf2bXpPZkhC8vRw_XyRAz2FP8WhiBRvWQspo",
      "message": "success",
      "user": {
        "id": 16,
        "name": "user",
        "email": "user77@mkatoliki.com",
        "phone_number": "0752767071",
        "parish_id": null,
        "station_id": null,
        "created_at": {
          "date": "2016-06-26 08:47:16",
          "timezone_type": 3,
          "timezone": "Africa/Khartoum"
        },
        "updated_at": {
          "date": "2016-06-26 08:47:16",
          "timezone_type": 3,
          "timezone": "Africa/Khartoum"
        }
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
          "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE2LCJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9zaWdudXAiLCJpYXQiOjE0NjY5MjAwMzYsImV4cCI6MTQ2NjkyMDA5NiwibmJmIjoxNDY2OTIwMDM2LCJqdGkiOiJjZTFjYWM5MjY4MGZiZGZhNTM2ZGRjMDZiZmZlNDVjYiJ9.kYisCP2Rf2bXpPZkhC8vRw_XyRAz2FP8WhiBRvWQspo",
          "message": "success",
          "user": {
            "id": 16,
            "name": "user",
            "email": "user77@mkatoliki.com",
            "phone_number": "0752767071",
            "parish_id": null,
            "station_id": null,
            "created_at": {
              "date": "2016-06-26 08:47:16",
              "timezone_type": 3,
              "timezone": "Africa/Khartoum"
            },
            "updated_at": {
              "date": "2016-06-26 08:47:16",
              "timezone_type": 3,
              "timezone": "Africa/Khartoum"
            }
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

    [
      "parish ans outstation set successfully"
    ]

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
        ],
         "subscriptions": [
               {
                 "active": {
                   "name": "user",
                   "email": "user1@mkatoliki.com",
                   "phone_number": "0712675072",
                   "subscription_id": 7,
                   "user_id": 2,
                   "subscription_status": 0,
                   "subscription_category_name": "monthly",
                   "subscription_category_code": 2,
                   "start_date": "2016-06-13 11:13:33",
                   "end_date": "2016-07-13 11:13:33",
                   "created_at": {
                     "date": "2016-06-13 11:13:33",
                     "timezone_type": 3,
                     "timezone": "Africa/Khartoum"
                   },
                   "updated_at": {
                     "date": "2016-06-13 11:13:33",
                     "timezone_type": 3,
                     "timezone": "Africa/Khartoum"
                   }
                 },
                 "closed": {
                   "name": "user",
                   "email": "user1@mkatoliki.com",
                   "phone_number": "0712675072",
                   "subscription_id": 6,
                   "user_id": 2,
                   "subscription_status": 1,
                   "subscription_category_name": "monthly",
                   "subscription_category_code": 2,
                   "start_date": "2016-06-13 11:12:04",
                   "end_date": "2016-07-13 11:12:04",
                   "created_at": {
                     "date": "2016-06-13 11:12:03",
                     "timezone_type": 3,
                     "timezone": "Africa/Khartoum"
                   },
                   "updated_at": {
                     "date": "2016-06-13 11:13:33",
                     "timezone_type": 3,
                     "timezone": "Africa/Khartoum"
                   }
                 }
               }
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
          "message": "logged out successfully",
          "status_code": 200
        }

    others

    RESPONSE 401

    {
      "error": {
        "message": "The token has been blacklisted",
        "status_code": 401
      }
    }

    RESPONSE 401

    {
      "error": {
        "message": "Token has expired",
        "status_code": 401
      }
    }


### FEEDBACK ENDPOINT

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

    HOST:  api.mkatoliki.com
    POST: /api/feedbacks HTTP/1.1

    {
        "mood":1,
        "comment": "Awesome"
    }

    RESPONSE 201 Created

    [
      "Feedback successfully created"
    ]

### PASSWORD RECOVERY ENDPOINT

    HOST:  api.mkatoliki.com
    POST: /api/auth/recovery HTTP/1.1

    {
        "email":"karokijames40@gmail.com"
    }

    Response 204 No Content

### SUBSCRIPTION DESCRIPTION

### ARCHITECTURE

## Subscription Entities Description
The following entities describe subscriptions:

## SubscriptionCategory (i.e subscription_categories table)
Describes the subscription packages available
This entity holds the identity, name, days, price, and a unique subscription_category of a subscription
## Schema
-- A unique identifier of a subscription_category (i.e `id` integer, unsigned)
-- A name field for the category e.g weekly (i.e `name` string)
-- A days field for the subscription, basically the no of days for the subscription to be active e.g 7 (i.e `days` integer, unsigned)
-- A price field for the amount to be paid for a subscription e.g 50 (i.e `price` double)
-- A subscription_category field, this is number that is used to categorise subscriptions as follows
            1 for weekly
            2 for monthly
            3 for three_months
            4 for annually

## SubscriptionStatus (i.e subscription_status table)
Describes the states in which a subscription can be in
This entity holds the identity, status_name and a status_code
## Schema
-- A unique identifier of a subscription_status (i.e `id` integer, unsigned)
-- A status_name field for a subscription status e.g active (1.e `status_name`, string)
-- A status_code field, this is a number that is uniquely used to identify a subscription status as follows
            0 for active
            1 for closed
            2 for initiated
            3 for confirmed
            4 for canceled

## Subscription (i.e the subscriptions table)
Describes a subscription
This entity holds, the identity, owner and status of a subscription
## Schema
--  A unique identifier of a subscription (i.e `id` integer, unsigned)
--  A reference to the user who owns the subscription (i.e.`user_id` integer, unsigned, index foreign key to the users table `id`)
--  A reference to the subscriptionCategory entity (i.e `subscription_category_id` integer, unsigned, index foreign key to the subscription_categories_table `id`)
--  A reference to the subscriptionStatus entity (i.e `subscription_status_id` integer, unsigned, index, foreign key to the subscription_status table `id`)

## SubscriptionDetail (i.e subscription_details table)
Describes the details of a subscription
This entity holds, the start_date, the end_date of a subscription
## Schema
-- A unique identifier of a subscription_detail (i.e `id` integer, unsigned)
-- A start_date filed which holds the date and time when a subscription starts e.g 2016-05-03 08:24:52 (i.e `start_date`, datetime)
-- An end_date field which holds the date and time when a subscription ends e.g 2016-05-10 08:24:52 (i.e `end_date`)
-- A subscription_id which references a subscription (i.e `subscription_id` integer, unsigned, index, foreign key to the subscription table `id`)


### SUBSCRIPTION PROCESS USING MPESA
Describes how to subscribe to a particular subscription package using mpesa
## Process

## processCheckOutRequest
--Client makes a request for subscription to server, client passes to server the following parameters
      --  phone_number of user e.g 254712675071
      --  subscription_category_code e.g 1 i.e the subscription_category_number used to categorise a subscription

## Example

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

                 HOST:  api.mkatoliki.com
                 POST: /api/subscriptions HTTP/1.1

                    {
                        "phone_number" : "254712675071",
                        "subscription_category_code" : 1
                    }

## processCheckOutResponse
## RESPONSE 200 OK
-- Server immediately returns a response with the following parameters
      -- subscription_status e.g 2 i.e the status_code that identifies a subscription_status uniquely
      -- status_description e.g initiated
      -- subscription_id e.g 84
      -- transaction_id e.g cce3d32e0159c1e62a9ec45b67676200,
      -- customer_message e.g To complete this transaction, enter your Bonga PIN on your handset. if you don't have one dial *126*5# for instructions

##Example

                HTTP/1.1 200 OK
                HOST: api.mkatoliki.com
                Connection: close

               		{
                        "subscription_status": 2,
                        "status_description": "initiated",
                        "subscription_id": 84,
                        "transaction_id": "cce3d32e0159c1e62a9ec45b67676200",
                        "message": "To complete this transaction, enter your Bonga PIN on your handset. if you don't have one dial *126*5# for instructions"
                    }

## transactionConfirmRequest
-- Client sends back a confirmation action to server with the following parameters
    -- transaction_id e.g cce3d32e0159c1e62a9ec45b67676200 this should be retrieved from the processCheckOutResponse
    -- subscription_id e.g 84 this should be retrieved from the processCheckOutResponse
-- Mpesa will push a ussd dialog on users handset where they can enter their
   bonga pin (how to generate one is returned in processCheckOutResponse above) for transaction authentication and validation
-- then payment processing starts on mpesa
##Example

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

                HOST:  api.mkatoliki.com
                POST: /api/subscriptions/mpesa/confirm HTTP/1.1

                    {
                        "transaction_id" : "cce3d32e0159c1e62a9ec45b67676200",
                        "subscription_id" : 84
                    }
## transactionConfirmResponse
## RESPONSE 200 OK
-- Server immediately returns a response with the following parameters
     -- subscription_status e.g 3
     -- subscription_description e.g confirmed
     -- subscription_id e.g 78
     -- transaction_id cce3d32e0159c1e62a9ec45b67676200


##Example

                HTTP/1.1 200 OK
                HOST: api.mkatoliki.com
                Connection: close

                {
                  "subscription_status": 3,
                  "status_description": "confirmed",
                  "subscription_id": 78,
                  "transaction_id": "cce3d32e0159c1e62a9ec45b67676200"
                }

### subscriptionCancel
-- Client may decide to cancel an unprocessed subscription transaction
-- Client passes the following parameters to the server
        -- transaction_id e.g cce3d32e0159c1e62a9ec45b67676200 this should be retrieved from the processCheckOutResponse
        -- subscription_id e.g 84 this should be retrieved from the processCheckOutResponse
##Example

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

                HOST:  api.mkatoliki.com
                POST: /api/subscriptions/mpesa/cancel HTTP/1.1

                    {
                        "transaction_id" : "cce3d32e0159c1e62a9ec45b67676200",
                        "subscription_id" : 84
                    }
## transactionCancelResponse
## RESPONSE 200 OK
-- Server immediately returns a response with the following parameters
     -- subscription_id e.g 78
     -- transaction_id e.g cce3d32e0159c1e62a9ec45b67676200
     -- subscription_status e.g 4
     -- subscription_description e.g cancelled
     -- cancellation_date e.g   "date": "2016-05-04 12:34:13",
                                  "timezone_type": 3,
                                  "timezone": "Africa/Khartoum"
### Example

                 HTTP/1.1 200 OK
                 HOST: api.mkatoliki.com
                 Connection: close

                {
                  "subscription_id": 78,
                  "transaction_id": "cce3d32e0159c1e62a9ec45b67676200",
                  "subscription_status": 4,
                  "subscription_description": "canceled",
                  "cancellation_date": {
                    "date": "2016-05-04 12:34:13",
                    "timezone_type": 3,
                    "timezone": "Africa/Khartoum"
                  }
                }

### subscriptionNotification
-- After mpesa completes the transaction, server will push a notification immediately to the client with a message
   describing either the subscription failed, is pending or was successful
-- If the notification is not received automatically, client uses the check endpoint to check transaction status and
   to also get the subscription details if user was subscribed,
-- Client has to check the subscription process results by making a subscription check call to the server with  the following parameters
            -- transaction_id e.g cce3d32e0159c1e62a9ec45b67676200 this should be retrieved from the transactionConfirmResponse
            -- subscription_id e.g 84 this should be retrieved from the transactionConfirmResponse

### Example

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

            HOST:  api.mkatoliki.com
            POST: /api/subscriptions/mpesa/check HTTP/1.1
            {
                "transaction_id":"cce3d32e0159c1e62a9ec45b67676200",
                "subscription_id" : 78
            }
## transactionCheckResponse
## RESPONSE 200 OK

## responseTransactionSuccessful

             HTTP/1.1 200 OK
             HOST: api.mkatoliki.com
             Connection: close

             {
               "subscription_id": 78,
               "subscription_status": 0,
               "subscription_description": "active",
               "message": "Success",
               "user_id": 2,
               "subscription_days": 7,
               "start_date": {
                 "date": "2016-05-04 11:48:28",
                 "timezone_type": 3,
                 "timezone": "Africa/Khartoum"
               },
               "end_date": {
                 "date": "2016-05-11 11:48:28",
                 "timezone_type": 3,
                 "timezone": "Africa/Khartoum"
               }
             }
## responseTransactionFailed

            HTTP/1.1 200 OK
            HOST: api.mkatoliki.com
            Connection: close

           {

             "message": "Failed",
             "reason": "Insufficient Funds"
           }

## responseTransactionPending

              HTTP/1.1 200 OK
              HOST: api.mkatoliki.com
              Connection: close

              {
                "message": "Pending",
                "reason": "Mpesa delay"
              }

## responseTransactionError

               HTTP/1.1 200 OK
               HOST: api.mkatoliki.com
               Connection: close

               {
                 "message": "Failed",
                 "reason": "Mpesa error"
               }
## responseTransactionWaitingForMpesaToReplyToServer

                 HTTP/1.1 200 OK
                 HOST: api.mkatoliki.com
                 Connection: close

                 {
                   "status_code": 100,
                   "message": "Transaction is being processed by mpesa"
                 }

## mpesaTransactionQuery
-- In the case server always returns the above response ##responseTransactionWaitingForMpesaToReplyToServer##
-- client can initiate a direct query of transaction results directly from mpesa as follows
     -- transaction_id e.g cce3d32e0159c1e62a9ec45b67676200 this should be retrieved from the transactionConfirmResponse
     -- subscription_id e.g 84 this should be retrieved from the transactionConfirmResponse

### Example

**HEADER** Authorization: Bearer token_here
**HEADER** Content-Type: application/json

            HOST:  api.mkatoliki.com
            POST: /api/subscriptions/mpesa/query HTTP/1.1

            {
                "transaction_id":"cce3d32e0159c1e62a9ec45b67676200",
                "subscription_id" : 78
            }

### THE RESPONSES OF THIS QUERY ARE SIMILAR TO THOSE OF transactionCheckResponse (see above)

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
## subscription_categories_table -- subscriptions_table
    one               --                many
## subscription_status_table     -- subscriptions_table
    one               --                many
## subscriptions_table --  subscription_details_table
    one                     one

