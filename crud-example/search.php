<?php

if(isset($_POST['columnName'])) {
    $column = $_POST['columnName'];
 }

if(isset($_POST['searchTerm'])) {
    $search = $_POST['searchTerm'];
}
if(isset($_POST['sortOrder'])) {
    $sort = ($_POST['sortOrder'] == 1) ? 'DESC' : 'ASC';
}

// Autoload class files.
require __DIR__ . '/vendor/autoload.php';

// Load Customer DB connector object.
$customer = new CRUD\Customers\CustomerConnection();
foreach ($customer->filterCustomers($column, $search, $sort) as $customer) {
    $cust[] = array(
        'cid' => $customer->getCustomerID(),
        'fname' => $customer->getCustomerFirstName(),
        'lname' => $customer->getCustomerLastName(),
        'email' => $customer->getCustomerEmail(),
        'phone' => $customer->getCustomerPhoneNumber(),
        'address' => $customer->getCustomerLocationAddress(),
        'city' => $customer->getCustomerLocationCity(),
        'state' => $customer->getCustomerLocationState(),
        'notes' => $customer->getCustomerNotes(),
    );
}
echo json_encode($cust);
?>