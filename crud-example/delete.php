<?php
/**
 * Customer deletion form for CRUD application.
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
        <meta name="description" content="Form to delete an existing customer.">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>

<?php if (isset($_POST['submit'])):?>
 <?php
    try {
        $pdo = new CRUD\Database\Connection();
        // Delete Customer data from CustomerNotes table.
        $pdo->prepare("DELETE FROM CustomerNotes WHERE CustomerID = ?", array(
            $_POST['cid']
        ));
        // Delete Customer data from CustomerList table.
        $pdo->prepare("DELETE FROM CustomerList WHERE FirstName = ? AND LastName = ? AND CustomerID = ?", array(
            $_POST['fname'],
            $_POST['lname'],
            $_POST['cid']
        ));
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
                                <li><span class="list-item">Customer was successfully deleted.</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php endif;?>
<?php 
        // Set placeholder values.
        $placeholder = array('cid' => '','fname' => '','lname' => '');
        if (isset($_GET['cid'])) {
            $customer = new CRUD\Customers\CustomerConnection();
            $customer = $customer->getCustomer($_GET['cid']);
            $placeholder['cid'] = $customer[0]->getCustomerID();
            $placeholder['fname'] = $customer[0]->getCustomerFirstName();
            $placeholder['lname'] = $customer[0]->getCustomerLastName();
        }
?>
        <div class="submission">
            <form id="customer_form" name="submit_customer" method="post">
            <!-- <form id="customer_form" name="submit_customer" action="success.php" method="post"> -->  
                <div class="border-box">
                    <div class="border-box-inner">
                        <h1 class="wsp-margin">Delete Customer</h1>
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