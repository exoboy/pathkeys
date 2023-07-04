# pathkeys
Simple getter and setter functions to allow using a single string, dot notation path for accessing multidimensional properties in PHP. E.g. "prop1.prop2.prop3"

```
/**
 * PATHKEYS v1.0
 * 
 * */

/**
 * MULTIDIMENSIONAL ARRAY PROPERTY VALUE GETTER
 *
 * @param	array	$source	the array to search in 
 * @param	string	$path = a string path, separated by ".", "prop1.prop2.prop3"
 * 
 * @return	mixed	$source	returns the value at that location, string/array/integer
 * 
 * */
function get_prop_by_path( $source, $path ) {
	
	// break out path into an array to traverse
	$keys = explode('.', $path);

	// searches only the array elements in our path, does not iterate through ALL properties!
	foreach($keys as $key) {

		// if the next element in our path does not exist, then it is a bad path, return null
		if (!array_key_exists($key, $source)) {
			// not found
			return NULL; 
		}

		// capture the next array element value and keep checking until the end of path
		$source = $source[$key];
	}

	// returns the last value found, not the original array
	return $source;
}

/**
 * MULTIDIMENSIONAL ARRAY PROPERTY VALUE SETTER
 * Uses a string path, separated by "." to locate a matching property and SET its value
 * 
 * @param	array	$source	the array to search in, is passed as a pointer, so we can alter the value of our target property
 * @param	string	$path = a string path, separated by ".", "prop1.prop2.prop3"
 * @return	mixed	$source could be an array, integer, or string. Returns NULL if not matching property was found.
 * 
 * */
function set_prop_by_path( &$source, $path, $value ) {

	// break out path into an array to traverse
	$keys = explode('.', $path);

	// searches only the array elements in our path, does not iterate through ALL properties!
	foreach($keys as $key) {

		// if the next element in our path does not exist, then it is a bad path, return null
		if (!array_key_exists($key, $source)) {
			// not found
			return NULL; 
		}

		// capture the next array element value and keep checking until the end of path
		$source = &$source[$key];
	}

	$source = $value;

	// returns the last value found, not the original array
	return $source;
}

/**
 * 
 * TESTING CODE BELOW!!!!!!!!!!!!!!!!!!
 * 
 * Use some test data to show how the process works.
 * */

 // -------------------------------------
// Example SOURCE array
$array = array(
	'foo' => 'Foo Value',
	'bar' => array(
		'baz' => 'Baz Value',
		'qux1' => array(
			'nestedKey' => 'Nested Value1'
		),
		'qux2' => array(
			'nestedKey' => 'Nested Value2'
		)
		),
	'bing' => array(
			'nestedKey' => 'Nested Value3'
	)
);

echo "--------------------------------------------<br /><br />";
echo "EXAMPLE SOURCE:";
echo "<pre>".print_r( $array, true )."</pre>";
echo "--------------------------------------------<br /><br />";

// -------------------------------------
// GET multidimensional value using path string
$result = get_prop_by_path( $array, "bar.qux2.nestedKey" );

echo "EXAMPLE GET: for path \"bar.qux2.nestedKey\"";
echo "<pre>".print_r( $result, true )."</pre>";
echo "--------------------------------------------<br /><br />";

// -------------------------------------
// SET multidimensional v alue using path string
$result = set_prop_by_path( $array, "bar.qux2.nestedKey", "XXX-23" );

echo "EXAMPLE SET: for path \"bar.qux2.nestedKey\", changing value \"Nested value 2\" to \"XXX-23\"";
echo "<pre>".print_r( $array, true )."</pre>";
echo "--------------------------------------------<br /><br />END";

```
