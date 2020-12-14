<?php include "../templates/header.php"; ?>

<?php require "../connect.inc.php"; ?>
<?php require "../common.php"; ?>

<body>
    <?php
    session_start();
    $selectedEnglishPhrase = ($_REQUEST['q']);
    $_SESSION['index'] = $selectedEnglishPhrase;

    //search the db with the unique english phrase that is selected
    $sql = "SELECT * from translations 
         WHERE english = :selectedEnglishPhrase";

    $statement = $db->prepare($sql);
    $statement->bindParam(':selectedEnglishPhrase', $selectedEnglishPhrase, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $languages = array();


    $sql2 = 'SHOW COLUMNS FROM translations';
    $result2 = $db->query($sql2);


    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        $languages[] = $row2['Field'];
    }

    // remove id and english fields
    if (($key = array_search('id', $languages)) !== false) {
        array_splice($languages, $key, 1);
    }

    if (($key = array_search('english', $languages)) !== false) {
        array_splice($languages, $key, 1);
    }

    //populate all the forms with the different languages
    echo "<form method='post' action='create.php' id=save_form>";
    foreach ($languages as $language) {
        $value = $result[$language];

        echo "<label for='$language' id='$language-label' class='language-label-class'>" . escape($language) . "</label>";
        echo "<input type='text' name='$language' id='$language-input' value='$value' class='language-class'>";
    }
    echo "<input type='submit' name='save' value='Save'>";
    echo "</form>";

    ?>
</body>