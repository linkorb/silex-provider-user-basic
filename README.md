# linkorb/silex-provider-user-basic

Custom Symfony Security User and in-memory User Provider for use in Silex apps.

First, create an array of users:-

    // for example, in src/app.php
    $users = [
        'jo' => [
            'password' => '$2y$12$G7...',
            'roles' => ['admin'],
            'display_name' => 'Joseph',
            'enabled' => false,
        ],
        'jen' => [
            'password' => '$2y$12$oD...',
            'roles' => ['admin'],
            'display_name' => 'Jenifer',
        ],
    ];

The `password` value is the hashed password; these can be generated with the
accomapnying password hashing command:-

    $ vendor/bin/hashpasswd -h
    Usage:
      hashpasswd [options]
    Options:
      -c, --cost=COST       Algorithmic cost of the hash function. [default: 12]
      -h, --help            Display this help message
    Help:
      The command interactively asks for the password before printing its hash.

Next, register Silex's core SecurityServiceProvider and provide a firewall
paramater:-

    $app->register(
        new SecurityServiceProvider,
        [
            'security.firewalls' => [
                'api' => [
                    'pattern' => '^/api',
                    'http' => true,
                    'users' => function () use ($users) {
                        return new \LinkORB\BasicUser\Provider\UserProvider($users);
                    },
                ],
            ],
        ]
    );
