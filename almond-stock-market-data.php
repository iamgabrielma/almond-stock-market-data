<?php
/*
Plugin Name: [1.1]Almond Stock Market Data
Plugin URI: http://almondwp.com
Description: Display stock market data in your website using a widget. Clean and simple. Activate it under Appearance > Widgets > Available Widgets or clicking in "Settings" below the plugin name.
Version: 1.1
Author: Gabriel Maldonado
Author URI: http://almondwp.com
License: GPL2
*/

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

// function awp_debug(){
// 	echo '<br>' . '///////////////////////////////////////////' . '<br>';
// }

// /* content filter for [KO], find [KO] in the post content and change it */
// function content_filter_for_ko_functionality($content){
// 	global $post;
// 	global $wpdb;
// 	//print_r($post->post_content);
// 	$to_replace = $post->post_content;
// 	$a = '[KO]';
// 	$ticker = '<span id="new-hover-functionality">coca cola</span>';
// 	if (strrpos($to_replace, $a)) {
		
// 		echo '<strong> DEBUG: </strong> string to be replaced found!';
// 		$content = str_replace($a, $ticker, $content);
// 		awp_debug();
// 		return $content;
		
// 		//return str_replace($to_replace, $a, $ticker);

// 	} else {
// 		echo 'nope';
// 	}
// 	//return 'yay';

// 	//echo 'HELLO';

// }
// add_filter( 'the_content', 'content_filter_for_ko_functionality');
// //add_action( 'wp_head', 'content_filter_for_ko_functionality');

// /* DEVELOPING SHORTCODE FOR SPAN TAGS */
// function gma_almond_stock_prices_shortcode_tags($attr){

// 	switch ($attr) {
// 		case 'test1':
// 			echo 'test 1!!!';
// 			break;
		
// 		default:
// 			echo 'default';
// 			break;
// 	}

// }
// add_shortcode( 's', 'gma_almond_stock_prices_shortcode_tags' );
/* // DEVELOPING SHORTCODE FOR SPAN TAGS */



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
			

			/* yahoo deprecated the api, new way: */
			/*
			http://www.yqlblog.net/blog/2009/06/02/getting-stock-information-with-yql-and-open-data-tables/
			https://github.com/josephdpurcell/YahooFinanceAPI/blob/master/YahooFinanceAPI.php

			*/
				
			//$http_req_test_url = 'http://finance.yahoo.com/webservice/v1/symbols/'.$each_ticker.'/quote?format=json';
			$http_req_test_url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20%28%22' . $each_ticker . '%22%29&env=store://datatables.org/alltableswithkeys';
			$get_result = wp_remote_get( $http_req_test_url, $args );
			$get_result_just_body = wp_remote_retrieve_body($get_result );
			//gettype($get_result_just_body);
			$the_json_object = json_decode($get_result_just_body);

			//print_r($get_result);
			//echo '======================';
			//print_r($get_result['body']);
			//echo '======================';
			//print_r($get_result['response']);
			$the_response = $get_result['body'];
			echo 'type: ' . gettype($the_response);
			echo $the_response;
			//echo '======================';

			
			$the_regex = preg_match_all('/((.*?))/~', $the_response, $matches);	
			//$the_regex_two = preg_match('/((.*?))/', $the_response);
			//print_r($matches);
			foreach ($matches as $key) {
				print_r($key) . '<br>';
			}
			
			//print_r($get_result['http_response']['body']);
			// $feed = fetch_feed($http_req_test_url );
			// print_r($feed);

			// foreach ($feed as $item) {
			// 	var_dump($item);
			// }
			//var_dump($the_json_object);
			//echo gettype($the_json_object);
			//var_dump($http_req_test_url);
			//echo 'type: ' . gettype($get_result);
			//echo 'dump: ' . var_dump($get_result);
			//echo 'type: ' . gettype($get_result_just_body);
			//echo 'dump: ' . var_dump($get_result_just_body);
			//print_r($get_result_just_body);
			//print_r($the_json_object);
			//print_r(json_decode($get_result_just_body));
			//$api_response = json_decode( wp_remote_retrieve_body( $get_result ) );
			//var_dump($api_response);

			// foreach ($get_result as $key) {
			// 	echo $get_result[$key] . '<br>';
			// }
			//print_r($get_result);
			//$feed = simplexml_import_dom($get_result);
			// foreach ($feed['items'] as $item) {
			// 	echo $item;
			// }
			// print_r($get_result);
			// if (in_array('KO', $get_result)) {
			// 	echo 'ko found!';
			// } else {
			// 	echo 'ko not found';
			// }
			
//			https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22YHOO%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=

