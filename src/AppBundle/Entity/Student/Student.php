<?php
// AppBundle/Entity/Student/Student.php
namespace AppBundle\Entity\Student;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Utility\Traits\DoctrineMapping\IdMapperTrait,
    AppBundle\Entity\Utility\Traits\DoctrineMapping\PseudoDeleteMapperTrait,
    AppBundle\Validator\Constraints as CustomAssert;

/**
 * @ORM\Table(name="students")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Student\Repository\StudentRepository")
 */
class Student
{
    use IdMapperTrait, PseudoDeleteMapperTrait;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Employee", inversedBy="students")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\School\School", inversedBy="students")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $school;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer\Customer", inversedBy="students")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $customer;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\NfcTag\NfcTag", mappedBy="student")
     */
    protected $nfcTag;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Product\Product", inversedBy="students")
     * @ORM\JoinTable(name="students_products")
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase\Purchase", mappedBy="student")
     * @ORM\OrderBy({"syncPurchasedAt"="DESC"})
     */
    protected $purchases;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseService\PurchaseService", mappedBy="student")
     * @ORM\OrderBy({"purchasedAt"="DESC"})
     */
    protected $purchasesService;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment\PaymentReceipt", mappedBy="student")
     * @ORM\OrderBy({"receiptDate"="DESC"})
     */
    protected $paymentsReceipts;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction\Transaction", mappedBy="student")
     * @ORM\OrderBy({"syncTransactionAt"="DESC"})
     */
    protected $transactions;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="common.human_name.length.min",
     *      maxMessage="common.human_name.length.max"
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z\p{L}-’`]+$/u",
     *     message = "common.human_name.regex"
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="common.human_name.length.min",
     *      maxMessage="common.human_name.length.max"
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z\p{L}-’`]+$/u",
     *     message = "common.human_name.regex"
     * )
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="common.human_name.length.min",
     *      maxMessage="common.human_name.length.max"
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z\p{L}-’`]+$/u",
     *     message = "common.human_name.regex"
     * )
     */
    protected $patronymic;

    /**
     * Unmapped property
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=6)
     *
     * @Assert\Choice(
     *      choices = {"male", "female"},
     *      message = "student.gender.choice"
     * )
     */
    protected $gender;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\Date(
     *      message = "common.date.valid"
     * )
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @CustomAssert\IsPriceConstraint
     */
    protected $totalLimit;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @CustomAssert\IsPriceConstraint
     */
    protected $dailyLimit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection;
    }

    public function getSearchProperties()
    {
        $searchProperties = [
            $this->getName(),
            $this->getSurname(),
            $this->getPatronymic(),
        ];

        if( $this->getSchool() ) {
            $searchProperties[] = $this->getSchool()->getName();
            $searchProperties[] = $this->getSchool()->getAddress();
        }

        if( $this->getNfcTag() ) {
            $searchProperties[] = $this->getNfcTag()->getNumber();
        }

        if( $this->getCustomer() ) {
            $searchProperties[] = $this->getCustomer()->getName();
            $searchProperties[] = $this->getCustomer()->getSurname();
            $searchProperties[] = $this->getCustomer()->getPatronymic();
        }

        return $searchProperties;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Student
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
     * Set surname
     *
     * @param string $surname
     * @return Student
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set patronymic
     *
     * @param string $patronymic
     * @return Student
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * Get patronymic
     *
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Student
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return Student
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set totalLimit
     *
     * @param string $totalLimit
     * @return Student
     */
    public function setTotalLimit($totalLimit)
    {
        $this->totalLimit = $totalLimit;

        return $this;
    }

    /**
     * Get totalLimit
     *
     * @return string
     */
    public function getTotalLimit()
    {
        return $this->totalLimit;
    }

    /**
     * Set dailyLimit
     *
     * @param string $dailyLimit
     * @return Student
     */
    public function setDailyLimit($dailyLimit)
    {
        $this->dailyLimit = $dailyLimit;

        return $this;
    }

    /**
     * Get dailyLimit
     *
     * @return string
     */
    public function getDailyLimit()
    {
        return $this->dailyLimit;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     * @return Student
     */
    public function setEmployee(\AppBundle\Entity\Employee\Employee $employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set school
     *
     * @param \AppBundle\Entity\School\School $school
     * @return Student
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
     * Set customer
     *
     * @param \AppBundle\Entity\Customer\Customer $customer
     * @return Student
     */
    public function setCustomer(\AppBundle\Entity\Customer\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set nfcTag
     *
     * @param \AppBundle\Entity\NfcTag\NfcTag $nfcTag
     * @return Student
     */
    public function setNfcTag(\AppBundle\Entity\NfcTag\NfcTag $nfcTag = null)
    {
        $this->nfcTag = $nfcTag;

        return $this;
    }

    /**
     * Get nfcTag
     *
     * @return \AppBundle\Entity\NfcTag\NfcTag
     */
    public function getNfcTag()
    {
        return $this->nfcTag;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product\Product $product
     * @return Student
     */
    public function addProduct(\AppBundle\Entity\Product\Product $product)
    {
        $product->addStudent($this);
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \AppBundle\Entity\Product\Product $products
     */
    public function removeProduct(\AppBundle\Entity\Product\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add purchase
     *
     * @param \AppBundle\Entity\Purchase\Purchase $purchase
     * @return Student
     */
    public function addPurchase(\AppBundle\Entity\Purchase\Purchase $purchase)
    {
        $purchase->setStudent($this);
        $this->purchases[] = $purchases;

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
     * Get purchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * Add purchasesService
     *
     * @param \AppBundle\Entity\PurchaseService\PurchaseService $purchasesService
     * @return Student
     */
    public function addPurchasesService(\AppBundle\Entity\PurchaseService\PurchaseService $purchasesService)
    {
        $purchasesService->setStudent($this);
        $this->purchasesService[] = $purchasesService;

        return $this;
    }

    /**
     * Remove purchasesService
     *
     * @param \AppBundle\Entity\PurchaseService\PurchaseService $purchasesService
     */
    public function removePurchasesService(\AppBundle\Entity\PurchaseService\PurchaseService $purchasesService)
    {
        $this->purchasesService->removeElement($purchasesService);
    }

    /**
     * Get purchasesService
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchasesService()
    {
        return $this->purchasesService;
    }

    /**
     * Add paymentsReceipt
     *
     * @param \AppBundle\Entity\Payment\PaymentReceipt $paymentsReceipt
     * @return Student
     */
    public function addPaymentsReceipt(\AppBundle\Entity\Payment\PaymentReceipt $paymentsReceipt)
    {
        $paymentsReceipt->setStudent($this);
        $this->paymentsReceipts[] = $paymentsReceipt;

        return $this;
    }

    /**
     * Remove paymentsReceipts
     *
     * @param \AppBundle\Entity\Payment\PaymentReceipt $paymentsReceipts
     */
    public function removePaymentsReceipt(\AppBundle\Entity\Payment\PaymentReceipt $paymentsReceipts)
    {
        $this->paymentsReceipts->removeElement($paymentsReceipts);
    }

    /**
     * Get paymentsReceipts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentsReceipts()
    {
        return $this->paymentsReceipts;
    }

    /**
     * Add transactions
     *
     * @param \AppBundle\Entity\Transaction\Transaction $transactions
     * @return Student
     */
    public function addTransaction(\AppBundle\Entity\Transaction\Transaction $transactions)
    {
        $transactions->setStudent($this);
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

    /**
     * Shortcut to get products if possible
     *
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getRestrictedProducts()
    {
        if( $this->getNfcTag() )
        {
            if( $this->getNfcTag()->getVendingMachine() )
            {
                if( $this->getNfcTag()->getVendingMachine()->getProductVendingGroup() )
                {
                    return $this->getNfcTag()->getVendingMachine()->getProductVendingGroup()->getProducts();
                }
            }
        }

        return NULL;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getFullName()
    {
        if( $this->fullName != NULL )
            return $this->fullName;

        if( !$this->patronymic && !$this->name && !$this->surname )
            return NULL;

        return "{$this->surname} {$this->name} {$this->patronymic}";
    }

    /**
     * Set pseudoDeleteAt
     *
     * @param \DateTime $pseudoDeleteAt
     * @return Student
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
