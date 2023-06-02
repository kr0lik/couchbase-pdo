<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Tests\Bucket;

use Couchbase\Bucket;
use Couchbase\Cluster;
use DG\BypassFinals;
use kr0lik\CouchbasePdo\Bucket\BaseBucket;
use kr0lik\CouchbasePdo\CouchBaseConnection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @internal
 */
class BaseBucketTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        BypassFinals::enable();
    }

    public function testGetBucket(): void
    {
        $bucketName = 'bucket-name';

        $bucketFake = (new ReflectionClass(Bucket::class))
            ->newInstanceWithoutConstructor()
        ;

        $clusterMock = $this->getMockBuilder(Cluster::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['bucket'])
            ->getMock()
        ;

        $clusterMock
            ->expects(self::once())
            ->method('bucket')
            ->with($bucketName)
            ->willReturn($bucketFake)
        ;

        $connectionMock = $this->getMockBuilder(CouchBaseConnection::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getCluster'])
            ->getMockForAbstractClass()
        ;
        $connectionMock
            ->expects(self::once())
            ->method('getCluster')
            ->willReturn($clusterMock)
        ;

        $sdkBucket = new BaseBucket($connectionMock, $bucketName);
        $bucket = $sdkBucket->getBucket();

        self::assertEquals($bucket, $sdkBucket->getBucket());
    }
}
