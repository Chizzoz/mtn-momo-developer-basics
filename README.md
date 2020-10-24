# mtn-momo-developer-basics
MTN MoMo Developer Basics is a repository aimed at giving developers a head start in interacting with the MTN MoMo API's found here: https://momodeveloper.mtn.com/

*Disclaimer: This repository is not officially affiliated with MTN*

# General Guidelines
The aim is to accommodate any framework, implementation or programming language. This repo will be organised by having individual branches catering for different solutions. Developers are free to contribute to any branch relevant to their skill or interest.

At a bare minimum, you will be expected to register on the [MTN MoMo Developer Portal](https://momodeveloper.mtn.com/) and follow the [Getting Started Guidelines](https://github.com/Chizzoz/mtn-momo-developer-basics) to enable you to:

* Subscribe To MTN MoMo API Products
* Manage Your Subscriptions (`Primary Key` and `Secondary Key`)
* Generate *API User* and *API Key*

which will be necessary in interacting with the API using those credentials generated.

# Integrating Using Python httplib
After following the [Getting Started Guidelines](https://github.com/Chizzoz/mtn-momo-developer-basics), you should be able to use the credentials generated in the code below.

## Collections API

* /requesttopay - POST

    `requesttopay.py` included in this repository has the code required to generate *Basic Authentication Token*, *Bearer Token* and POST a *requesttopay* Request, you just have to replace three (3) values in the code listed below:

    * `$api_user = 'enter_api_user_here';`
    * `$api_key = 'enter_api_key_here';`
    * `$subscription_key = "Enter_Subscription_Key_Here";`

    ```
        import httplib, urllib, base64
        api_user = 'enter_api_user_here'
        api_key = 'enter_api_key_here'
        api_user_and_key  = api_user+':'+api_key
        basic_auth = base64.b64encode(api_user_and_key)
        print('Basic ' + basic_auth)

        subscription_key = 'Enter_Subscription_Key_Here'
        headers = {
            # Request headers
            'Authorization': 'Basic ' + basic_auth,
            'Ocp-Apim-Subscription-Key': subscription_key,
        }

        params = urllib.urlencode({
        })

        try:
            conn = httplib.HTTPSConnection('sandbox.momodeveloper.mtn.com')
            conn.request("POST", "/collection/token/?%s" % params, "{body}", headers)
            response = conn.getresponse()
            data = response.read()
            bearer_token = json.loads(data)
            bearer_auth = 'Bearer ' + bearer_token['access_token']
            print(bearer_auth)
            conn.close()
        except Exception as e:
            print("[Errno {0}] {1}".format(e.errno, e.strerror))

            ... More TODO here

    ```

* /requesttopay/{referenceId} - GET

    TODO

## Disbursements API

* /transfer - POST

    `transfer.py` included in this repository has the code required to generate *Basic Authentication Token*, *Bearer Token* and POST a *transfer* Request, you just have to replace three (3) values in the code listed below:

    * `$api_user = 'enter_api_user_here';`
    * `$api_key = 'enter_api_key_here';`
    * `$subscription_key = "Enter_Subscription_Key_Here";`

    ```
        TODO
    ```

* /transfer/{referenceId} - GET

    TODO

# Contribution Guidelines
Contributions can be made through pull requests.
* You can start by forking this repo
* Contribute to a branch relevant to you, if it exists
* Otherwise, create a new branch, for a new implementation, for example; REST, Java, React, Vue, Laravel, etc
* Once you are ready and everything checks out, you can push to your forked repo and create a pull request against this repo
* We will then review and approve

# More ToDo...
