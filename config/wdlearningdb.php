<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=walkingdocs_learning',
    'username' => 'root',
    'password' => 'ROOT123!',
    'charset' => 'utf8',
    'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER],

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
