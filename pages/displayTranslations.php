<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../js/scripts.js"></script>

<?php
require '../connect.inc.php';
?>


<?php
require "../common.php";
$inputText = ($_GET['q']);
$languageSelected = ($_GET['r']);
$sql = 'SELECT * FROM translations WHERE MATCH (english) AGAINST (:inputText IN NATURAL LANGUAGE MODE)';
$statement = $db->prepare($sql);
$statement->bindParam(':inputText', $inputText, PDO::PARAM_STR);

$statement->execute();

if ($inputText == '') {
    echo "<strong>";
    echo "Phrases will be displayed here...";
    echo "</strong>";
} else {
    echo "<table id ='translated-table'>
    <tr>
    <th id='english-header'>english</th>
    <th>$languageSelected</th>
    </tr>";

    while ($row = $statement->fetch()) {
        echo "<tr>";
        echo "<td id='english-td'>" . escape($row['english']) . "</td>";
        echo "<td id='other-language-td'>" . escape($row[$languageSelected]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>