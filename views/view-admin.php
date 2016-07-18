<?php

function awp_gma_get_view_admin($each_ticker, $title, $instance, $args){



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
				
				</tbody>
			</table>
			<div id='lite-to-pro-version-comment'>
				Need help or support? You need to customize the plugin for your site? You have a suggestion or feedback?</p>
				<p>Check the <a href="http://gabrielmaldonado.me/wp-plugins-documentation/documentation.html" target="_blank">FAQ &amp; Documentation</a>, the <a href="https://www.youtube.com/watch?v=jM-HrDHiNN8" target="_blank">video-tutorial</a> or <a href="http://gabrielmaldonado.me/wordpress-plugins" target="_blank">contact support</a>.</p>
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