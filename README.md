###Developer Portal (detail Product, workflow, API information)
    https://developer.bka.sh

    https://developer.bka.sh/docs/auth-capture-process-overview https://developer.bka.sh/docs/disbursement-process-overview 

#Required APIs 
###For successful purchase
    Grant Token : https://developer.bka.sh/v1.2.0-beta/reference#gettokenusingpost
    Create Payment : https://developer.bka.sh/v1.2.0-beta/reference#createpaymentusingpost
    Execute Payment : https://developer.bka.sh/v1.2.0-beta/reference#executepaymentusingpost
    Capture Payment : https://developer.bka.sh/v1.2.0-beta/reference#capturepaymentusingpost
    Query Payment : https://developer.bka.sh/v1.2.0-beta/reference#querypaymentusingget
    Search Transaction Details : https://developer.bka.sh/v1.2.0-beta/reference#searchtransactionusingget 

###For unsuccessful purchase
    Grant Token : https://developer.bka.sh/v1.2.0-beta/reference#gettokenusingpost
    Create Payment : https://developer.bka.sh/v1.2.0-beta/reference#createpaymentusingpost
    Execute Payment : https://developer.bka.sh/v1.2.0-beta/reference#executepaymentusingpost
    Void Payment : https://developer.bka.sh/v1.2.0-beta/reference#voidpaymentusingpost

###B2C Query Organization Balance 
    https://developer.bka.sh/v1.2.0-beta/reference#createpaymentusingpost
    https://developer.bka.sh/v1.2.0-beta/reference#queryorganizationbalanceusing 

###Get Intra-Account Transfer
    https://developer.bka.sh/v1.2.0-beta/reference#executepaymentusingpost
    https://developer.bka.sh/v1.2.0-beta/reference#intraaccounttransferusingpost

###B2C Payment
    https://developer.bka.sh/v1.2.0-beta/reference#querypaymentusingget
    https://developer.bka.sh/v1.2.0-beta/reference#b2cpaymentusingpost 
Please note, API timeout of 30sec should be set for all the APIs.

###Checkout Demo
    https://merchantdemo.sandbox.bka.sh/frontend/checkout/version/1.2.0-beta   
    a. Wallet number-01770618575 
    b. Pin-12121 
    c. OTP-123456 

####Github (https://github.com/bKash-developer ) for for sample Code reference. We do not have any Plug in right now. 
####Payment Gateway error codes, subject to corresponding failure scenario (https://developer.bka.sh/docs/error-codes). 
###Sandbox credentials (will share one-o-one) From integration perspective, we have to go through the following steps: 
####Milestones Tasks
    S-1: Integration Initiation Merchant is offered Developer Portal, Demo Link and Sandbox-1 credentials for testing 
    S-2: Merchant system readiness with bKash PGW Sandbox 
        a. Merchant confirms development readiness using sandbox-1
        b. Merchant shares user journey flow 
        c. Solution document finalization (if required) 
    S-3: Sandbox#2 result validation 
        a. bKash shares Sandbox-2 and requests for requried API responses. 
        b. Merchant shares required API responses for Sanbox-2 
        c. bKash validates and accepts responses shared by merchant.(Usually it takes 2 days) 
    S-4: Production info collection Merchant shares necessary info. (MSISDN, Display Name, etc.) 
    S-5: Production onboarding bKash provisions merchant on Production (Usually it takes 1-2 days) 
    S-6: Merchant system readiness with bKash PGW Production Merchant confirms system readiness using Production credentials 
    S-7: UAT & Go Live 
        a. Business UAT : Checking user journey with Production credentials 
        b. Technical UAT : Checking merchant backend security mechanism (Usually it takes 2-3 days) 
        c. Merchant makes the payment system available for all customers.
