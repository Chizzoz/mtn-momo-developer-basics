# mtn-momo-developer-basics
MTN MoMo Developer Basics is a repository aimed at giving developers a head start in interacting with the MTN MoMo API's found here: https://momodeveloper.mtn.com/

*Disclaimer: This repository is not officially affiliated with MTN*

# General Guidelines
The aim is to accommodate any framework, implementation or programming language. This repo will be organised by having individual branches catering to different solutions. Developers are free to contribute to any branch relevant to their skill or interest.

At a bare minimum, you will be expected to register on the [MTN MoMo Developer Portal](https://momodeveloper.mtn.com/) and follow the [Getting Started Guidelines](https://momodeveloper.mtn.com/api-documentation/getting-started/) to enable you to:

* Subscribe To MTN MoMo API Products
* Manage Your Subscriptions (`Primary Key` and `Secondary Key`)
* Generate *API User* and *API Key*

which will be necessary in interacting with the API using those credentials generated.

# Getting Started

1. Register Application

    The first thing you need to do to get started, after registering on the [MTN MoMo Developer Portal](https://momodeveloper.mtn.com/) and signing in, is going to your [User Profile Page](https://momodeveloper.mtn.com/developer) where you will find two (2) sections, one for **Your Subscriptions** and another for **Your Applications**. Here you will need to click on *Register application*, under **Your Applications**, and enter details for your application. This step is necessary in order to avoid getting a `401 Error` when trying to generate your Oauth 2.0 credentials under [Sandbox User Provisioning](https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api/operations/post-v1_0-apiuser).

    <img src="./assets/momo-api-register-app.png" alt="MTN MoMo API Developer Register App" title="MTN MoMo API Developer Register App" width="800">

    After saving the *Register Application* form, it will be submitted for approval, which should normally not take a long time.

2. Subscribe to MTN MoMo API Product

    You can now visit the [Products page](https://momodeveloper.mtn.com/products) to subscibe to a suitable product, you are not limited to just just one, four (4) are provided:
    1. **Collection Widget:** Receive mobile money payments on your website through a USSD or QR code
    1. **Collections:** Enable remote collection of bills, fees or taxes.
    1. **Disbursements:** Automatically deposit funds to multiple users
    1. **Remittances:** Remit funds to local recipients from the diaspora with ease

    For each product, there are options to *See full documentation* and *Subscribe*. Below is an example for *Colllection Widget*.

    <img src="./assets/mtn-momo-collection-widget-subscribe.png" alt="MTN MoMo API Collection Widget Product" title="MTN MoMo API Collection Widget Product" width="800">

    Select *Subscribe* and you will be redirected to subscription page:

    <img src="./assets/mtn-momo-subscribe-to-collection-widget.png" alt="MTN MoMo API Collection Widget Product" title="MTN MoMo API Collection Widget Product" width="800">

    Then click the yellow Subscribe button to be subscribed to the product.

    Now when you visit your [User Profile Page](https://momodeveloper.mtn.com/developer), you should see products to which you are subscribed to under **Your Subscriptions** section. Below is an example:

    <img src="./assets/mtn-momo-subscriptions.png" alt="MTN MoMo API Subscriptions" title="MTN MoMo API Subscriptions" width="800">

# Contribution Guidelines
Contributions can be made through pull requests.
* You can start by forking this repo
* Contribute to a branch relevant to you, if it exists
* Otherwise, create a new branch, for a new implementation, for example; REST, Java, React, Vue, Laravel, etc
* Once you are ready and everything checks out, you can push to your forked repo and create a pull request against this repo
* We will then review and approve

# More ToDo...
