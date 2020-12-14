// $.noConflict();

//open up editing tab for translated phrases, when clicking on an english phrase
jQuery(function () {
  var tableData;
  jQuery("#phrases-table").on("click", "tr", function () {
    tableData = jQuery(this)
      .children("td")
      .map(function () {
        return jQuery(this).text();
      })
      .get();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("languagesInput").innerHTML = this.responseText;
      }
    };
    selectedEnglishPhrase = tableData[0];
    xmlhttp.open(
      "GET",
      "../pages/viewTranslations.php?q=" + selectedEnglishPhrase,
      true
    );
    xmlhttp.send();
  });

  //default value
  var languageSelected = "spanish";
  var inputText;
  jQuery("#language-select").change(function () {
    //Selected value
    languageSelected = jQuery("#language-select").val();
    getTranslatedPhrases(inputText, languageSelected);
  });
  //debounce function for english phrase input
  var time_out;
  jQuery("#english-translate-box").keyup(function () {
    inputText = jQuery("#english-translate-box").val();
    clearTimeout(time_out);
    time_out = setTimeout(function () {
      getTranslatedPhrases(inputText, languageSelected);
    }, 1000);
  });
});

//display similar translated phrases
function getTranslatedPhrases(inputText, languageSelected) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(
        "translatedPhrases"
      ).innerHTML = this.responseText;
    }
  };
  xmlhttp.open(
    "GET",
    "../pages/displayTranslations.php?q=" +
      inputText +
      "&r=" +
      languageSelected,
    true
  );
  xmlhttp.send();
}
