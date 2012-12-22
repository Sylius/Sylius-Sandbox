<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\AddressingBundle\Model\ZoneInterface;

/**
 * Default zone fixtures.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class LoadZonesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->createZone('Yugoslavia', ZoneInterface::TYPE_COUNTRY, array('RS', 'ME', 'MK', 'BA', 'HR', 'SI'));
        $this->createZone('Czechoslovakia', ZoneInterface::TYPE_COUNTRY, array('CZ', 'SK'));
        $this->createZone('USA GMT-8', ZoneInterface::TYPE_PROVINCE, array('WA', 'OR', 'NV', 'ID', 'CA'));
        $this->createZone('Yugoslavia + USA GMT-8', ZoneInterface::TYPE_ZONE, array('Yugoslavia', 'USA GMT-8'));

        $manager->flush();
    }

    private function createZone($name, $type, array $members)
    {
        $zone = $this->getZoneRepository()->createNew();
        $zone->setName($name);
        $zone->setType($type);

        foreach ($members as $id) {
            $zoneMember = $this->get('sylius_addressing.repository.zone_member_'.$type)->createNew();
            call_user_func(array(
                $zoneMember, 'set'.ucfirst($type)),
                $this->getReference(ucfirst($type).'-'.$id)
            );

            $zone->addMember($zoneMember);
        }

        $this->setReference('Zone-'.$name, $zone);

        $this->getZoneManager()->persist($zone);
    }

    private function getZoneRepository()
    {
        return $this->get('sylius_addressing.repository.zone');
    }

    private function getZoneManager()
    {
        return $this->get('sylius_addressing.manager.zone');
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
    }
}
