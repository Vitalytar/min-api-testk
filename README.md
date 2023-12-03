Current endpoints:
1. <base_url>/api/clients/{id} - will return client and all his accounts using client ID
2. <base_url>/api/accounts/{id} - will return account by account ID and all related transactions
3. <base_url>/make/transaction - make transaction between two accounts. Accepts JSON only, example structure
{
   "senderAccountId": "1",
   "receiverAccountId": "2",
   "amount": "1000",
   "currency": "EUR"
}
