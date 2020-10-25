# Getting started

Partner Gateway API document

## How to Build


You must have Python ```2 >=2.7.9``` or Python ```3 >=3.4``` installed on your system to install and run this SDK. This SDK package depends on other Python packages like nose, jsonpickle etc. 
These dependencies are defined in the ```requirements.txt``` file that comes with the SDK.
To resolve these dependencies, you can use the PIP Dependency manager. Install it by following steps at [https://pip.pypa.io/en/stable/installing/](https://pip.pypa.io/en/stable/installing/).

Python and PIP executables should be defined in your PATH. Open command prompt and type ```pip --version```.
This should display the version of the PIP Dependency Manager installed if your installation was successful and the paths are properly defined.

* Using command line, navigate to the directory containing the generated files (including ```requirements.txt```) for the SDK.
* Run the command ```pip install -r requirements.txt```. This should install all the required dependencies.

![Building SDK - Step 1](https://apidocs.io/illustration/python?step=installDependencies&workspaceFolder=Collection-Python)


## How to Use

The following section explains how to use the Collection SDK package in a new project.

### 1. Open Project in an IDE

Open up a Python IDE like PyCharm. The basic workflow presented here is also applicable if you prefer using a different editor or IDE.

![Open project in PyCharm - Step 1](https://apidocs.io/illustration/python?step=pyCharm)

Click on ```Open``` in PyCharm to browse to your generated SDK directory and then click ```OK```.

![Open project in PyCharm - Step 2](https://apidocs.io/illustration/python?step=openProject0&workspaceFolder=Collection-Python)     

The project files will be displayed in the side bar as follows:

![Open project in PyCharm - Step 3](https://apidocs.io/illustration/python?step=openProject1&workspaceFolder=Collection-Python&projectName=collection)     

### 2. Add a new Test Project

Create a new directory by right clicking on the solution name as shown below:

![Add a new project in PyCharm - Step 1](https://apidocs.io/illustration/python?step=createDirectory&workspaceFolder=Collection-Python&projectName=collection)

Name the directory as "test"

![Add a new project in PyCharm - Step 2](https://apidocs.io/illustration/python?step=nameDirectory)
   
Add a python file to this project with the name "testsdk"

![Add a new project in PyCharm - Step 3](https://apidocs.io/illustration/python?step=createFile&workspaceFolder=Collection-Python&projectName=collection)

Name it "testsdk"

![Add a new project in PyCharm - Step 4](https://apidocs.io/illustration/python?step=nameFile)

In your python file you will be required to import the generated python library using the following code lines

```Python
from collection.collection_client import CollectionClient
```

![Add a new project in PyCharm - Step 4](https://apidocs.io/illustration/python?step=projectFiles&workspaceFolder=Collection-Python&libraryName=collection.collection_client&projectName=collection&className=CollectionClient)

After this you can write code to instantiate an API client object, get a controller object and  make API calls. Sample code is given in the subsequent sections.

### 3. Run the Test Project

To run the file within your test project, right click on your Python file inside your Test project and click on ```Run```

![Run Test Project - Step 1](https://apidocs.io/illustration/python?step=runProject&workspaceFolder=Collection-Python&libraryName=collection.collection_client&projectName=collection&className=CollectionClient)


## How to Test

You can test the generated SDK and the server with automatically generated test
cases. unittest is used as the testing framework and nose is used as the test
runner. You can run the tests as follows:

  1. From terminal/cmd navigate to the root directory of the SDK.
  2. Invoke ```pip install -r test-requirements.txt```
  3. Invoke ```nosetests```

## Initialization

### Authentication
In order to setup authentication and initialization of the API client, you need the following information.

| Parameter | Description |
|-----------|-------------|
| ocp_apim_subscription_key | TODO: add a description |



API client can be initialized as following.

```python
# Configuration parameters and credentials
ocp_apim_subscription_key = 'ocp_apim_subscription_key'

client = CollectionClient(ocp_apim_subscription_key)
```



# Class Reference

## <a name="list_of_controllers"></a>List of Controllers

* [APIController](#api_controller)

## <a name="api_controller"></a>![Class: ](https://apidocs.io/img/class.png ".APIController") APIController

### Get controller instance

An instance of the ``` APIController ``` class can be accessed from the API Client.

```python
 client_controller = client.client
```

### <a name="create_token_post"></a>![Method: ](https://apidocs.io/img/method.png ".APIController.create_token_post") create_token_post

> This operation is used to create an access token which can then be used to authorize and authenticate towards the other end-points of the API.

```python
def create_token_post(self,
                          authorization)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| authorization |  ``` Required ```  | Basic authentication header containing API user ID and API key. Should be sent in as B64 encoded. |



#### Example Usage

```python
authorization = 'Authorization'

result = client_controller.create_token_post(authorization)

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized |
| 500 | Error |




### <a name="get_v_1_0_account_balance"></a>![Method: ](https://apidocs.io/img/method.png ".APIController.get_v_1_0_account_balance") get_v_1_0_account_balance

> Get the balance of the account.

```python
def get_v_1_0_account_balance(self,
                                  x_target_environment,
                                  authorization=None)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| xTargetEnvironment |  ``` Required ```  | The identifier of the EWP system where the transaction shall be processed. This parameter is used to route the request to the EWP system that will initiate the transaction. |
| authorization |  ``` Optional ```  | Authorization header used for Basic authentication and oauth. Format of the header parameter follows the standard for Basic and Bearer. Oauth uses Bearer authentication type where the credential is the received access token. |



#### Example Usage

```python
x_target_environment = 'X-Target-Environment'
authorization = 'Authorization'

result = client_controller.get_v_1_0_account_balance(x_target_environment, authorization)

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Bad request, e.g. invalid data was sent in the request. |
| 500 | Internal error. The returned response contains details. |




### <a name="get_v_1_0_accountholder_accountholderidtype_accountholderid_active"></a>![Method: ](https://apidocs.io/img/method.png ".APIController.get_v_1_0_accountholder_accountholderidtype_accountholderid_active") get_v_1_0_accountholder_accountholderidtype_accountholderid_active

> Operation is used  to check if an account holder is registered and active in the system.

```python
def get_v_1_0_accountholder_accountholderidtype_accountholderid_active(self,
                                                                           account_holder_id,
                                                                           account_holder_id_type,
                                                                           x_target_environment,
                                                                           authorization=None)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| accountHolderId |  ``` Required ```  | The party number. Validated according to the party ID type (case Sensitive). <br> msisdn - Mobile Number validated according to ITU-T E.164. Validated with IsMSISDN<br> email - Validated to be a valid e-mail format. Validated with IsEmail<br> party_code - UUID of the party. Validated with IsUuid |
| accountHolderIdType |  ``` Required ```  | Specifies the type of the party ID. Allowed values [msisdn, email, party_code].  <br> accountHolderId should explicitly be in small letters. |
| xTargetEnvironment |  ``` Required ```  | The identifier of the EWP system where the transaction shall be processed. This parameter is used to route the request to the EWP system that will initiate the transaction. |
| authorization |  ``` Optional ```  | Authorization header used for Basic authentication and oauth. Format of the header parameter follows the standard for Basic and Bearer. Oauth uses Bearer authentication type where the credential is the received access token. |



#### Example Usage

```python
account_holder_id = 'accountHolderId'
account_holder_id_type = 'accountHolderIdType'
x_target_environment = 'X-Target-Environment'
authorization = 'Authorization'

result = client_controller.get_v_1_0_accountholder_accountholderidtype_accountholderid_active(account_holder_id, account_holder_id_type, x_target_environment, authorization)

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Bad request, e.g. invalid data was sent in the request. |
| 500 | Internal error. The returned response contains details. |




### <a name="create_requesttopay_post"></a>![Method: ](https://apidocs.io/img/method.png ".APIController.create_requesttopay_post") create_requesttopay_post

> This operation is used to request a payment from a consumer (Payer). The payer will be asked to authorize the payment. The transaction will be executed once the payer has authorized the payment. The requesttopay will be in status PENDING until the transaction is authorized or declined by the payer or it is timed out by the system. 
>  Status of the transaction can be validated by using the GET /requesttopay/\<resourceId\>

```python
def create_requesttopay_post(self,
                                 x_reference_id,
                                 x_target_environment,
                                 authorization=None,
                                 x_callback_url=None,
                                 body=None)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| xReferenceId |  ``` Required ```  | Format - UUID. Recource ID of the created request to pay transaction. This ID is used, for example, validating the status of the request. ‘Universal Unique ID’ for the transaction generated using UUID version 4. |
| xTargetEnvironment |  ``` Required ```  | The identifier of the EWP system where the transaction shall be processed. This parameter is used to route the request to the EWP system that will initiate the transaction. |
| authorization |  ``` Optional ```  | Authorization header used for Basic authentication and oauth. Format of the header parameter follows the standard for Basic and Bearer. Oauth uses Bearer authentication type where the credential is the received access token. |
| xCallbackUrl |  ``` Optional ```  | URL to the server where the callback should be sent. |
| body |  ``` Optional ```  | TODO: Add a parameter description |



#### Example Usage

```python
x_reference_id = 'X-Reference-Id'
x_target_environment = 'X-Target-Environment'
authorization = 'Authorization'
x_callback_url = 'X-Callback-Url'
body = RequestToPay()
body.amount = '50'
body.currency = 'K'
body.external_id = '123'
body.payer = Party()
body.payer.party_id_type = PartyIdTypeEnum.MSISDN
body.payer.party_id = '0965058568'
body.payer_message = 'sucssess'
body.payee_note = 'not'
client_controller.create_requesttopay_post(x_reference_id, x_target_environment, authorization, x_callback_url, body)

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Bad request, e.g. invalid data was sent in the request. |
| 409 | Conflict, duplicated reference id |
| 500 | Internal Error. |




### <a name="get_requesttopay_reference_id_get"></a>![Method: ](https://apidocs.io/img/method.png ".APIController.get_requesttopay_reference_id_get") get_requesttopay_reference_id_get

> This operation is used to get the status of a request to pay. X-Reference-Id that was passed in the post is used as reference to the request.

```python
def get_requesttopay_reference_id_get(self,
                                          reference_id,
                                          x_target_environment,
                                          authorization=None)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| referenceId |  ``` Required ```  | UUID of transaction to get result. Reference id  used when creating the request to pay. |
| xTargetEnvironment |  ``` Required ```  | The identifier of the EWP system where the transaction shall be processed. This parameter is used to route the request to the EWP system that will initiate the transaction. |
| authorization |  ``` Optional ```  | Authorization header used for Basic authentication and oauth. Format of the header parameter follows the standard for Basic and Bearer. Oauth uses Bearer authentication type where the credential is the received access token. |



#### Example Usage

```python
reference_id = 'referenceId'
x_target_environment = 'X-Target-Environment'
authorization = 'Authorization'

result = client_controller.get_requesttopay_reference_id_get(reference_id, x_target_environment, authorization)

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Bad request, e.g. an incorrectly formatted reference id was provided. |
| 404 | Resource not found. |
| 500 | Internal Error. Note that if the retrieved request to pay has failed, it will not cause this status to be returned. This status is only returned if the GET request itself fails. |




[Back to List of Controllers](#list_of_controllers)



