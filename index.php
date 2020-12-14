<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="css/style.css" />
<?php
// get all languages
require 'connect.inc.php';
$languages = array();
try {
   $sql = 'SHOW COLUMNS FROM translations';
   $result = $db->query($sql);
   while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $languages[] = $row['Field'];
   }
} catch (PDOException $error) {
   echo $sql . "<br>" . $error->getMessage();
}

if (($key = array_search('id', $languages)) !== false) {
   array_splice($languages, $key, 1);
}

if (($key = array_search('english', $languages)) !== false) {
   array_splice($languages, $key, 1);
}
?>

<div id='main-page' class='main-page'>

   <div id='left-side-main'>
      <a href="pages/create.php"><strong>Create</strong></a> - Add English Phrases

      <h3>English</h3>
      <form method="post">
         <textarea placeholder="Enter an english phrase here..." name="english" id="english-translate-box"></textarea>
      </form>
   </div>

   <div id='right-side-main'>
      <div id='language-row'>
         <label for="languages">Choose a language:</label>
         <select name="languages" id="language-select">
            <?php
            foreach ($languages as $language) {
               echo "<option value='$language'>$language</option>";
            }
            ?>
         </select>
      </div>
      <div id="translatedPhrases"><b>Phrases will be displayed here...</b></div>
   </div>

</div>