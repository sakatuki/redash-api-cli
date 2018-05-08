# RedashApiClient

support for queries api get/regist/delete

# how to use

```
$queryId = 1;
$redashApiCli = new RedashApiClient(
    'https://your-redash',
    'your api key'
);
$apiQueries =  new RedashApiQueries($redashApiCli);
$data = $apiQueries->getQuery($queryId);
```
