<?php
/**
 * Customer update form for CRUD application.
 * 
 * @author Logan Miller
 */
// Autoload class files.
require __DIR__ . '/vendor/autoload.php';
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Form to update an existing customer.">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>

<?php if (isset($_POST['submit'])):?>
<?php
    try {
        $pdo = new CRUD\Database\Connection();
        // Update Customer based on CustomerID, as it cannot be modified.
        // TODO: Output customer not found if CustomerID does not match??
        
        // Update Customer data from CustomerNotes table.
        if (!empty($_POST['notes'])) {
            // Fetch latest unique insert id.
            $note_id = $pdo->prepare("SELECT NoteID FROM CustomerNotes WHERE CustomerID =?", array(
                $_POST['cid']
            ))->fetchColumn();
            if (empty($note_id)) {
                $note_id = $pdo->query("SELECT MAX(NoteID)+1 as NoteID FROM CustomerNotes")->fetchColumn();
            }
            $pdo->prepare("INSERT INTO CustomerNotes (NoteID, Note, CustomerID) VALUES(?,?,?) ON DUPLICATE KEY UPDATE NoteID = ?, Note = ?", array(
                $note_id,
                $_POST['notes'],
                $_POST['cid'],
                $note_id,
                $_POST['notes']
            ));
        }
        // Update Customer data from CustomerList table.
        $customer = array(
            $_POST['fname'],
            $_POST['lname'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['city'],
            $_POST['state'],
            $_POST['cid']
        );
        $pdo->prepare("UPDATE CustomerList SET FirstName = ?, LastName = ?, Email = ?, PhoneNumber = ?, Address = ?, City = ?, State = ? WHERE CustomerID = ?", $customer);
    }
    catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    unset($pdo);
?>
        <div class="confirmation-container">
            <div class="a-section">
                <div id="auth-error-message-box" class="border-box">
                    <div class="border-box-inner">
                        <h4 class="notification">Success</h4>
                        <div class="notification-content">
                            <ul class="unordered-list">
                                <li><span class="list-item">Customer was successfully updated.</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php endif;?>
<?php 
        // Set placeholder values.
        $placeholder = array('cid' => '','fname' => '','lname' => '','email' => '','phone' => '','address' => '','city' => '','state' => '', 'notes' => '');
        if (isset($_GET['cid'])) {
            $customer = new CRUD\Customers\CustomerConnection();
            $customer = $customer->getCustomer($_GET['cid']);
            $placeholder['cid'] = $customer[0]->getCustomerID();
            $placeholder['fname'] = $customer[0]->getCustomerFirstName();
            $placeholder['lname'] = $customer[0]->getCustomerLastName();
            $placeholder['email'] = $customer[0]->getCustomerEmail();
            $placeholder['phone'] = $customer[0]->getCustomerPhoneNumber();
            $placeholder['address'] = $customer[0]->getCustomerLocationAddress();
            $placeholder['city'] = $customer[0]->getCustomerLocationCity();
            $placeholder['state'] = $customer[0]->getCustomerLocationState();
            $placeholder['notes'] = $customer[0]->getCustomerNotes();
        }
?>
        <div class="submission">
            <form id="customer_form" name="submit_customer" method="post">
            <!-- <form id="customer_form" name="submit_customer" action="success.php" method="post"> -->
                <div class="border-box">
                    <div class="border-box-inner">
                        <h1 class="wsp-margin">Update Customer</h1>
                        <!-- customer first name -->
                        <div class="wsp-margin">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" maxlength="32" id="fname" autocomplete="off" name="fname" placeholder="<?=$placeholder['fname']?>" required/>
                        </div>
                        <!-- customer last name -->
                        <div class="wsp-margin">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" maxlength="32" id="lname" autocomplete="off" name="lname" placeholder="<?=$placeholder['lname']?>" required/>
                        </div>
                        <!-- customer id -->
                        <div class="wsp-margin">
                            <label for="cid" class="form-label">Customer ID</label>
                            <input type="number" min=1 maxlength="16" id="cid" autocomplete="off" name="cid" placeholder="<?=$placeholder['cid']?>" required/>
                        </div>
                        <!-- customer email -->
                        <div class="wsp-margin">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" maxlength="128" id="email" autocomplete="off" name="email" size="30" placeholder="<?=$placeholder['email']?>" required/>
                        </div>
                        <!-- customer phone number -->
                        <div class="wsp-margin">
                            <label for="phone" class="form-label">Phone number</label>
                            <input type="tel" maxlength="16" id="phone" autocomplete="off" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="<?=$placeholder['phone']?>" required>
                            <small>Accepted Format: 123-456-7890</small>
                        </div>
                        <!-- customer address -->
                        <div class="wsp-margin">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" maxlength="128" id="address" autocomplete="off" name="address" placeholder="<?=$placeholder['address']?>" required/>
                        </div>
                        <!-- customer city -->
                        <div class="wsp-margin">
                            <label for="city" class="form-label">City</label>
                            <input type="text" maxlength="32" id="city" autocomplete="off" name="city" placeholder="<?=$placeholder['city']?>" required/>
                        </div>
                        <!-- customer state -->
                        <div class="wsp-margin">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" required>
                            <?php $csv = array_map('str_getcsv', file(__DIR__ . '/util/states.txt')); ?>
                            <?php foreach($csv as $state): ?>
                                <?php if($state[0] == $placeholder['state']): ?>
                                    <option value="<?=$state[0]?>" selected><?=$state[1]?></option> <!-- current selection -->
                                <?php else: ?>
                                    <option value="<?=$state[0]?>"><?=$state[1]?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- customer notes -->
                        <div class="wsp-margin">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" rows="5" cols="30" placeholder="<?=$placeholder['notes']?>"></textarea>
                        </div>
                        <!-- form submission -->
                        <div class="wsp-margin">
                            <span class="submit-button">
                              <span class="submit-button-inner">
                                <input type="submit" class="submit-button-input" name="submit"/>
                              </span>
                            </span>
                        </div>
                        <div class="wsp-margin">Go back to home page?<a href="index.html">Click here.</a></div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>