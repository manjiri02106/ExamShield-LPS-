<?php

include("../config/database.php");

$id=$_POST['id'];

$subject=$_POST['subject'];
$category=$_POST['category'];
$difficulty=$_POST['difficulty'];

$question=$_POST['question'];

$a=$_POST['a'];
$b=$_POST['b'];
$c=$_POST['c'];
$d=$_POST['d'];

$answer=$_POST['answer'];

$sql="UPDATE questions SET

subject='$subject',
category='$category',
difficulty='$difficulty',
question='$question',
option_a='$a',
option_b='$b',
option_c='$c',
option_d='$d',
correct_answer='$answer'

WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
    header("Location:index.php");
}
else
{
    echo "Update Failed";
}

?>
