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
