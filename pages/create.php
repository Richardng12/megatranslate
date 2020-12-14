<?php include "../templates/header.php"; ?>
<link rel="stylesheet" href="../css/style.css" />

<?php

//connect to db
require '../connect.inc.php';
require "../common.php";

$englishPhrases = array();
$duplicate = false;

//get all english phrases, no need for parameter checking (sql injection)
try {
    $sql = 'SELECT english FROM translations';
    $result = $db->query($sql);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $englishPhrases[] = $row['english'];
    }
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

// Save updated translations to db
if (isset($_POST['save'])) {
    session_start();
    $name = $_SESSION['index'];

    try {
        $sql = "UPDATE translations
        SET 
        spanish = :spanish,
        chinese = :chinese,
        japanese =:japanese,
        french = :french,
        korean = :korean,
        russian =:russian,
        hindi = :hindi,
        italian = :italian
        WHERE english = '$name'";

        $statement = $db->prepare($sql);
        $statement->bindParam(':spanish', $_POST['spanish'], PDO::PARAM_STR);
        $statement->bindParam(':chinese', $_POST['chinese'], PDO::PARAM_STR);
        $statement->bindParam(':japanese', $_POST['japanese'], PDO::PARAM_STR);
        $statement->bindParam(':french', $_POST['french'], PDO::PARAM_STR);
        $statement->bindParam(':korean', $_POST['korean'], PDO::PARAM_STR);
        $statement->bindParam(':russian', $_POST['russian'], PDO::PARAM_STR);
        $statement->bindParam(':hindi', $_POST['hindi'], PDO::PARAM_STR);
        $statement->bindParam(':italian', $_POST['italian'], PDO::PARAM_STR);

        $statement->execute($user);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// add new english phrase to db
if (isset($_POST['submit'])) {
    try {

        $englishPhrase = ltrim($_POST['english']);
        $sqlCheck = "SELECT english from translations 
                        WHERE english = :englishPhrase";
        $statement = $db->prepare($sqlCheck);
        $statement->bindParam(':englishPhrase', $englishPhrase, PDO::PARAM_STR);
        $statement->execute();

        $fetch = $statement->fetch(PDO::FETCH_ASSOC);
        // check if theres a duplicate phrase already
        if (is_array($fetch)) {
            echo "<script type='text/javascript'>alert('Duplicate word');</script>";
            $duplicate = true;
        } else {
            //if no duplicate, enter into the db
            $duplicate = false;
            $sql = sprintf(
                "INSERT INTO translations (english) VALUES (:englishPhrase)"
            );

            $statement = $db->prepare($sql);
            $statement->bindParam(':englishPhrase', $englishPhrase, PDO::PARAM_STR);
            $statement->execute();
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}



//update table when submitting, by getting last row added to translations table
if (isset($_POST['submit']) && !$duplicate) {
    try {
        $sql = 'SELECT english FROM translations ORDER BY id DESC LIMIT 1;';
        $result = $db->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($englishPhrases, $row['english']);
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}


// Table of english phrases that gets populated
function englishPhrasesTable($phrases)
{
    foreach ($phrases as $phrase) {
        echo "<tr><td>" . escape($phrase) . "</td></tr>";
    }
}
?>

<div id='left-side'>
    <h2>Create Translations</h2>
    <div>
        <h3>English</h3>
        <form method="post">
            <textarea placeholder="Enter an english phrase here..." name="english" id="english-create-box"></textarea>
            <button type="submit" name="submit" value="Submit" class="submit-button" id="submit-button">Submit</button>
        </form>
    </div>

    <div id="scrollable-table">
        <table id="phrases-table">
            <tr>
                <th>Phrases</th>
            </tr>
            <?php englishPhrasesTable($englishPhrases) ?>
        </table>
    </div>
</div>


<div id='right-side'>
    <div id="languagesInput"><b>Languages will be displayed here...</b></div>
</div>

<a href="../index.php">Back to home</a>