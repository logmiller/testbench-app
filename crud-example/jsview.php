<?php
// Autoload class files.
require __DIR__ . '/vendor/autoload.php';

// Load Customer DB connector object.
$customer = new CRUD\Customers\CustomerConnection();
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Form to display the gridview for customers.">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="content view">
            <h2>Customer GridView</h2>
            <a href="submit.php" class="add-customer">Add another customer</a>
            <a href="index.html" class="homepage">Go back to Homepage</a>
            <div class="form-group">
                <!-- filter -->
                <!-- toggle sort -->
                <textarea id="txtsearch" rows="1" cols="25"></textarea>
                <span>Sort</span>
                <label id="toggle-sort" class="toggle">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
                <div id="gridview"></div>
            </div>
            <script>
                $(document).ready(function(){
                    // default table view.
                    $.ajax({
                        type: 'post',
                        url: 'search.php',
                        data: {
                            'columnName': 'FirstName', // TODO: Expand it to other filters
                            'searchTerm': String(SearchTerm()),
                            'sortOrder': 0
                        },
                        dataType: 'json',
                        success: RebuildGridview
                    });
                    // toggle sort.
                    $("input[type=checkbox]").click(function () {
                        $.ajax({
                            type: 'post',
                            url: 'search.php',
                            data: {
                                'columnName': 'FirstName', // TODO: Expand it to other filters
                                'searchTerm': String(SearchTerm()),
                                'sortOrder': $("input[type=checkbox]").prop("checked") ? 1 : 0
                            },
                            dataType: 'json',
                            success: RebuildGridview
                        });
                    });
                });
            </script>
 
            <script type="text/javascript">
                $("body").on("keyup","[id*=txtsearch]", function () {
                    GetCustomers();
                });
                function SearchTerm() {
                    return jQuery.trim($("[id*=txtsearch]").val());
                };
                function GetCustomers() {
                    $.ajax({
                        type: 'post',
                        url: 'search.php',
                        data: {
                            'columnName': 'FirstName', // TODO: Expand it to other filters
                            'searchTerm': String(SearchTerm()),
                            'sortOrder': $("input[type=checkbox]").prop("checked") ? 1 : 0
                        },
                        dataType: 'json',
                        success: RebuildGridview
                    });
                };
                function RebuildGridview(customers) {

                    // Builds out the table header.
                    var header = ['Customer ID', 'First Name', 'Last Name', 'Email', 'Phone Number', 'Address', 'City', 'State', 'Note', 'Options'];
                    var table = $('<table>');
                    var thead = $('<thead>').appendTo(table);
                    tr = $('<tr>').appendTo(thead);
                    $(header).each(function(i){
                        var th = $('<td>',{'html':header[i]}).appendTo(tr);
                    });

                    // Builds out the table body.
                    var tbody = $('<tbody>').appendTo(table);
                    if (customers != null && customers.length > 0) {
                        $.each(customers, function (i) {
                            tr = $('<tr>').appendTo(tbody);
                            $.each(customers[i], function (ref) {
                                $('<td>',{'html':customers[i][ref]}).appendTo(tr);
                            });
                            // Add editor links.
                            tda = $('<td>').addClass('actions').appendTo(tr);
                            l1 = $('<a>').attr('href', "update.php?cid=" + customers[i]['cid']).addClass('edit').appendTo(tda);
                            $('<i>').addClass('fas fa-pen fa-xs').appendTo(l1);
                            l2 = $('<a>').attr('href', "delete.php?cid="+ customers[i]['cid']).addClass('trash').appendTo(tda);
                            $('<i>').addClass('fas fa-trash fa-xs').appendTo(l2);
                        });
                        $("#gridview").html(table);
                    } else {
                        $("#gridview").html("No records found for the search criteria.");
                    }
                }
            </script>
        </div>
    </body>
</html>