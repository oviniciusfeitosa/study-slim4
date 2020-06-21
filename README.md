# Study Slim 4
Study case of slim framework 4


## Requirements 
- **composer require slim/slim:"4.*"*
- PHP 7.2+
- Composer
- php-mbstring

## References

- [Slim 4 - JSON Web Token (JWT) authentication](https://odan.github.io/2019/12/02/slim4-oauth2-jwt.html)


## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

```bash
composer create-project slim/slim-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.
