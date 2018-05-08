# RedashApiClient

support for queries api get/regist/delete

# Getting Started

## install
composer.json

```
{
	"require": {
		"sakatuki/redash-api-cli": "dev-master"
	}
}
```

## how to use
```
$queryId = 1;
$redashApiCli = new RedashApiClient(
    'https://your-redash',
    'your api key'
);
$apiQueries =  new RedashApiQueries($redashApiCli);
$data = $apiQueries->getQuery($queryId);
```
