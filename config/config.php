<?php

/*
    Stores every configuration detail needed in a asociative array
*/
return [
    'database' => [
        'host' => getenv('DB_HOST'),
        'user' => getenv('MYSQL_USER'),
        'password' => getenv('MYSQL_PASSWORD'),
        #'root_password' => getenv('MYSQL_ROOT_PASSWORD'),
        'dbname' => getenv('MYSQL_DATABASE')
    ],
    'api_keys' => [
        // API keys and other credentials
    ],
    'app_name' => getenv('PROJECT_NAME')
];