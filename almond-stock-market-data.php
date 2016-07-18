<?php
/*
Plugin Name: [1.1]Almond Stock Market Data
Plugin URI: http://almondwp.com
Description: DEPRECATED API, WORKING THROUGH NEW SYSTEM
Version: 1.1
Author: Gabriel Maldonado
Author URI: http://almondwp.com
License: GPL2
*/

include('views/view-admin.php');

function gma_almond_plugin_custom_styles() {
	wp_enqueue_style('almond-custom-style', plugin_dir_url( __FILE__ ) . 'css/custom.css');
}
add_action('wp_print_styles', 'gma_almond_plugin_custom_styles');

function awp_almondwp_almond_stock_data_custom_script() {

	wp_enqueue_script( 'awp-js', plugin_dir_url( __FILE__ ) . '/js/awp-js.js', array('jquery'), '1.0.0', true );

}
add_action('plugins_loaded', 'awp_almondwp_almond_stock_data_custom_script');

function register_gma_almond_stock_prices_widget(){
	register_widget('gma_almond_stock_prices' );
}
add_action('widgets_init','register_gma_almond_stock_prices_widget');

function show_widget_link_on_activation($widget_links) {
		$widget_links[] = '<a href="widgets.php">Settings</a>';
		$widget_links[] = '<a href="http://gabrielmaldonado.me/wordpress-plugins" target="_blank">More plugins by AlmondWP</a>';
		return $widget_links;
}
add_filter("plugin_action_links_".plugin_basename(__FILE__), 'show_widget_link_on_activation', 10, 5);


class gma_almond_stock_prices extends WP_Widget{
	
	function __construct(){
		parent::__construct(
			'gma_almond_stock_prices_widget',
			__('Almond Stock Market Data', 'text_domain'),
			$this->defaults = array('title' => '', 'ticker' => '', 'ticker2' => '', 'ticker3' => '', 'ticker4' => '', 'ticker5' => '', 'getLinks' => false, 'getGoogleOrYahoo' => false, 'getTradingVolume' => false),
			array('description' => __('Display stock market data in your website'),
			'text_domain')

		);
	}

	function widget($args, $instance){

		function gma_almond_wp_http_api($each_ticker, $title, $instance, $args){

			//$http_req_test_url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20%28%22' . $each_ticker . '%22%29&env=store://datatables.org/alltableswithkeys';
			//$new_http_req_test_url = 'http://finance.google.com/finance/info?client=ig&q=nyse:ko';
			
			$new_http_req_test_url_json_version = 'http://finance.google.com/finance/info?client=ig&q=nyse:' . $each_ticker . '&as_json=True';

			//$get_result = wp_remote_get( $http_req_test_url, $args );
			$new_get_result = wp_remote_get( $new_http_req_test_url_json_version, $args );
			$new_get_result_just_body = wp_remote_retrieve_body($new_get_result );
			//$new_the_json_object = json_decode($get_result_just_body);
			//$new_the_json_object = json_decode($new_get_result_just_body, true);

//			var_dump($new_get_result_just_body);
			echo '<br>' . '====================' . '<br>';
//			echo $new_get_result_just_body; //string
			echo '<br>' . '====================' . '<br>';
//			echo $new_get_result_just_body['t']; //no funcionara porque es una string, no un array

			/* me devuelve un aray donde cada caracter es una string */
			//$the_exploded_string = explode(',', $new_get_result_just_body);
			//$the_merged_array = array_merge($the_exploded_string);
			//var_dump($the_merged_array);
			/* ======= */

			/* approach json decode */
			var_dump($new_get_result_just_body);
			echo '<br>' . '====================' . '<br>';
			$exploded_output = explode('"', $new_get_result_just_body);
			print_r($exploded_output);
			echo '<br>' . '==========' . $each_ticker . '==========' . '<br>';
			echo $exploded_output[7];
			echo $exploded_output[15];
			//echo '<br>' . '========== PG ==========' . '<br>';
			//echo $exploded_output[7];
			//echo $exploded_output[15];



			//echo $new_get_result_just_body[0]->id;

			//$the_exploded_string = explode(',', $new_get_result_just_body);
			//$the_merged_array = array_merge($the_exploded_string);
			//var_dump($new_the_json_object);
			/* ======= */			


			// foreach ($the_merged_array as $key) {
			// 	echo '<br>' . '====================' . '<br>';
			// 	echo $key;
			// 	$the_yet_again_exploded_string = explode(':', $key);
			// 	$the_yet_again_merged_array = array_merge($the_yet_again_exploded_string);
			// 	foreach ($the_yet_again_merged_array as $again_key) {
			// 		echo '<br>' . '====================' . '<br>';
			// 		var_dump($again_key);
			// 		if ($again_key['t'] == 'ko') {
			// 			echo '!!!!!';
			// 		}

			// 	}

			// }
			/* === hasta aqui queda separado en strings === */

//			print_r($the_exploded_string);
			//print_r($the_merged_array);

//			foreach ($the_merged_array as $key) {
					
//					echo $key;

				// if ($key['t'] == 'KO') {
				// 	echo '<br>' . '====================' . '<br>';
				// 	echo $key;
				// } else {
				// 	echo 'no ko found';
				// }
				
//			}


			//$new_the_response = $new_get_result['body'];

			//$the_response = $get_result['body'];
			//$the_regex = preg_match_all('/((.*?))/~', $the_response, $matches);

			//echo 'type: ' . gettype($the_response);
			//print_r($the_response);

			//echo '<br>' . '====================' . '<br>';
			//echo 'type: ' . gettype($new_the_response); //string
			//echo 'type: ' . gettype($new_the_json_object);
			//print_r($new_the_response);
			// var_dump($new_the_json_object);
			// var_dump($new_http_req_test_url);
			//echo '<br>' . '====================' . '<br>';
			//var_dump($new_the_response[0]);
			//http://finance.google.com/finance/info?client=ig&q=nyse:ko


		}

		extract($args);

		$title = $instance['title'];
		$ticker = strtoupper($instance['ticker']);

		$each_ticker = ['ko','pg','vig'];
		foreach ($each_ticker as $ticker) {
			gma_almond_wp_http_api($ticker, $title, $instance, $args);
		}


		echo $args['before_widget'];
		

		echo "
		<div id='almond-table-title'>
			<span>$title</span>
		</div>";
		
		//gma_almond_wp_http_api($ticker, $title, $instance, $args);

		echo $args['after_widget'];


	}

	function form($instance){

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title = $instance['title'];
		$ticker = $instance['ticker'];

		$getLinks = $instance[ 'getLinks' ] ? 'true' : 'false';
		$getGoogleOrYahoo = $instance[ 'getGoogleOrYahoo' ] ? 'true' : 'false';
		$getTradingVolume = $instance[ 'getTradingVolume' ] ? 'true' : 'false';
		
		

		awp_gma_get_view_admin($each_ticker, $title, $instance, $args); // calls views/admin.php

		
	}

	function update($new_instance, $old_instance){

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['ticker'] = ( ! empty( $new_instance['ticker'] ) ) ? strip_tags( $new_instance['ticker'] ) : '';
		$instance[ 'getLinks' ] = ( ! empty( $new_instance['getLinks'] ) ) ? $new_instance['getLinks'] : '';
		$instance[ 'getGoogleOrYahoo' ] = ( ! empty( $new_instance['getGoogleOrYahoo'] ) ) ? $new_instance['getGoogleOrYahoo'] : '';
		$instance[ 'getTradingVolume' ] = ( ! empty( $new_instance['getTradingVolume'] ) ) ? $new_instance['getTradingVolume'] : '';
		return $instance;

	}
}