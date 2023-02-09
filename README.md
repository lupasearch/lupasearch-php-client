# LupaSearch API PHP Client

- Current client version: v0.3.0
- Supports PHP ^7.2

## Getting Started

Initiate client object and authenticate

```
$client = new \LupaSearch\LupaClient();
$client
    ->setEmail('account@search.com')
    ->setPassword('password')
    ->authenticate();
```

Import documents into search index

```
$indexId = '7a31899f-31bc-46ac-b782-a44d71c5d622';
$documents = [
    'documents' => [
        [
            'id' => 1,
            'name' => 'Bag',
            'category' => 'Bags'
        ],
        [
            'id' => '2',
            'name' => 'Glasses',
            'price' => 9.99,
            'category' => 'Accessories'
        ]
    ]
];

$lupaDocumentsApi = new \LupaSearch\Api\DocumentsApi($client);
$importResponse = $lupaDocumentsApi->importDocuments(
    $indexId,
    $documents
);
```

Track progress of asynchronous tasks

```
$lupaTasksApi = new \LupaSearch\Api\TasksApi($client);
$tasks = $lupaTasksApi->getTasks($indexId, [
    'batchKey' => $importResponse['batchKey']
]);
```

Send search request

```
$publicQueryKey = 'qraljpj1reo9';
$lupaPublicQueriesApi = new \LupaSearch\Api\PublicQueryApi($client);
$searchResponse = $lupaPublicQueriesApi->search($queryKey, [
    'searchText' => '',
    'filters' => ['category' => ['Accessories']]
]);
```

## Resources

- [Swagger API](https://api.lupasearch.com/docs/)
- [LupaSearch documentation](https://console.lupasearch.com/docs/getting-started/overview)
