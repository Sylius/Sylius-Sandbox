<?php

/*
 * This file is part of the Application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AddressingBundle\Tests\Entity;

use Sylius\Sandbox\Bundle\AddressingBundle\Entity\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getName());

        $address->setName('testing name');
        $this->assertEquals('testing name', $address->getName());
    }
    
    public function testSurname()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getSurname());
    
        $address->setSurname('testing surname');
        $this->assertEquals('testing surname', $address->getSurname());
    }
    
    public function testStreet()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getStreet());
    
        $address->setStreet('testing street');
        $this->assertEquals('testing street', $address->getStreet());
    }
    
    public function testPostcode()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getPostcode());
    
        $address->setPostcode('testing postcode');
        $this->assertEquals('testing postcode', $address->getPostcode());
    }
    
    public function testCity()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getCity());
    
        $address->setCity('testing city');
        $this->assertEquals('testing city', $address->getCity());
    }
    
    public function testPhone()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getPhone());
    
        $address->setPhone('testing phone');
        $this->assertEquals('testing phone', $address->getPhone());
    }
    
    public function testEmail()
    {
        $address = $this->getAddress();
        $this->assertNull($address->getEmail());
    
        $address->setEmail('testing email');
        $this->assertEquals('testing email', $address->getEmail());
    }

    protected function getAddress()
    {
        return $this->getMockForAbstractClass('Sylius\Sandbox\Bundle\AddressingBundle\Entity\Address');
    }
}