//http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20%28%22ko%22%29&env=store://datatables.org/alltableswithkeys
			
			// if ($the_json_object->list->meta->count == '0') {
			// 	var_dump($the_json_object);
			// 	echo '<span id="almond-alert">The ticker "'.$each_ticker.'" does not exist or is not supported. Please doble check it in the widget dashboard or leave it blank. If you think it is a mistake please contact support.</span>';

			// } else {
			// 	var_dump($the_json_object);
			// 	$the_decoded_name_json_object = $the_json_object->list->resources[0]->resource->fields->name;
			// 	$the_decoded_symbol_json_object = $the_json_object->list->resources[0]->resource->fields->symbol;
			// 	$the_decoded_price_json_object = $the_json_object->list->resources[0]->resource->fields->price;
			// 	$the_decoded_volume_json_object = $the_json_object->list->resources[0]->resource->fields->volume;

			// 	$the_ticker = $the_decoded_symbol_json_object;
			// 	$the_price = substr($the_decoded_price_json_object, 0, 5) ;

			// 	$theTableThatGeneratesALink = $the_ticker;
			// 	$theNewWindowURL = "http://finance.yahoo.com/q?s=$each_ticker";
			// 	$theTableThatGeneratesTheVolume = '';

			// 	if ($instance['getLinks'] == true) {

			// 		$theTableThatGeneratesALink = 
			// 			"<a href='".$theNewWindowURL."' target='_blank'>".$the_ticker."</a>";
			// 	}
			
			// 	if ($instance[ 'getGoogleOrYahoo' ] == true) {
					
			// 		$theNewWindowURL = "https://www.google.com/finance?q=$each_ticker";	
			// 	}

			// 	if ($instance[ 'getTradingVolume' ] == true) {

			// 		$theTableThatGeneratesTheVolume = "<span id='almond-volume'>Volume: ".$the_decoded_volume_json_object." M.</span>";
			// 	}

			// 	echo "
			// 	<div class='wrap'>
			// 		<div id='almond-table-title'>
			// 			<span id='last-pull-comment'>".$the_decoded_name_json_object."</span>
			// 		</div>
			// 		<table id='almond-table'>
			// 			<tbody>
			// 				<tr>
			// 					<td>".$theTableThatGeneratesALink."
			// 					<td>".$the_price."</td>
			// 				</tr>
			// 			</tbody>
			// 		</table>
			// 		<div>
			// 			".$theTableThatGeneratesTheVolume."
			// 		</div>
			// 	</div>
			// 	";
				
			//}
		}

		extract($args);

		$title = $instance['title'];
		$ticker = strtoupper($instance['ticker']);
		$ticker2 = strtoupper($instance['ticker2']);
		$ticker3 = strtoupper($instance['ticker3']);
		$ticker4 = strtoupper($instance['ticker4']);
		$ticker5 = strtoupper($instance['ticker5']);


		echo $args['before_widget'];
		
		$my_tickers_array = [$ticker, $ticker2, $ticker3, $ticker4, $ticker5];

		echo "
		<div id='almond-table-title'>
			<span>$title</span>
		</div>";
		

		foreach ($my_tickers_array as $each_ticker) {

			if (! empty($each_ticker)) {
				gma_almond_wp_http_api($each_ticker, $title, $instance, $args);
			} else {
				continue;
			}		 	
		}

		echo $args['after_widget'];


	}

	function form($instance){

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title = $instance['title'];
		$ticker = $instance['ticker'];
		$ticker2 = $instance['ticker2'];
		$ticker3 = $instance['ticker3'];
		$ticker4 = $instance['ticker4'];
		$ticker5 = $instance['ticker5'];

		$getLinks = $instance[ 'getLinks' ] ? 'true' : 'false';
		$getGoogleOrYahoo = $instance[ 'getGoogleOrYahoo' ] ? 'true' : 'false';
		$getTradingVolume = $instance[ 'getTradingVolume' ] ? 'true' : 'false';
		
		?>
 		
		<?php
		?>
		
		<div class="wrap">
			<table class="widefat">
				<thead>
				<tr>
					<th>Title:</th>
					<td>
						<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
						</input>
					</td>
				</tr>
				</thead>
			</table>

			<table class="widefat">
				<thead>
					<tr>
						<th>Tickers:</th>
					</tr>
						<p>
						Fill the Tickers below with the tickers of the company you want to show in your website, for instance if you write 'ko' you will get 'Coca-Cola Company (The)' information. </p>
						<p>
						For more information of available companies check the <a href='https://en.wikipedia.org/wiki/List_of_S%26P_500_companies' target="_blank">S&amp;P500</a> or the <a href='https://en.wikipedia.org/wiki/Companies_listed_on_the_New_York_Stock_Exchange_%28A%29' target="_blank">NYSE</a> indexes.
						</p>
				</thead>
				<tbody id="almond-admin-inputs">
					<tr>
						<td>
							<input class="widefat" id="<?php echo $this->get_field_id( 'ticker' ); ?>" name="<?php echo $this->get_field_name('ticker'); ?>" type="text" value="<?php echo esc_attr($ticker); ?>">
						</td>
						
					</tr>
					<tr>
						<td>
							<input class="widefat" id="<?php echo $this->get_field_id( 'ticker2' ); ?>" name="<?php echo $this->get_field_name('ticker2'); ?>" type="text" value="<?php echo esc_attr($ticker2); ?>">
						</td>
						
					</tr>
					<tr>
						<td>
							<input class="widefat" id="<?php echo $this->get_field_id( 'ticker3' ); ?>" name="<?php echo $this->get_field_name('ticker3'); ?>" type="text" value="<?php echo esc_attr($ticker3); ?>">
						</td>
						
					</tr>
					<tr>
						<td>
							<input class="widefat" id="<?php echo $this->get_field_id( 'ticker4' ); ?>" name="<?php echo $this->get_field_name('ticker4'); ?>" type="text" value="<?php echo esc_attr($ticker4); ?>">
						</td>
						
					</tr>
					<tr>
						<td>
							<input class="widefat" id="<?php echo $this->get_field_id( 'ticker5' ); ?>" name="<?php echo $this->get_field_name('ticker5'); ?>" type="text" value="<?php echo esc_attr($ticker5); ?>">
						</td>
						
					</tr>
				</input>
				</tbody>
			</table>
			<div id='lite-to-pro-version-comment'>
				Need help or support? You need to customize the plugin for your site? You have a suggestion or feedback?</p>
				<p>Check the <a href="http://gabrielmaldonado.me/wp-plugins-documentation/documentation.html" target="_blank">FAQ & Documentation</a>, the <a href="https://www.youtube.com/watch?v=jM-HrDHiNN8" target="_blank">video-tutorial</a> or <a href="http://gabrielmaldonado.me/wordpress-plugins" target="_blank">contact support</a>.</p>
			</div>
			<div>
				<table class="widefat">
					<thead>
						<tr>
							<th><p>Configuration:</p></tr></th>
					</thead>
					<tbody>
						<tr>
							<td>
							<p>
							<input class="checkbox" 
							type="checkbox" 
							<?php checked( $instance[ 'getLinks' ], 'on' ); ?>
							id="<?php echo $this->get_field_id( 'getLinks' ); ?>" 
							name="<?php echo $this->get_field_name( 'getLinks' ); ?>">
							Activate links on tickers.
							</input>
							</p>
							<p>
							<input class="checkbox" 
							type="checkbox" 
							<?php checked( $instance[ 'getGoogleOrYahoo' ], 'on' ); ?>
							id="<?php echo $this->get_field_id( 'getGoogleOrYahoo' ); ?>" 
							name="<?php echo $this->get_field_name( 'getGoogleOrYahoo' ); ?>">
							Use Google Finances.
							</input>
							</p>

							<p><input class="checkbox" 
							type="checkbox" 
							<?php checked( $instance[ 'getTradingVolume' ], 'on' ); ?>
							id="<?php echo $this->get_field_id( 'getTradingVolume' ); ?>" 
							name="<?php echo $this->get_field_name( 'getTradingVolume' ); ?>">
							Show Trading Volumes.
							</input>
							</p>

							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}

	function update($new_instance, $old_instance){

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['ticker'] = ( ! empty( $new_instance['ticker'] ) ) ? strip_tags( $new_instance['ticker'] ) : '';
		$instance['ticker2'] = ( ! empty( $new_instance['ticker2'] ) ) ? strip_tags( $new_instance['ticker2'] ) : '';
		$instance['ticker3'] = ( ! empty( $new_instance['ticker3'] ) ) ? strip_tags( $new_instance['ticker3'] ) : '';
		$instance['ticker4'] = ( ! empty( $new_instance['ticker4'] ) ) ? strip_tags( $new_instance['ticker4'] ) : '';
		$instance['ticker5'] = ( ! empty( $new_instance['ticker5'] ) ) ? strip_tags( $new_instance['ticker5'] ) : '';

		$instance[ 'getLinks' ] = ( ! empty( $new_instance['getLinks'] ) ) ? $new_instance['getLinks'] : '';
		$instance[ 'getGoogleOrYahoo' ] = ( ! empty( $new_instance['getGoogleOrYahoo'] ) ) ? $new_instance['getGoogleOrYahoo'] : '';
		$instance[ 'getTradingVolume' ] = ( ! empty( $new_instance['getTradingVolume'] ) ) ? $new_instance['getTradingVolume'] : '';
		return $instance;

	}
}