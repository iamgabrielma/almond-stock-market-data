<?php
//run $wordpress-core phpunit build/wp-content/plugins/almond-stock-market-data/tests/test-sample.php


/*
only methods prefixed with “test” will be considered a unit test. All other methods will be skipped.
*/

/* A TEST IS A COLLECTION OF ASSERTIONS */
class AWP_ASMD_Sample_Test extends WP_UnitTestCase {
 
 	/* AN ASSERTION IS ONE CHECK WITHIN A TEST */
	function test_sample() {
		
		$status = widget();
		//$this->assertTrue( true ); //checks if true = true
		$this->assertEquals('KO', $status);
	}

	// function awp_asmd_are_shortcode_tags_working(){

	// 	global $attr;
	// 	var_dump($attr);
	// 	// if ($each_ticker == 'KO') {
	// 	// 	if ($http_req_test_url == 'http://finance.yahoo.com/webservice/v1/symbols/KO/quote?format=json') {
	// 	// 		$this->assertTrue( true );
	// 	// 	} else {
	// 	// 		echo 'nope';
	// 	// 	}
	// 	// } 

	// }
	// function test_sample_string() {
 
	// 	$string = 'Unit tests are sweet';
 
	// 	$this->assertEquals( 'Unit tests are sweet', $string );
	// }

	// public function test_instances() {
	// 	global $wp_post_types;

	// 	foreach ( $wp_post_types as $post_type ) {
	// 		$this->assertInstanceOf( 'WP_Post_Type', $post_type );
	// 	}

	// }

}
