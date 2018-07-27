# This guide was meant for all the staff that works on LOGGED 1.7

## Concept  
If :   
MILD API -> Disabled  
	> ALL API Usage will be disabled including PUBLIC/OPEN API  
  
MILD API -> Enabled  
	API TYPE -> Public  
		> ALL PRIVATE API will be disabled and no POST request should be made to /signup.  
  
MILD API -> Enabled  
	API TYPE -> Private/Developement  
		> ALL API will be enabled  

## How JS determines what to perform  
If :  
var apiServer is DEFINED, use MILD, else NOPE.  

## How PHP Page determines what to perform  
If :  
Config->Enable MILD API was true, check API type and use apropriate system.  
else NOPE.  
  
## Parsing the API Server  
User Entered Params : {HTTP TYPE}{URL}/{API VERSION (Optional)}  
System :   
	> Case if API !PUBLIC and =PRIVATE OR =DEV, add the proper division on the URL : {HTTP TYPE}{URL}/{API VERSION (Optional)}/{DIVISION}  

All including public API's should be redirected to the respective type.  


## Hasing hash
The MILD API server requires a hash sumarry in order to verify the integrity of the request.  
Note : Diffrent server's or API providermight had diffrent HASH standart.
For example : The default server uses MD5 while others might use MD2, MD4, SHA256, SHA512 and many more.  
The use of MD5 on the default server is to reduce the ammount of memory used and to make the data transfer faster.  

To hash the hash, get all the input field and append them from top to bottom.  
Then hash using the hmac function with the SECRET provided.  
Pass the hashed value to GET['hash'].  
