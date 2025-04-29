# lite-llm-client

## installation 
Add repository to the composer.json

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:wampirusy/lite-llm-clien.git"
    }
]
```

Run the composer installer:

```bash
  php composer require wampirusy/lite-llm-clien
```

## Using

```php
    $factory = new ServiceFactory($host, $token);
    
    $service = $factory->createJsonService();
    print_r($service->ask('how to make pizza', ['ingredients' => '', 'recipe' => '']));
    
    $service = $factory->createTextService();
    print_r($service->ask('how to make pizza?'));    
    
    $service = $factory->createSynonymsService();
    print_r($service->ask('pizza'));
```
