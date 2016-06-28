# Firebase Cloud Messaging

##Prerequisites

### Server Key
key = `AIzaSyCAGRXrBB__ZhlQIV0thCY7zM2AziWbIcY`

### Android Key

This will be sent from the Android app and should be saved in the server to communicate with the device in the future.

## Authorization
 
**HEADER** Authorization: key=Server Key here

**HEADER** Accept: application/json 

##Sending Push Notifications

### Sending message to one or more devices
        
        POST https://fcm.googleapis.com/fcm/send

        {
          "registration_ids" : [1,2,3], //An array of tokens that you want to send push to
          "data" : {
            "message" : "sync" 
          }
        }
        
### Sending messages to a particular group of devices(topic)
       
        POST https://fcm.googleapis.com/fcm/send
        
        {
          "to" : "/topics/global",
          "data" : {
            "message" : "sync" 
          }
        }
        
## References

* [FCM](https://firebase.google.com/docs/cloud-messaging/)        


 