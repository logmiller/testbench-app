<?php
/**
 * PHP Implementation of the CRUD TestBench.
 * 
 * @author Logan Miller
 */
namespace CRUD\Customers;


class Customer
{
    
    /**
     * The customer id.
     * 
     * @var int
     */
    protected $customerid;
    
    /**
     * The customer first name.
     * 
     * @var string
     */
    protected $firstname;
    
    /**
     * Get customer last name.
     * 
     * @var string
     */
    protected $lastname;
    
    /**
     * Get customer email.
     * 
     * @var string
     */
    protected $email;
    
    /**
     * Get customer phone number.
     * 
     * @var string
     */
    protected $phone;
    
    /**
     * Get customer location address.
     * 
     * @var string
     */
    protected $address;
    
    /**
     * Get customer location city.
     * 
     * @var string
     */
    protected $city;
    
    /**
     * Get customer location state.
     * 
     * @var string
     */
    protected $state;
    
    
    /**
     * Request database connection to Customer.
     * @param array $customer The customer data pulled from the customer management system.
     */
    public function __construct(array $customer)
    {
        list($this->customerid, $this->firstname, $this->lastname, $this->email, $this->phone, $this->address, $this->city, $this->state, $this->notes) = array_values($customer);
    }
    
    /**
     * Get customer id.
     * @return string
     */
    public function getCustomerID()
    {
        return $this->customerid;
    }
    
    /**
     * Get customer first name.
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->firstname;
    }

    /**
     * Get customer last name.
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->lastname;
    }
    
    /**
     * Get customer email.
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->email;
    }
    
    /**
     * Get customer phone number.
     * @return string
     */
    public function getCustomerPhoneNumber()
    {
        return $this->phone;
    }
    
    /**
     * Get customer location address.
     * @return string
     */
    public function getCustomerLocationAddress()
    {
        return $this->address;
    }

    /**
     * Get customer location city.
     * @return string
     */
    public function getCustomerLocationCity()
    {
        return $this->city;
    }

    /**
     * Get customer location state.
     * @return string
     */
    public function getCustomerLocationState()
    {
        return $this->state;
    }
    
    /**
     * Get customer notes.
     * @return string
     */
    public function getCustomerNotes()
    {
        return $this->notes;
    }
   
}