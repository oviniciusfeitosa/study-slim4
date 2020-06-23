# Study Slim 4

Study case of slim framework 4

## Requirements

- \*_composer require slim/slim:"4._"\*
- PHP 7.2+
- Composer
- php-mbstring

## Start

To run the application in development, you can run these commands

```bash
composer start
```

or

```bash
docker-compose up
```

## Routes

- POST

  - `/jwt/create`
  - Params
    - username: user
    - password: secret

- GET

  - `/users`

- GET
  - `/users/{id}`

## References

- [Slim 4 - JSON Web Token (JWT) authentication](https://odan.github.io/2019/12/02/slim4-oauth2-jwt.html)
