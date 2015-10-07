<?php
// AppBundle/Service/Sync/SyncDataBuilder.php
namespace AppBundle\Service\Sync;

use DateTime;

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\PersistentCollection;

use AppBundle\Service\Sync\Utility\Interfaces\SyncDataInterface,
    AppBundle\Entity\VendingMachine\VendingMachine,
    AppBundle\Entity\VendingMachine\VendingMachineSync,
    AppBundle\Entity\Product\Product,
    AppBundle\Entity\NfcTag\NfcTag;

class SyncDataBuilder implements SyncDataInterface
{
    public function getRecordChecksum($data)
    {
        return hash('sha256', json_encode($data));
    }

    public function buildProductData(PersistentCollection $products)
    {
        $data = [];

        foreach($products as $product) {
            $data[] = $product->getSyncObjectData();
        }

        $data = [
            Product::getSyncArrayName() => $data
        ];

        $syncResponse = [
            self::SYNC_CHECKSUM => $this->getRecordChecksum($data),
            self::SYNC_DATA     => $data
        ];

        return $syncResponse;
    }

    public function buildNfcTagData(PersistentCollection $nfcTags)
    {
        $data = [];

        foreach($nfcTags as $key => $nfcTag) {
            $data[$key] = $nfcTag->getSyncObjectData();

            $data[$key][Product::getSyncArrayNameRestricted()] = NULL;

            foreach($nfcTag->getStudent()->getProducts() as $product) {
                $data[$key][Product::getSyncArrayNameRestricted()][] = $product->getSyncObjectDataRestricted();
            }
        }

        $data = [
            NfcTag::getSyncArrayName() => $data
        ];

        $syncResponse = [
            self::SYNC_CHECKSUM => $this->getRecordChecksum($data),
            self::SYNC_DATA     => $data
        ];

        return $syncResponse;
    }

    public function buildSyncData(VendingMachineSync $vendingMachineSync = NULL)
    {
        $data = NULL;

        if( $vendingMachineSync ) {
            $data[] = $vendingMachineSync->getSyncObjectData();
        }

        $data = [
            VendingMachineSync::getSyncArrayName() => $data
        ];

        $syncResponse = [
            self::SYNC_CHECKSUM => $this->getRecordChecksum($data),
            self::SYNC_DATA     => $data
        ];

        return $syncResponse;
    }
}