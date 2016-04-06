# Google Cloud Messaging

##Prerequisites

### Server Key
key = `AIzaSyCAGRXrBB__ZhlQIV0thCY7zM2AziWbIcY`

### Android Key

This will be sent from the Android app and should be saved in the server to communicate with the device in the future.

## Authorization
 
**HEADER** Authorization: key=Server Key here

**HEADER** Accept: application/json 

##Sending Push Notifications

### Sending message to a single device
This type of messages will be shown on the user's notification bar immediately.
        
        POST https://gcm-http.googleapis.com/gcm/send

        {
          "to" : "Android Key here",
          "data" : {
            "message" : "You subscription is almost over!" 
          }
        }
        
### Sending messages to a particular group of devices
This type of message will cause the app to initialize sync operation (Go to server and get new data). 
       
        POST https://gcm-http.googleapis.com/gcm/send
        
        {
          "to" : "/topics/global",
          "data" : {
            "message" : "update" 
          }
        }
        
## References

* [GCM](https://developers.google.com/cloud-messaging/gcm)        


 