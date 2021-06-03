<?php
/**
 * PHP Implementation of the CRUD TestBench.
 * 
 * @author Logan Miller
 */
namespace CRUD\Customers;

use CRUD\Database;


class CustomerConnection extends Database\Connection {

    /**
     * The customer data.
     * 
     * @var array
     */
    protected $customers = [];

    /**
     * Total number of customers.
     * 
     * @var int
     */
    protected $count = 0;

    /**
     * Request database connection to customer data.
     * @param int $customer_id The customer id provided to the customer management system.
     */
    public function getCustomer(int $customer_id) {
        try {
            $pdo = new CustomerConnection();
            $data = $pdo->prepare("SELECT CustomerList.*, CustomerNotes.Note FROM CustomerList
            LEFT JOIN CustomerNotes ON CustomerList.CustomerID = CustomerNotes.CustomerID
            WHERE CustomerList.CustomerID = :cid", ['cid' => $customer_id])->fetch();
            $this->customers[] = new Customer($data);
            return $this->customers;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Request database connection to all customers.
     * @param string $sort Sets sorted method of returned results.
     */
    public function getAllCustomers($sort = 'ASC') {
        try {
            // validate sorted method.
            $sort = in_array($sort, array('ASC', 'DESC')) ? $sort : 'ASC';

            $pdo = new CustomerConnection();
            $data = $pdo->query("SELECT CustomerList.*, CustomerNotes.Note FROM CustomerList
            LEFT JOIN CustomerNotes ON CustomerList.CustomerID = CustomerNotes.CustomerID
            ORDER BY CustomerID {$sort}")->fetchAll();
            foreach($data as $customer) {
                $this->customers[] = new Customer($customer);  
            }
            return $this->customers;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Request database connection to all customers.
     * @param string $column Sets the table column to be searched.
     * @param string $search Search string.
     * @param string $sort Sets sorted method of returned results.
     */
    public function filterCustomers($column = FALSE, $search = '', $sort = 'ASC') {
        try {
            // validate sorted method.
            $sort = in_array($sort, array('ASC', 'DESC')) ? $sort : 'ASC';

            // Apply search term filtering.
            if(in_array($column, array('CustomerID', 'FirstName', 'LastName', 'Email', 'PhoneNumber', 'Address', 'City', 'State', 'Note'))) {
                $pdo = new CustomerConnection();
                if($column == 'Note') {
                    $data = $pdo->query("SELECT CustomerList.*, CustomerNotes.Note FROM CustomerList
                    LEFT JOIN CustomerNotes ON CustomerList.CustomerID = CustomerNotes.CustomerID
                    WHERE CustomerNotes.{$column} LIKE '%{$search}%'
                    ORDER BY CustomerID {$sort}")->fetchAll();
                } else {
                    $data = $pdo->query("SELECT CustomerList.*, CustomerNotes.Note FROM CustomerList
                    LEFT JOIN CustomerNotes ON CustomerList.CustomerID = CustomerNotes.CustomerID
                    WHERE CustomerList.{$column} LIKE '%{$search}%'
                    ORDER BY CustomerID {$sort}")->fetchAll();
                }
                foreach($data as $customer) {
                    $this->customers[] = new Customer($customer);  
                }
            }
            else {
                $this->customers[] = $this->getAllCustomers();
            }
            return $this->customers;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Get total customer count.
     */
    public function getCustomerCount() {
        try {
            $pdo = new CustomerConnection();
            $this->count = $pdo->query("SELECT COUNT(CustomerID) as count FROM CustomerList")->fetchColumn();
            return $this->count;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Request database connection to specific number of customers.
     * @param int $limit The customer row limit.
     * @param int $cid The customer identifier.
     */
    public function getListOfCustomers($limit = 10, $cid = 0) {
        try {
            $pdo = new CustomerConnection();
            if($cid <= 0) {
                $data = $pdo->prepare("SELECT CustomerList.*, CustomerNotes.Note FROM CustomerList
                LEFT JOIN CustomerNotes ON CustomerList.CustomerID = CustomerNotes.CustomerID
                ORDER BY CustomerList.CustomerID DESC
                LIMIT :limit", ['limit' => $limit])->fetchAll();
            } else {
                $data = $pdo->prepare("SELECT CustomerList.*, CustomerNotes.Note FROM CustomerList
                LEFT JOIN CustomerNotes ON CustomerList.CustomerID = CustomerNotes.CustomerID
                WHERE CustomerList.CustomerID < :cid
                ORDER BY CustomerList.CustomerID DESC
                LIMIT :limit", ['cid' => $cid, 'limit' => $limit])->fetchAll();
            }
            foreach($data as $customer) {
                $this->customers[] = new Customer($customer);  
            }
            return $this->customers;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

}