<?php
namespace ZBateson\MailMimeParser\Message\Part\Factory;

use LegacyPHPUnit\TestCase;
use GuzzleHttp\Psr7;

/**
 * UUEncodedPartFactoryTest
 *
 * @group UUEncodedPartFactory
 * @group MessagePart
 * @covers ZBateson\MailMimeParser\Message\Part\Factory\UUEncodedPartFactory
 * @covers ZBateson\MailMimeParser\Message\Part\Factory\MessagePartFactory
 * @author Zaahid Bateson
 */
class UUEncodedPartFactoryTest extends TestCase
{
    protected $uuEncodedPartFactory;

    protected function legacySetUp()
    {
        $mocksdf = $this->getMockBuilder('ZBateson\MailMimeParser\Stream\StreamFactory')
            ->getMock();
        $mocksdf->expects($this->any())
            ->method('getLimitedPartStream')
            ->willReturn(Psr7\Utils::streamFor('test'));
        $psfmFactory = $this->getMockBuilder('ZBateson\MailMimeParser\Message\Part\Factory\PartStreamFilterManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $psfm = $this->getMockBuilder('ZBateson\MailMimeParser\Message\Part\PartStreamFilterManager')
            ->disableOriginalConstructor()
            ->getMock();
        $psfmFactory
            ->method('newInstance')
            ->willReturn($psfm);

        $this->uuEncodedPartFactory = new UUEncodedPartFactory($mocksdf, $psfmFactory);
    }

    public function testNewInstance()
    {
        $partBuilder = $this->getMockBuilder('ZBateson\MailMimeParser\Message\Part\PartBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $part = $this->uuEncodedPartFactory->newInstance(
            $partBuilder,
            Psr7\Utils::streamFor('test')
        );
        $this->assertInstanceOf(
            '\ZBateson\MailMimeParser\Message\Part\UUEncodedPart',
            $part
        );
    }
}
