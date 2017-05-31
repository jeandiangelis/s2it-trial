s2it-trial
==========

A Symfony project created on May 31, 2017, 2:47 pm.

# Requirements
* Docker and Docker-compose

# Install
* Clone the repository `git clone git clone git@github.com:jeandiangelis/s2it-trial.git`
* Add `127.0.0.1 dev.s2it-trial.com` to your hosts file (in Ubuntu it is in /etc/hosts) 
* Run `docker-compose up --build`
* Just hit `dev.s2it-trial.com/app_dev.php` on your favorite browser!

# Authentication
### To authenticate on the API you'll need to generate SSH KEYS as it is described on LexikJWTAuthenticationBundle - https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#getting-started
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

Configure the SSH keys path in your `config.yml` :

``` yaml
lexik_jwt_authentication:
    private_key_path: '%jwt_private_key_path%'
    public_key_path:  '%jwt_public_key_path%'
    pass_phrase:      '%jwt_key_pass_phrase%'
    token_ttl:        '%jwt_token_ttl%'
```

#### Remember to change your password on paramaters.yml file under "jwt_key_pass_phrase" to match the one you just used to create your SSH keys.

#### When send a post request to /api/auth with a json request body containing e-mail and password as follows:
 `{"email": "s2it@mail.com", "password": "abc123!"}`
 
#### You'll get a token. With this token you can access the api routes (send it on the Authorization header with the following format: Authorization: Bearer tokenstring)
 
 