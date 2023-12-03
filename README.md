# Setup guide
1. Clone project / take from archive
2. Place wherever you want :)
3. `composer install`
4. Install Symfony CLI [Symfony CLI Docs](https://symfony.com/download)
5. Start local server w/o problems using `symfony server:start`
4. Run all migrations `bin/console doctrine:migrations:migrate`
5. Fulfill tables with dummy data (TBD: Maybe will create sample entries)
6. Check `Current endpoints` section, testing may be done via Insomnia/Postman or for `api/client`, `api/account` can be used `<base_url>/api`

# Current endpoints:
1. `<base_url>/api/client/{id}` - will return client and all his accounts using client ID
2. `<base_url>/api/account/{id}` - will return account by account ID and all related transactions
3. `<base_url>/make/transaction` - make transaction between two accounts. Accepts JSON only, example structure
```
{
   "senderAccountId": 1,
   "receiverAccountId": 2,
   "amount": 100,
   "currency": "EUR"
}
```

Currency rates converter - [Fixer.io](https://fixer.io/)

About Docker - didn't see any benefits to use it in this test task + the main reason why I try to avoid it - slow local environment.
The only OS where it's working fine - Linux, on other OS it's anyway it's using virtualization and makes local slow.<br/>
PS. Not sure about Docker for Symfony, but for Magento it's painful thingy :)
