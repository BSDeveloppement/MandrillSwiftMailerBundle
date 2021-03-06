<?php

namespace Accord\MandrillSwiftMailerBundle\Tests;

use Accord\MandrillSwiftMailerBundle\SwiftMailer\MandrillTransport;

class BundleTest extends BundleTestCase{

    public function testTransport(){

        $container = $this->createContainer();

        /** @var MandrillTransport $transport */
        $transport = $container->get('swiftmailer.mailer.transport.accord_mandrill');

        $this->assertNotNull($transport);
        $this->assertInstanceOf('\Accord\MandrillSwiftMailer\SwiftMailer\MandrillTransport', $transport, 'Transport should be an instance of MandrillTransport');
        $this->assertEquals('AexOlO8l1E1JE_7jEXbSpQ', $transport->getApiKey(), 'Incorrect API key, should be using test key');

        /** @var \Swift_Mailer $mailer */
        $mailer = $container->get('mailer');

        $message = new \Swift_Message('TEST SUBJECT', 'test body');
        $message->setTo('to@example.com');
        $message->setFrom('from@example.com');

        $result = $mailer->send($message);

        $this->assertEquals(1, $result, 'One message should have been sent to Mandrill');

    }

    public function testTransportSendPlaintext()
    {
        $container = $this->createContainer();

        /** @var MandrillTransport $transport */
        $transport = $container->get('swiftmailer.mailer.transport.accord_mandrill');

        $message = new \Swift_Message('TEST SUBJECT', 'test text body', 'text/plain');
        $message->setTo('to@example.com');
        $message->setFrom('from@example.com');

        $result = $transport->send($message);

        $this->assertEquals(1, $result, 'One plaintext message should have been sent to Mandrill');
    }

    public function testTransportSendHtml()
    {
        $container = $this->createContainer();

        /** @var MandrillTransport $transport */
        $transport = $container->get('swiftmailer.mailer.transport.accord_mandrill');

        $message = new \Swift_Message('TEST SUBJECT', 'test html body', 'text/html');
        $message->setTo('to@example.com');
        $message->setFrom('from@example.com');

        $result = $transport->send($message);

        $this->assertEquals(1, $result, 'One HTML message should have been sent to Mandrill');
    }

    public function testTransportSendMultipart()
    {
        $container = $this->createContainer();

        /** @var MandrillTransport $transport */
        $transport = $container->get('swiftmailer.mailer.transport.accord_mandrill');

        $message = new \Swift_Message('TEST SUBJECT', '<p>test html body<p>', 'text/html');
        $message->setTo('to@example.com');
        $message->setFrom('from@example.com');

        $message->addPart('test text body', 'text/plain');

        $result = $transport->send($message);

        $this->assertEquals(1, $result, 'One multipart message should have been sent to Mandrill');
    }

}