<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'jwt' => [
                'issuer' => 'www.example.com',

                'lifetime' => 14400,

                # private key was versioned only for study reasons
                # Forgive me ;)
                'private_key' => '-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAzBAIPnP/au3giUYScY6+sTtkLjJOLFWBDtt1h6XvZO8WIu/1
rQoC/1tY1h52qTbMv8PJuoAXDGC8nc/0wxyT47vDwGdBcerQYnCc6KmtBtuJ+Lxv
MpLvx8T1/aZ5NwBqHV024CdOKP0r0vXDG/BlQZBHB5TQoSfU0Fjt0biRJ5yFnUrY
0JDZ1oc0lVT2LyxVJERNttcr6GpwdFCFqq62oCJ/D3OLCIKE006f2vM8jRcG+F0V
VJ9xKqRuUUST3ztQcsBrXlrf//02/YZzSho+wBbrEwkaaFqaOZfnXW/01mazRR2b
wYOJKROOSfvNVUJOJzY17SWoPizvQTpeTmb4GQIDAQABAoIBAQCGJpQE2qUzWqae
GB7P4JOkV/MIG7IgmyV46vVc881pgXQAC9hqpYZK8XZ5bRV9MLVx6/iWTtbYIFBf
PvMdwY/HywxpVHhFt6S+0mGU4tcJBxKxHs/LY6WWovlEg0h0zCT2oO0Od0h+0dEZ
os9dcrBeZccMSNzO1Symu4+8q6Vhb+rOGUMhem6G0rj9mRVVi/CK7ededeKj7Dm+
onswDku93hI9B4LgwKknJuq937MS3Gr4ChpshNNHZxCvXv7gKBWXxifuxprKbLyk
S2Mst5jFpY75qoO0f1bdMf3wKJfqADAqAjlOfOM6DAK2FKKSjNY008Te4rQ5q7Xk
ZDVUeL3BAoGBAPuoPFRq79l6zTMBz7rGSty02d4nij3epOTDP1vaRlG5Qey9JJG6
V4Bad2yKJkzWLoMfeO1UnZRQBdVXD/sARLMPb+HbUdfK6qlOocH5mxegEzTLix5R
dSfQQdROnmOW6jyduqdPoSZCgTZcK+xU7OHp5JxrDYpCR5azzu+RtS+tAoGBAM+V
iN12HUILVl+xmQlpNLc2Q5wZEsm17TQpo2r4NabU/kfEpMZw92gnddBLoOO4brIS
hWd9xAVUJxgMPzU4AK6Mh2sJToTcouYv82hrN/vohvnzNCGBYWX6VjjiDKEV5HUS
eARXUq19T1CGWxrtdz1QAxXeLBA4aIuUqAF5RwedAoGAC1jTl47Wz7yMwg8D2c0V
FQyGglDQF+gREUuIcNDPuOGcilsg6f038s6hceBsx6wknr7tie31yPkuuibZzpx9
fIFmrw1fjFZW7FliS8fAaXlLRGclF7HekXP/c94zoBPu7drCzsZ1Yq8++j9/r4FI
yQrtxuvAyYohhjcHTqAIRmUCgYEAwfrgrOLFMIRbsIzLj6nKYzLIN0SO9AOXp9kJ
JtrPeBktjW9K8015RNErHPyvWl1sw+be1vkFhl0/Mw+uuVKeAH69xN4ri6iKaUSB
1x/qbvK5vzTvkCfRFnS6wekrGBTXKjeaA6R+VDT3Oy5yUFV7ycXNPFAjKP0tZNID
tWzZXVkCgYEA0ME9mJ+X/Yoho2F/kt5VWorV1QZjbZAIyQQVZwh8SAlQlI2rUUs5
eNs/ix1wHuuArJjzPlS4YqCHEhHvHtZfEMrlCBKaZGLYjkaJfxk2JPlWRAw6CW5w
uotYEYd3dYsYzMm+41ZnnNpfUq7TT3rwO0hWK1Pq+w642zCTQfv4xfE=
-----END RSA PRIVATE KEY-----',

                'public_key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzBAIPnP/au3giUYScY6+
sTtkLjJOLFWBDtt1h6XvZO8WIu/1rQoC/1tY1h52qTbMv8PJuoAXDGC8nc/0wxyT
47vDwGdBcerQYnCc6KmtBtuJ+LxvMpLvx8T1/aZ5NwBqHV024CdOKP0r0vXDG/Bl
QZBHB5TQoSfU0Fjt0biRJ5yFnUrY0JDZ1oc0lVT2LyxVJERNttcr6GpwdFCFqq62
oCJ/D3OLCIKE006f2vM8jRcG+F0VVJ9xKqRuUUST3ztQcsBrXlrf//02/YZzSho+
wBbrEwkaaFqaOZfnXW/01mazRR2bwYOJKROOSfvNVUJOJzY17SWoPizvQTpeTmb4
GQIDAQAB
-----END PUBLIC KEY-----',

            ]
        ],
    ]);
};

