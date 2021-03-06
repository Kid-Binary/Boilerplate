<?php
// AppBundle/Entity/VendingMachine/VendingMachine.php
namespace AppBundle\Entity\VendingMachine;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Utility\Traits\DoctrineMapping\IdMapperTrait,
    AppBundle\Entity\Utility\Traits\DoctrineMapping\PseudoDeleteMapperTrait,
    AppBundle\Entity\VendingMachine\Utility\Interfaces\SyncVendingMachinePropertiesInterface;

/**
 * @ORM\Table(name="vending_machines")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VendingMachine\Repository\VendingMachineRepository")
 *
 * @UniqueEntity(fields="serial", message="vending_machine.serial.unique")
 * @UniqueEntity(fields="login", message="vending_machine.login.unique")
 * @UniqueEntity(fields="name", message="vending_machine.name.unique")
 */
class VendingMachine implements SyncVendingMachinePropertiesInterface
{
    use IdMapperTrait, PseudoDeleteMapperTrait;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\School\School", inversedBy="vendingMachines")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $school;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product\ProductVendingGroup", inversedBy="vendingMachines")
     * @ORM\JoinColumn(name="product_vending_group_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $productVendingGroup;

    #/**
    # * @ORM\OneToMany(targetEntity="AppBundle\Entity\NfcTag\NfcTag", mappedBy="vendingMachine", indexBy="code")
    # */
    #protected $nfcTags;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VendingMachine\VendingMachineSync", mappedBy="vendingMachine")
     */
    protected $vendingMachineSyncs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VendingMachine\VendingMachineEvent", mappedBy="vendingMachine")
     * @ORM\OrderBy({"occurredAt"="DESC"})
     */
    protected $vendingMachineEvents;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VendingMachine\VendingMachineLoad", mappedBy="vendingMachine")
     * @ORM\OrderBy({"loadedAt"="DESC"})
     */
    protected $vendingMachineLoad;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase\Purchase", mappedBy="vendingMachine")
     * @ORM\OrderBy({"syncPurchasedAt"="DESC"})
     */
    protected $purchases;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction\Transaction", mappedBy="vendingMachine")
     * @ORM\OrderBy({"syncTransactionAt"="DESC"})
     */
    protected $transactions;

    /**
     * @ORM\Column(type="string", length=16, unique=true)
     *
     * @Assert\NotBlank(message="vending_machine.serial.not_blank")
     * @Assert\Length(
     *      min=1,
     *      max=16,
     *      minMessage="vending_machine.serial.length.min",
     *      maxMessage="vending_machine.serial.length.max"
     * )
     */
    protected $serial;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, unique=true)
     * @Assert\Length(
     *      min=4,
     *      max=64,
     *      minMessage="vending_machine.login.length.min",
     *      maxMessage="vending_machine.login.length.max"
     * )
     */
    protected $login;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\Length(
     *      min=8,
     *      max=64,
     *      minMessage="vending_machine.password.length.min",
     *      maxMessage="vending_machine.password.length.max"
     * )
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=250, nullable=true, unique=true)
     *
     * @Assert\Length(
     *      min=2,
     *      max=250,
     *      minMessage="vending_machine.name.length.min",
     *      maxMessage="vending_machine.name.length.max"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9\p{L}-\s]+$/u",
     *     message="vending_machine.name.regex"
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     *
     * @Assert\Length(
     *      min=2,
     *      max=500,
     *      minMessage="vending_machine.name_technician.length.min",
     *      maxMessage="vending_machine.name_technician.length.max"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z\p{L}-\s]+$/u",
     *     message="common.human_name.regex"
     * )
     */
    protected $nameTechnician;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Assert\Range(
     *      min=1,
     *      max=100,
     *      minMessage="vending_machine.number_shelves.range.min",
     *      maxMessage="vending_machine.number_shelves.range.max"
     * )
     */
    protected $numberShelves;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Assert\Range(
     *      min=1,
     *      max=1000,
     *      minMessage="vending_machine.number_springs.range.min",
     *      maxMessage="vending_machine.number_springs.range.max"
     * )
     */
    protected $numberSprings;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $vendingMachineLoadedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $vendingMachineSyncedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nfcTags              = new ArrayCollection;
        $this->purchases            = new ArrayCollection;
        $this->vendingMachineSyncs  = new ArrayCollection;
        $this->vendingMachineEvents = new ArrayCollection;
        $this->vendingMachineLoad   = new ArrayCollection;
    }

    public function getSearchProperties()
    {
        $searchProperties = [
            $this->getSerial(),
            $this->getName(),
        ];

        if( $this->getVendingMachineSyncedAt() ) {
            $searchProperties[] = $this->getVendingMachineSyncedAt()->format('Y-m-d');
        }

        if( $this->getProductVendingGroup() ) {
            $searchProperties[] = $this->getProductVendingGroup()->getName();
        }

        if( $this->getSchool() ) {
            $searchProperties[] = $this->getSchool()->getName();
            $searchProperties[] = $this->getSchool()->getAddress();

            if( $this->getSchool()->getSettlement() ) {
                $searchProperties[] = $this->getSchool()->getSettlement()->getName();

                if( $this->getSchool()->getSettlement()->getRegion() ) {
                    $searchProperties[] = $this->getSchool()->getSettlement()->getRegion()->getName();
                }
            }
        }

        return $searchProperties;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return VendingMachine
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return VendingMachine
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return VendingMachine
     */
    public function setPassword($password)
    {
        if( !is_null($password) ) {
            $this->password = $password;
        }

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return VendingMachine
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameTechnician
     *
     * @param string $nameTechnician
     * @return VendingMachine
     */
    public function setNameTechnician($nameTechnician)
    {
        $this->nameTechnician = $nameTechnician;

        return $this;
    }

    /**
     * Get nameTechnician
     *
     * @return string
     */
    public function getNameTechnician()
    {
        return $this->nameTechnician;
    }

    /**
     * Set numberShelves
     *
     * @param integer $numberShelves
     * @return VendingMachine
     */
    public function setNumberShelves($numberShelves)
    {
        $this->numberShelves = $numberShelves;

        return $this;
    }

    /**
     * Get numberShelves
     *
     * @return integer
     */
    public function getNumberShelves()
    {
        return $this->numberShelves;
    }

    /**
     * Set numberSprings
     *
     * @param integer $numberSprings
     * @return VendingMachine
     */
    public function setNumberSprings($numberSprings)
    {
        $this->numberSprings = $numberSprings;

        return $this;
    }

    /**
     * Get numberSprings
     *
     * @return integer
     */
    public function getNumberSprings()
    {
        return $this->numberSprings;
    }

    /**
     * Set vendingMachineLoadedAt
     *
     * @param \DateTime $vendingMachineLoadedAt
     * @return VendingMachine
     */
    public function setVendingMachineLoadedAt($vendingMachineLoadedAt)
    {
        $this->vendingMachineLoadedAt = $vendingMachineLoadedAt;

        return $this;
    }

    /**
     * Get vendingMachineLoadedAt
     *
     * @return \DateTime
     */
    public function getVendingMachineLoadedAt()
    {
        return $this->vendingMachineLoadedAt;
    }

    /**
     * Set vendingMachineSyncedAt
     *
     * @param \DateTime $vendingMachineSyncedAt
     * @return VendingMachine
     */
    public function setVendingMachineSyncedAt($vendingMachineSyncedAt)
    {
        $this->vendingMachineSyncedAt = $vendingMachineSyncedAt;

        return $this;
    }

    /**
     * Get vendingMachineSyncedAt
     *
     * @return \DateTime
     */
    public function getVendingMachineSyncedAt()
    {
        return $this->vendingMachineSyncedAt;
    }

    /**
     * Set school
     *
     * @param \AppBundle\Entity\School\School $school
     * @return VendingMachine
     */
    public function setSchool(\AppBundle\Entity\School\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \AppBundle\Entity\School\School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set productVendingGroup
     *
     * @param \AppBundle\Entity\Product\ProductVendingGroup $productVendingGroup
     * @return VendingMachine
     */
    public function setProductVendingGroup(\AppBundle\Entity\Product\ProductVendingGroup $productVendingGroup = null)
    {
        $this->productVendingGroup = $productVendingGroup;

        return $this;
    }

    /**
     * Get productVendingGroup
     *
     * @return \AppBundle\Entity\Product\ProductVendingGroup
     */
    public function getProductVendingGroup()
    {
        return $this->productVendingGroup;
    }

    #/**
    # * Add nfcTag
    # *
    # * @param \AppBundle\Entity\NfcTag\NfcTag $nfcTag
    # * @return VendingMachine
    # */
    #public function addNfcTag(\AppBundle\Entity\NfcTag\NfcTag $nfcTag)
    #{
    #    $nfcTag->setVendingMachine($this);
    #    $this->nfcTags[] = $nfcTag;
    #
    #    return $this;
    #}

    #/**
    # * Remove nfcTags
    # *
    # * @param \AppBundle\Entity\NfcTag\NfcTag $nfcTags
    # */
    #public function removeNfcTag(\AppBundle\Entity\NfcTag\NfcTag $nfcTags)
    #{
    #    $this->nfcTags->removeElement($nfcTags);
    #}

    #/**
    # * Get nfcTags
    # *
    # * @return \Doctrine\Common\Collections\Collection
    # */
    #public function getNfcTags()
    #{
    #    return $this->nfcTags;
    #}

    /**
     * Add vendingMachineSync
     *
     * @param \AppBundle\Entity\VendingMachine\VendingMachineSync $vendingMachineSync
     * @return VendingMachine
     */
    public function addVendingMachineSync(\AppBundle\Entity\VendingMachine\VendingMachineSync $vendingMachineSync)
    {
        $vendingMachineSync->setVendingMachine($this);
        $this->vendingMachineSyncs[] = $vendingMachineSync;

        return $this;
    }

    /**
     * Remove vendingMachineSyncs
     *
     * @param \AppBundle\Entity\VendingMachine\VendingMachineSync $vendingMachineSyncs
     */
    public function removeVendingMachineSync(\AppBundle\Entity\VendingMachine\VendingMachineSync $vendingMachineSyncs)
    {
        $this->vendingMachineSyncs->removeElement($vendingMachineSyncs);
    }

    /**
     * Get vendingMachineSyncs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVendingMachineSyncs()
    {
        return $this->vendingMachineSyncs;
    }

    /**
     * Add purchase
     *
     * @param \AppBundle\Entity\Purchase\Purchase $purchase
     * @return VendingMachine
     */
    public function addPurchase(\AppBundle\Entity\Purchase\Purchase $purchase)
    {
        $purchase->setVendingMachine($this);
        $this->purchases[] = $purchase;

        return $this;
    }

    /**
     * Remove purchases
     *
     * @param \AppBundle\Entity\Purchase\Purchase $purchases
     */
    public function removePurchase(\AppBundle\Entity\Purchase\Purchase $purchases)
    {
        $this->purchases->removeElement($purchases);
    }

    /**
     * Set purchases
     *
     * @return VendingMachine
     */
    public function setPurchases($purchases)
    {
        $this->purchases = $purchases;

        return $this;
    }

    /**
     * Get purchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * Add vendingMachineEvent
     *
     * @param \AppBundle\Entity\VendingMachine\VendingMachineEvent $vendingMachineEvent
     * @return VendingMachine
     */
    public function addVendingMachineEvent(\AppBundle\Entity\VendingMachine\VendingMachineEvent $vendingMachineEvent)
    {
        $vendingMachineEvent->setVendingMachine($this);
        $this->vendingMachineEvents[] = $vendingMachineEvent;

        return $this;
    }

    /**
     * Remove vendingMachineEvents
     *
     * @param \AppBundle\Entity\VendingMachine\VendingMachineEvent $vendingMachineEvents
     */
    public function removeVendingMachineEvent(\AppBundle\Entity\VendingMachine\VendingMachineEvent $vendingMachineEvents)
    {
        $this->vendingMachineEvents->removeElement($vendingMachineEvents);
    }

    /**
     * Get vendingMachineEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVendingMachineEvents()
    {
        return $this->vendingMachineEvents;
    }

    /**
     * Add vendingMachineLoad
     *
     * @param \AppBundle\Entity\VendingMachine\VendingMachineLoad $vendingMachineLoad
     * @return VendingMachine
     */
    public function addVendingMachineLoad(\AppBundle\Entity\VendingMachine\VendingMachineLoad $vendingMachineLoad)
    {
        $vendingMachineLoad->setVendingMachine($this);
        $this->vendingMachineLoad[] = $vendingMachineLoad;

        return $this;
    }

    /**
     * Remove vendingMachineLoad
     *
     * @param \AppBundle\Entity\VendingMachine\VendingMachineLoad $vendingMachineLoad
     */
    public function removeVendingMachineLoad(\AppBundle\Entity\VendingMachine\VendingMachineLoad $vendingMachineLoad)
    {
        $this->vendingMachineLoad->removeElement($vendingMachineLoad);
    }

    /**
     * Get vendingMachineLoad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVendingMachineLoad()
    {
        return $this->vendingMachineLoad;
    }

    /**
     * Add transactions
     *
     * @param \AppBundle\Entity\Transaction\Transaction $transactions
     * @return VendingMachine
     */
    public function addTransaction(\AppBundle\Entity\Transaction\Transaction $transactions)
    {
        $transactions->setVendingMachine($this);
        $this->transactions[] = $transactions;

        return $this;
    }

    /**
     * Remove transactions
     *
     * @param \AppBundle\Entity\Transaction\Transaction $transactions
     */
    public function removeTransaction(\AppBundle\Entity\Transaction\Transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    public function getChoiceLabel()
    {
        return "{$this->serial}" . (( $this->name ) ? " ({$this->name})" : NULL);
    }

    static public function getSyncArrayName()
    {
        return self::VENDING_MACHINE_ARRAY;
    }

    /**
     * Shortcut to get products if possible
     *
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getProducts()
    {
        return ( $this->getProductVendingGroup() )
            ? $this->getProductVendingGroup()->getProducts()
            : [];
    }

    /**
     * Shortcut to get students if possible
     *
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getStudents()
    {
        return ( $this->getSchool() )
            ? $this->getSchool()->getStudents()
            : [];
    }

    /**
     * Set pseudoDeleteAt
     *
     * @param \DateTime $pseudoDeleteAt
     * @return VendingMachine
     */
    public function setPseudoDeleteAt($pseudoDeleteAt)
    {
        $this->pseudoDeleteAt = $pseudoDeleteAt;

        return $this;
    }

    /**
     * Get pseudoDeleteAt
     *
     * @return \DateTime
     */
    public function getPseudoDeleteAt()
    {
        return $this->pseudoDeleteAt;
    }
}
