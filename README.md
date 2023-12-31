# Setup guide
1. Clone project (e.g. git clone git@github.com:Vitalytar/mintos-api.git) / take from archive and place wherever you want :) (PHP ^8.2 used)
2. `composer install`
3. Install Symfony CLI [Symfony CLI Docs](https://symfony.com/download)
4. Adjust value for `DATABASE_URL` in the `.env` file accordingly to your local DB (hope you have it not only in Docker ^_^)
5. Install DB schema from CLI - `bin/console doctrine:database:create`. Resulted name is defined also in the DATABASE_URL environment variable
6. Run `bin/console doctrine:migrations:migrate` to install all necessary schemas
7. Run `bin/console doctrine:fixtures:load` to load some sample data to the client and account DB tables
8. Start local server problems using `symfony server:start`
9. Check `Current endpoints` section, testing may be done via Insomnia/Postman or for `api/client`, `api/account` can be used `<base_url>/api`
10. Duplicate `.env` file and make the same `.env.test.local` to avoid data overriding in the base table
11. Prepare test environment and run implemented test - `bin/console doctrine:database:create --env=test` / `bin/console doctrine:migration:migrate --env=test` /  `bin/phpunit tests/Controller`
12. Via Postman/Insomnia you can check next section and test endpoints also manually (you can find already prepared collection in the pub folder - [Test_API_Collection.postman_collection.json](public%2FTest_API_Collection.postman_collection.json) file)
<br/>

# Current endpoints:
1. GET `<base_url>/api/client/{id}` - will return client and all his accounts using client ID
2. GET `<base_url>/api/account/{id}` - will return account by account ID and all related transactions
3. POST `<base_url>/make/transaction` - make transaction between two accounts. Accepts JSON only, example structure
```
{
   "senderAccountId": 1,
   "receiverAccountId": 2,
   "amount": 100,
   "currency": "EUR"
}
```
4. GET `<base_url>/api/account-transactions/{id}?limit=<int>&offset=<int>` - returns transactions for the account if it's set as sender or receiver in any transaction. Limit and offset GET parameters are optional

Currency rates converter - [Fixer.io](https://fixer.io/)

Why full Symfony is used? From the very beginning thought to make some FE also, but then decided that there's no necessity to do so

About Docker - didn't see any benefits to use it in this test task + the main reason why I try to avoid it - slow local environment.
The only OS where it's working fine - Linux, on other OS it's anyway it's using virtualization and makes local slow.<br/>
PS. Not sure about Docker for Symfony, but for Magento it's painful thingy x_x<br/>
If you're not bored to read so far - a little bit about me - learned basics of Symfony in 2 evenings, that's why it will not look like great implementation :)<br/>
In any case - any feedback will be very appreciated
