.checkout
=========

A Symfony project created on June 28, 2016, 5:21 pm.

1. load sample fixtures for user / oauth client
2. you can log in as user / password
3. there is no option to create token by gui - token can be created by:


http POST http://localhost/currency/web/app_dev.php/oauth/v2/token \
    grant_type=password \
    client_id=14_a3lr7mjzi60wwg4s008s0w8c0kkgog800o0g44c08g88c8wgs \
    client_secret=5fueks2vf30g0w8c4w0wsks8sgsw4044gso8c0wogwkoocgosc \
    username=user \
    password=password

for test I used Httpie - https://github.com/jkbrzt/httpie

4. sample requests to rest api (api doc is under http:/HOST/web/app.php/doc):
- get info about user:

http GET http://127.0.0.1/currency/web/app_dev.php/api/users/10.json \
    "Authorization:Bearer N2U2ZGQyNTg3NDE2YmQ2ZGMxMjcxMTMyOGI3ODNkMTVlNjdlNmVmMDE3MTc4OGYxNzM1NGZhNjY2YjJkNjJkYg"

- changing password:
http POST http://127.0.0.1/currency/web/app_dev.php/api/users/changes/passes.json \
    old_pass="pass" \
    new_pass="pass2" \
    "Authorization:Bearer N2U2ZGQyNTg3NDE2YmQ2ZGMxMjcxMTMyOGI3ODNkMTVlNjdlNmVmMDE3MTc4OGYxNzM1NGZhNjY2YjJkNjJkYg"

- creating news:
http PUT http://127.0.0.1/currency/web/app_dev.php/api/news.json \
    title="news title" \
    content="bla bla bla" \
    "Authorization:Bearer N2U2ZGQyNTg3NDE2YmQ2ZGMxMjcxMTMyOGI3ODNkMTVlNjdlNmVmMDE3MTc4OGYxNzM1NGZhNjY2YjJkNjJkYg"


