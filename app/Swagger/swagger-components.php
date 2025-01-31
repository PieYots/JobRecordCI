<?php

// app/Swagger/swagger-components.php

return [
    'schemas' => [
        'BaseResponse' => [
            'type' => 'object',
            'properties' => [
                'status' => ['type' => 'string'],
                'message' => ['type' => 'string'],
            ],
        ],
        'User' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string'],
                'email' => ['type' => 'string'],
            ],
        ],
    ],
    'responses' => [
        '200' => [
            'description' => 'Successful operation',
            'content' => [
                'application/json' => [
                    'schema' => ['$ref' => '#/components/schemas/BaseResponse'],
                ],
            ],
        ],
        '404' => [
            'description' => 'Not Found',
            'content' => [
                'application/json' => [
                    'schema' => ['$ref' => '#/components/schemas/BaseResponse'],
                ],
            ],
        ],
    ],
];
