<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border: 1px solid black;

        }

        table th {
            border: 1px solid black;
        }

        table td {
            border: 1px solid black;
        }
    </style>
</head>

<?php
//To Use the Data array and Fixate values like Salary , Category Sorting value ,
if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = [];
}
if (!isset($_SESSION['person_Salary'])) {
    $_SESSION['person_Salary'] = 0;
}
if (!isset($_SESSION['category_Expense'])) {
    $_SESSION['category_Expense'] = 0;
}
if (!isset($_SESSION['select_Category'])) {
    $_SESSION['select_Category'] = "";
}
if (!isset($_SESSION['person_Name'])) {
    $_SESSION['person_Name'] = "";
}
if (isset($_POST['resetData'])) {
    session_destroy();
}
?>
<body>
    <!-- To Get details of salary and expense head details -->

    <h3>Daily Expense Manager</h3><br>
    <div class="row" style="background-color:aquamarine ;margin-right:1% ; margin-top:0% ">

        <form action="session.php" method="POST">
            <div class="row">
                <p style="margin-left:2% ; padding-top:2%">Name: <input type="text" name="person" placeholder="Enter Your Name">&nbsp;&nbsp;
                    Salary: <input type="number" name="salary" placeholder="Enter Your Salary"><button style="margin-left:2% " type=submit name="personDetails">Submit</button></p>
            </div>
        </form>
        <form action="" method="POST">
            <p style="margin-left:2% ">Reset data:
                <button style="margin-left:2% " type=submit name="resetData">&#9850;</button>
            </p>
            <hr>
        </form>
    </div>
    <div class="row"></div>
    <form action="session.php" method="POST" style="background-color:aquamarine ;margin-right:1% ">
        <hr>
        <div class="row" style="padding-bottom:1% ">
            <label for="expense" style="margin-left:2%">Choose expense category:</label>
            <select name="expense_Head" required="required">
                <option selected hidden></option>
                <option value="Groceries">Groceries</option>
                <option value="Vegitables">Vegitables</option>
                <option value="Travelling">Travelling</option>
                <option value="Miscelaneous">Miscelaneous</option>
            </select>&nbsp;&nbsp;
            <p style="margin-left:2%">Item Bought: <input type="text" name="item" placeholder="What did you Buy ?" required="required">&nbsp;&nbsp;
                Quantity:<input type="number" name="quantity" placeholder="No. of Items Bought ?" required="required"></p>
            <p style="margin-left:2%">Item Rate:<input type="number" name="rate" placeholder="Rate of item ?" required="required">&nbsp;&nbsp;
                Date of Purchase:<input type="date" name="date" required="required"></p>
            <button style="margin-left:2% " type=submit name="submit">Submit</button>
        </div>
        <hr>
    </form>
    <br>
</body>
<?php
//To Print the User's name
echo "Hello " . $_SESSION['person_Name'];
echo "<br><br>";

// To Add button to Edit or delete
echo "<form action='session.php' method='POST'><input type='number' name='updated_Salary' placeholder='Update Your Salary Here!' required='required'>&nbsp;&nbsp;<button typ='submit' value='" . $_SESSION['person_Salary'] . "' name='update_Salary'>Update Salary</button></form>";
echo "<br>";

// To Display Expense data
$table_data .= "<table style=width:90%><tr><th>S.No.</th><th>Expense Head:<form action='' method='POST'> <label for='expense' style='margin-left:2%'>
<select name='select_Category' required='required'>
    <option selected hidden></option>
    <option value='Groceries'>Groceries</option>
    <option value='Vegitables'>Vegitables</option>
    <option value='Travelling'>Travelling</option>
    <option value='Miscelaneous'>Miscelaneous</option>
</select><button type='submit' name='view_Category'>&#8661;</button></form><br><br></th><th>Item Purchased:</th><th>Quantity:</th><th>Rate:</th><th>Date:</th><th>Amount Spent:</th><th>Action</th></tr>";

foreach ($_SESSION['data'] as $key => $value) {

    $temp1 = $temp1 + ($value['Quantity'] * $value['Rate']);
}

//Condition to Sort Elements as per the user's Selected Category
if (isset($_POST['view_Category'])) {
    $selected_Category = $_POST['select_Category'];
    $i = 1;
    $temp = 0;
    foreach ($_SESSION['data'] as $key => $value) {
        if ($selected_Category == $value['Expense_Head']) {
            $temp = $temp + ($value['Quantity'] * $value['Rate']);
            $table_data .= "<tr><td>" . $i . "</td>";
            $i++;

            foreach ($value as $key1 => $value1) {
                $table_data .= "<td>" . $value1 . "</td>";
            }
            $table_data .= '<td><form action="session.php" method="POST"><button type=submit name="edit">&#9998;</button><input type="hidden" name="index" value="' . $key . '"><button type=submit name="delete"> &#10060;</button></form></td>';
            $table_data .= '</tr>';
        }
    }

    $table_data .= "</table>";
}

//Else part to print the data by default.
else {

    $i = 1;
    $temp = 0;
    foreach ($_SESSION['data'] as $key => $value) {

        $temp = $temp + ($value['Quantity'] * $value['Rate']);
        $table_data .= "<tr><td>" . $i . "</td>";
        $i++;

        foreach ($value as $key1 => $value1) {
            $table_data .= "<td>" . $value1 . "</td>";
        }
        $table_data .= '<td><form action="session.php" method="POST"><button type=submit name="edit">&#9998;</button><input type="hidden" name="index" value="' . $key . '"><button type=submit name="delete"> &#10060;</button></form></td>';
        $table_data .= '</tr>';
    }
}

$table_data .= "</table>";
echo $table_data;
echo "<br> Your Total Category wise Expense is =Rs.".$temp;
echo "<br>";
echo "<br> Your Total Expense is=Rs." . $temp1;
echo "<br><br>";
echo "Your Remaining balance is =Rs." . ($_SESSION['person_Salary'] - $temp1);
?>
</html>