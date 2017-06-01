s2it-trial
==========

A Symfony project created on May 31, 2017, 2:47 pm.

# Requirements
* Docker and Docker-compose

# Install
* Clone the repository `git clone git@github.com:jeandiangelis/s2it-trial.git`
* Add `127.0.0.1 dev.s2it-trial.com` to your hosts file (in Ubuntu it is in /etc/hosts) 
* Run `docker-compose up --build` and wait until it finishes
* Just hit `dev.s2it-trial.com/app_dev.php` on your favorite browser!

# Authentication
### To authenticate and be able to access the API you'll need to generate SSH KEYS as it is described on
[LexikJWTAuthenticationBundle documentation](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#getting-started ).

Generate the SSH keys :
-----------------------
``` bash
$ mkdir -p app/jwt
$ openssl genrsa -out app/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in app/jwt/private.pem -out app/jwt/public.pem
```

PS: Note that I've changed the dir to be "app" instead of "var" because of our Symfony version.

Configuration
-------------

Change your `parameters.yml` to have the correct password under `jwt_key_pass_phrase`

``` yaml
parameters:
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
    jwt_key_pass_phrase: YOUR_PASSWORD #This should be the password you've used to generate the SSH keys.

```

Authenticating
--------------
#### Send a post request to /api/auth with a json request body containing e-mail and password as follows:
 `{"email": "s2it@mail.com", "password": "abc123!"}`
 
#### You'll get a token. With this token you can access the api routes (send it on the Authorization header with the following format: Authorization: Bearer tokenstring)
 
 