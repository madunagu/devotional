Revival
Revival mobile app is a mobile application that brings together most popular technology needs of churches provided in a beautiful and intuitive manner. Functions include


* Event Organisation
* Live streaming
* Look up a reference
* Video subtitling
* Advanced notification systems
* Message archiving
* Information Provision
* Locationing using google maps
* Christian companion
* Archive of Audio, Videos, Books and articles


Technology Summary
It will be made up of a
1. Web Server (laravel or django)
2. Web Application (angular or laravel or react)
3. Mobile Application (flutter)


Web Server Architecture
Will be based on an MVC system targeted at easy implementation of input and output


Main Data Nodes
Users: users will register with normal details which include


First Name
	Varchar 255
	Ekene
	Last Name
	Varchar 255
	Madunagu
	Email
	Varchar 255
	ekenemad@mail.com
	Password
	Varchar 255
	mypassw1ord
	Gender
	Small int(nullable)
	Male (1)
	Date Of Birth
	Date (nullable) 


Data Relationships


Event Organisation
Event organisation will be based on multiple methods of passing out information including


* Text Messages
* Email Messages
* App Notifications


Each notification will first be broadcast on the app notification where the user can mark if he/she will be attending the event. If no notification was sent to any of the invitees then Text Message/Email reminders may be included.
