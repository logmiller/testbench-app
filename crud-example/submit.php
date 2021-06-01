<?php
/**
 * Customer submission form for CRUD application.
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
        <meta name="description" content="Form to add a new customer.">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>

<?php if (isset($_POST['submit'])):?>
 <?php
    try {
        $pdo = new CRUD\Database\Connection();
        // Fetch latest unique insert id.
        $customer_id = $pdo->query("SELECT MAX(CustomerID)+1 as CustomerID FROM CustomerList")->fetchColumn();
        $note_id     = $pdo->query("SELECT MAX(NoteID)+1 as NoteID FROM CustomerNotes")->fetchColumn();
        // Insert Customer note data into database.
        if (!empty($_POST['notes'])) {
            $pdo->prepare("INSERT INTO CustomerNotes (NoteID, Note, CustomerID) VALUES (?,?,?)", array(
                $note_id,
                $_POST['notes'],
                $customer_id
            ));
        }
        // Insert Customer data into database;
        $customer = array(
            $customer_id,
            $_POST['fname'],
            $_POST['lname'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['city'],
            $_POST['state']
        );
        $pdo->prepare("INSERT INTO CustomerList (CustomerID, FirstName, LastName, Email, PhoneNumber, Address, City, State) VALUES (?,?,?,?,?,?,?,?)", $customer);
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
                          <li><span class="list-item">Customer was submitted successfully.</span></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
<?php endif;?>
       <div class="submission">
            <form id="customer_form" name="submit_customer" method="post">
            <!-- <form id="customer_form" name="submit_customer" action="success.php" method="post"> -->  
                <div class="border-box">
                    <div class="border-box-inner">
                        <h1 class="wsp-margin">Add Customer</h1>
                        <!-- customer first name -->
                        <div class="wsp-margin">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" maxlength="32" id="fname" autocomplete="off" name="fname" required/>
                        </div>
                        <!-- customer last name -->
                        <div class="wsp-margin">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" maxlength="32" id="lname" autocomplete="off" name="lname" required/>
                        </div>  
                        <!-- customer email -->
                        <div class="wsp-margin">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" maxlength="128" id="email" autocomplete="off" name="email" size="30" required/>
                        </div>
                        <!-- customer phone number -->
                        <div class="wsp-margin">
                            <label for="phone" class="form-label">Phone number</label>
                            <input type="tel" maxlength="16" id="phone" autocomplete="off" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="customer_phone" required>
                            <small>Accepted Format: 123-456-7890</small>
                        </div>
                        <!-- customer address -->
                        <div class="wsp-margin">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" maxlength="128" id="address" autocomplete="off" name="address" required/>
                        </div>
                        <!-- customer city -->
                        <div class="wsp-margin">
                            <label for="city" class="form-label">City</label>
                            <input type="text" maxlength="32" id="city" autocomplete="off" name="city" required/>
                        </div>
                        <!-- customer state -->
                        <div class="wsp-margin">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" required>
                            <?php $csv = array_map('str_getcsv', file(__DIR__ . '/util/states.txt')); ?>
                            <?php foreach($csv as $state): ?>
                                <option value="<?=$state[0]?>"><?=$state[1]?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- customer notes -->
                        <div class="wsp-margin">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" rows="5" cols="30"></textarea>
                        </div>
                        <!-- form submission -->
                        <div class="wsp-margin">
                            <span class="submit-button">
                              <span class="submit-button-inner">
                                <input type="submit" class="submit-button-input" name="submit"/>
                              </span>
                            </span>
                        </div>
                        <div class="wsp-margin">Go back to homepage?<a href="index.html">Click here.</a></div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>