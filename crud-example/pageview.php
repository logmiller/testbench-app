<?php
// Autoload class files.
require __DIR__ . '/vendor/autoload.php';

// Load Customer DB connector object.
$customer = new CRUD\Customers\CustomerConnection();
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Form to display the gridview for customers.">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="content view">
            <h2>Customer GridView</h2>
            <a href="submit.php" class="add-customer">Add another customer</a>
            <a href="index.html" class="homepage">Go back to Homepage</a>
            <table>
                <thead>
                    <tr>
                        <td>Customer ID</td>
                        <td>Firt Name</td>
                        <td>Last Name</td>
                        <td>Email</td>
                        <td>Phone Number</td>
                        <td>Address</td>
                        <td>City</td>
                        <td>State</td>
                        <td>Notes</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customer->getListOfCustomers(3, $cid) as $i => $customer): ?>
                    <tr>
                        <td><?=$customer->getCustomerID();?></td>
                        <td><?=$customer->getCustomerFirstName();?></td>
                        <td><?=$customer->getCustomerLastName();?></td>
                        <td><?=$customer->getCustomerEmail();?></td>
                        <td><?=$customer->getCustomerPhoneNumber();?></td>
                        <td><?=$customer->getCustomerLocationAddress();?></td>
                        <td><?=$customer->getCustomerLocationCity();?></td>
                        <td><?=$customer->getCustomerLocationState();?></td>
                        <td><?=$customer->getCustomerNotes();?></td>

                        <td class="actions">
                            <a href="update.php?cid=<?=$customer->getCustomerID();?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                            <a href="delete.php?cid=<?=$customer->getCustomerID();?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="pagination">
            <!-- Pagination: Previous Page -->  
            <?php if ($page > 1): ?>
                <a href="pageview.php?page=<?=$page-1?>&cid=<?=($cid + 3)?>"><i class="fas fa-angle-double-left fa-sm"></i><</a>
            <?php endif; ?>
            <!-- Pagination: Next Page --> 
            <?php if ($i == 2): ?> 
                <a href="pageview.php?page=<?=$page+1?>&cid=<?=$customer->getCustomerID()?>"><i class="fas fa-angle-double-right fa-sm"></i>></a>
            <?php endif; ?>
	        </div>
        </div>
    </body>
</html>