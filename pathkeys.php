<?php
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
 * @param	mixed	$value = what you want to write to this property
 * @param	boolean	$push = true to push value into array (if an indexed or associative array), false = replace entire property value with new value
 * 
 * @return	boolean	this function uses a pointer to the array, so no result is required to be returned, but true is for success, false/null is for issues
 * 
 * */
function set_prop_by_path( &$source, $path, $value, $append = false ) {

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

	if( is_array( $source ) ) {

		switch (true) {

			case $append == "append" || $append == "push":
				array_push( $source, $value );
				break;

				case $append == "prepend" || $append == "unshift":
				array_unshift( $source, $value );
				break;

			default:
				array_push( $source, $value );
		}

	} else {
		$source = $value;
	}

	// returns the last value found, not the original array
	return true;
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
			'nestedKey' => 'Nested Value3',
			'test_array' => array( "A","B","C" )
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
// SET multidimensional value using path string
$result = set_prop_by_path( $array, "bar.qux2.nestedKey", "XXX-23" );

echo "EXAMPLE SET: for path \"bar.qux2.nestedKey\", changing value \"Nested value 2\" to \"XXX-23\"";
echo "<pre>".print_r( $array, true )."</pre>";
echo "--------------------------------------------<br /><br />END";

// -------------------------------------
// PUSH multidimensional value using path string
// append = add new value to bottom of array, prepend = add to the top of array
$result = set_prop_by_path( $array, "bing.test_array", "D", "append" );

echo "EXAMPLE SET: for path \"bing.test_array\", pushing value \"D\" into indexed array.";
echo "<pre>".print_r( $array, true )."</pre>";
echo "--------------------------------------------<br /><br />END";

?>
