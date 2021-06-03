<?php
// Autoload class files.
require __DIR__ . '/vendor/autoload.php';

// Load Customer DB connector object.
$customer = new CRUD\Customers\CustomerConnection();

$sent_value = $_POST['value'];
?>
<?php if(isset($sent_value)): ?>
    <?php if ($sent_value == 1): ?>
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
            <?php foreach ($customer->getAllCustomers('DESC') as $customer): ?>
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
    <?php echo "Sort / Filter"; ?>
    <?php else: ?>
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
            <?php foreach ($customer->getAllCustomers('ASC') as $customer): ?>
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
    <?php echo "Default Sort / No Filter"; ?>
    <?php endif; ?>
<?php else: ?>
<?php echo "Error"; ?>
<?php endif; ?>