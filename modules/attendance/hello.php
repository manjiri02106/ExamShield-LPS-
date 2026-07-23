<?php
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Hello ExamShield</title>";
echo "<style>
body{
    font-family:Arial,sans-serif;
    background:#f4f4f4;
    text-align:center;
    padding-top:100px;
}
h1{
    color:#2563eb;
}
p{
    color:#555;
    font-size:18px;
}
.box{
    width:500px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
}
</style>";
echo "</head>";
echo "<body>";

echo "<div class='box'>";
echo "<h1>🎉 Hello, ExamShield LPS!</h1>";
echo "<p>PHP is running successfully.</p>";
echo "<p>Welcome to your Internship Project.</p>";
echo "<hr>";
echo "<strong>Current Date:</strong> " . date("d-m-Y") . "<br>";
echo "<strong>Current Time:</strong> " . date("h:i:s A");
echo "</div>";

echo "</body>";
echo "</html>";
?>