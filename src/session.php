<?php
session_start();
if (isset($_POST['personDetails'])){
    $person_Name=$_POST['person'];
    $person_Salary=$_POST['salary'];
    $_SESSION['person_Salary'] =  $_SESSION['person_Salary'] +$person_Salary;
    $_SESSION['person_Name'] = $person_Name;
    header("Location:index.php");
}

if (isset($_POST['submit'])) {
    if (! isset ($_SESSION['data'])){
        $_SESSION['data']=[];
    }
    $expense_head = $_POST['expense_Head'];
    $item_Purchased = $_POST['item'];
    $quantity=$_POST['quantity'];
    $rate=$_POST['rate'];
    $date=$_POST['date'];
    $amount_Spent = $rate * $quantity;
    $budget_Data = array(
        "Expense_Head" => $expense_head,
        "Items" => $item_Purchased,
        "Quantity" => $quantity,
        "Rate" => $rate,
        "Date" => $date ,
        "Amount_Spent" => $amount_Spent
    );
    array_push($_SESSION['data'] ,  $budget_Data);
header("Location:index.php");
}


//To Delete a row
if (isset($_POST['delete'])){
  $index_TO_Delete=$_POST['index'];
  array_splice($_SESSION['data'], $index_TO_Delete,1);
  header("Location:index.php");
}


//To Update salary
if (isset($_POST['update_Salary']))
{if ($_POST['updated_Salary'] < 0)
{    echo "<html>alert('Can not add negative value')</html>";
    header("Location:index.php");
}
else
{    $_SESSION['person_Salary']=$_POST['updated_Salary'];}
header("Location:index.php");
}
$varTemp;
//To Edit a Row
if (isset($_POST['edit'])){
    $index_TO_edit=$_POST['index'];
    echo "<form action='' method='POST' style='background-color:aquamarine ;margin-right:1% '>

    <hr>
    <div class='row' style='padding-bottom:2% '>
        <label for='expense' style='margin-left:2%'>Choose expense category:</label>
        <select name='expense_Head_Update' required='required'>
            <option selected >".$_SESSION['data'][$index_TO_edit]['Expense_Head']."</option>
        </select>
        <input type='text' name='item_Update' value='".$_SESSION['data'][$index_TO_edit]['Items']."' required='required'>&nbsp;&nbsp;
        <input type='number' name='quantity_Update' value='".$_SESSION['data'][$index_TO_edit]['Quantity']."' required='required'>&nbsp;&nbsp;
        <input type='number' name='rate_Update' value='".$_SESSION['data'][$index_TO_edit]['Rate']."' required='required'>&nbsp;&nbsp;
        <input type='date' name='date_Update' required='required' value='".$_SESSION['data'][$index_TO_edit]['Date']."'> <br>
        <input type='hidden' name='update' value='".$index_TO_edit."'><button style='margin-left:2% ' type=submit name='update_Cart'>Submit</button><br> 
    </div>
    <hr>
</form>";
}
if (isset($_POST['update_Cart'])){
    $index_TO_Edit=$_POST['update'];
    $_SESSION['data'][$index_TO_Edit]['Expense_Head']=$_POST['expense_Head_Update'];
    $_SESSION['data'][$index_TO_Edit]['Items'] = $_POST['item_Update'];
    $_SESSION['data'][$index_TO_Edit]['Quantity']=$_POST['quantity_Update'];
    $_SESSION['data'][$index_TO_Edit]['Rate']=$_POST['rate_Update'];
    $_SESSION['data'][$index_TO_Edit]['Date']=$_POST['date_Update'];
    $_SESSION['data'][$index_TO_Edit]['Amount_Spent'] = $_POST['rate_Update']  * $_POST['quantity_Update'];
    header("Location:index.php");
}
//To View Expenses Category Wise
// if (isset($_POST['view_Category'])){
//   $selected_Category=$_POST['select_Category'];
//   $category_Expense=0;
//   foreach ($_SESSION['data'] as $key => $value) {
//     foreach ($value as $key1 =>$value1){
//         if ($value['Expense_Head'] == $selected_Category){
//             $category_Expense=  $category_Expense + ($_SESSION['data'][$value]['Rate'] * $_SESSION['data'][$value]['Quantity']);
//         }
//     }
//   }
//   $_SESSION['select_Category']=$selected_Category;
//   $_SESSION['category_Expense']=$category_Expense;
//   header("Location:index.php");
// }
?>