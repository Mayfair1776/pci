<?


// Number of lines in the File
function countLines ($rows) {

        $numoflines = sizeof($rows);
        echo "There are $numoflines lines in the file.<br><br>\n";
}
/////////////////////////////////////////////////////
// Count each instance of a word
/////////////////////////////////////////////////////
function countWords ($rows) {

        // create a long string with join
        $string = join('',$rows);
        $words = preg_split('/\s+|[\.|\,|\?|\!]/', $string);;
        //$string = preg_replace('/[?|.|!|;|,]?/', '', $string);
        $words = array_map('strtolower', $words);

        // Create a hash with the count value of each word set to zero
        $dict = array_combine($words, array_fill(0, count($words), 0));
        unset($dict['']);

        foreach($words as $word) {
                $dict[$word]++;
        }

        arsort($dict);
        array_shift($dict);
        $unique = sizeof($dict);
        $top_five = array_slice($dict,0,5);

        $m = 1;
        echo "<h3>The top five words are:</h3>\n";
        foreach($top_five as $word => $count) {
                echo "$m) $word => $count <br>\n";
                $m++;
        }
echo "<br><strong>There are ". $unique." unique words:</strong><br>\n";
        foreach($dict as $word => $count) {
                if ($count > 1) {
                        echo "There are $count instances of $word.<br>\n";
                } else {
                                        echo "There is $count instance of $word.<br>\n";
                }
        }
}
/////////////////////////////////////////////////////
// Count the number of letters
/////////////////////////////////////////////////////
function countLetters ($rows) {

        // create a long string with join
        $string = join('',$rows);
        $string = preg_replace('/\s+|[?|.|!|;|,|\'|\"]?/', '', $string);
        //$words = preg_split('/\s+|[\.|\,|\?|\!|\'|\"]/', $string);;
        $letters = preg_split('//', $string);;
        $letters = array_map('strtolower', $letters);

        // Create a hash with the count value of each word set to zero
        $dict = array_combine($letters, array_fill(0, count($letters), 0));
        unset($dict['']);

        foreach($letters as $alpha) {
                $dict[$alpha]++;
        }

        arsort($dict);
        array_shift($dict);
        $top_five = array_slice($dict,0,5);

        $m = 1;
        echo "<h3>The top five letters are:</h3>\n";
        foreach($top_five as $abc => $count) {
                echo "$m) $abc => $count <br>\n";
                $m++;
        }
print "<hr>";
        foreach($dict as $abc => $count) {
                if ( ctype_alpha($abc)) {
                  if ($count > 1) {
                        echo "There are $count instances of $abc.<br>\n";
                  } else {
                        echo "There is $count instance of $abc.<br>\n";
                  }
                }
        }
}
//////////////////// MAIN //////////////////////////////////////

$url = $_POST['url'];
?>
<html>
 <head>
        <title> Results </title>
                <link rel="stylesheet" href="pci.css">
 </head>
  <body>
   <main>
<?

if (filter_var($url, FILTER_VALIDATE_URL) === false) {
  echo "<div class='error'>$url is not a valid URL.Exiting.</div>";
  exit;
}

echo "<span class='m'>Fetching contents from URL: " . $url."</span>" ;
$html_file = file_get_contents($url);
//$html_file = file_get_contents('testfile.txt');

if ($html_file === false) {
        if (isset($http_response_header)){
                echo "header: $http_response_header<br>\n";
        }
        echo "<div class='error'>Could not open url!</div>";
} else {
        // Parsing the text file into an array
        $rows = explode("\n", $html_file);
        // Removing empty rows
        $rows = array_values(array_filter($rows, fn($value) => !empty($value) && !is_null($value)  && $value !== '' && strlen(trim($value)) > 0));

        echo "<hr><h2>Line Count</h2>\n";
        countLines($rows);
        echo "<hr><h2>Word Count</h2>\n";
        countWords($rows);
        echo "<hr><h2>Letter Count</h2>\n";
        countLetters($rows);
?>
    </main>
  </body>
</html>
<?

}

?>
                
