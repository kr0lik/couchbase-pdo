# couchbase-pdo

# Installation

The preferred way to install this extension is through composer:
```
composer require kr0lik/couchbase-pdo
```
    
### Usage

Add into config/services.yaml:
```
services:
# ...
    Couchbase\ClusterOptions:
        calls:
            - { method: credentials, arguments: [ '%env(resolve:COUCHBASE_LOGIN)%', '%env(resolve:COUCHBASE_PASSWORD)%' ] }

    kr0lik\CouchbasePdo\CouchBaseConnection:
        arguments:
            $url: '%env(resolve:COUCHBASE_URL)%'
            $options: '@Couchbase\ClusterOptions'

    kr0lik\CouchbasePdo\Bucket\BaseBucket:
        arguments:
            $connection: '@kr0lik\CouchbasePdo\CouchBaseConnection'
            $bucketName: '%env(resolve:COUCHBASE_BUCKET_NAME)%'
            
    kr0lik\CouchbasePdo\CouchBaseClient:
        arguments:
            $bucket: '@kr0lik\CouchbasePdo\Bucket\BaseBucket'
```
