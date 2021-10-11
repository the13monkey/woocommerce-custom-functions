<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<style>
	.mydel{
		text-decoration-color:darkgray!important; 
		text-decoration-line: line-through!important; 
		text-decoration-thickness: 2px!important; 
		margin-left:10px!important;
	} 
	.mydel > .woocommerce-Price-amount {
		color:darkgray!important; 
		font-weight:500!important;
	}
</style>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="container-fluid container-lg"><!-- replace the <table> element --> 

		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php 
		
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
											
				// BOGO Snippet 
				//$cat_nobogo_id = 353;
				//$cat_ids = $_product->get_category_ids();
				
				/**
				 * Show Brand Name
				 */
				if ( $_product->is_type( 'simple' ) ) {
					$cat_ids = $_product->category_ids;	
					$cat_names = [];
					foreach ( $cat_ids as $cat_id ) {
						$term = get_term_by( 'id', $cat_id, 'product_cat' );
						$cat_name = $term->name; 
						array_push( $cat_names, $cat_name );
					}
				} else {
					$parent_id = $_product->get_parent_id();
					$cat_ids = wc_get_product( $parent_id )->category_ids;
					$cat_names = [];
					foreach ( $cat_ids as $cat_id ) {
						$term = get_term_by( 'id', $cat_id, 'product_cat' );
						$cat_name = $term->name; 
						array_push( $cat_names, $cat_name );
					}
				}
				if ( in_array( 'CBD Daily Products', $cat_names ) ) {
					$show_cat_name = 'CBD Daily Products';
					$brand_color = '#5d7041';
				}	
				
				if ( in_array( 'Hemp Seed Body Care', $cat_names ) ) {
					$show_cat_name = 'Hemp Seed Body Care';
					$brand_color = '#3d8e26';
				}

				if ( in_array( 'Marrakesh Hair Care', $cat_names ) ) {
					$show_cat_name = 'MKS eco';
					$brand_color = '#a51e35';
				}
				
				if ( in_array( 'Emera CBD Hair Care', $cat_names  ) ) {
					$show_cat_name = 'Emera CBD Hair Care';
					$brand_color = '#004c45';
				}
				
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key ); ?>

					<div class="row justify-content-between align-items-start px-3 cart-single-item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<div style="width: 40%; max-width: 300px; text-align: center; ">

							<h6 class="text-center text-light py-2 px-0" style="font-size: 0.75rem; background-color:<?php echo $brand_color; ?>"><?php echo $show_cat_name; ?></h6>
					
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail; // PHPCS: XSS ok.
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							}
							?>
							
							<!-- BOGO Snippet  
							<?php 
								if ( in_array(353, $cat_ids) ) {
									echo "<p style='position:relative; top:0;left:0;background-color:#c00001;color:#fff;font-weight:bold;padding:0.5rem;'>Not Eligible for BOGO</p>";
								} else {
									echo "<p style='position:relative; top:0;left:0;background-color:green;color:#fff;font-weight:bold;padding:0.5rem;'>Buy 1, Get 1 Free</p>";
								}
							?>--> 

						</div>

						<div style="width: 56%;" class="px-3">
					
							<?php 
							
								$product_name = $_product->get_name();

								$product_name_array = explode( "<br>", $product_name );

								$product_name_name = $product_name_array[0];

								$product_name_meta = $product_name_array[1];

								echo '<h6 class="text-uppercase">';

									echo $product_name_name; 

								echo '</h6>';

								echo '<p style="font-size: 0.9rem;">';

									echo $product_name_meta; 

								echo '</p>';
							
							?>
							<!-- Product Unit Price 
							<?php
								$product_category_ids = $_product->get_category_ids();
								if (!in_array(356, $product_category_ids)) {
									echo '<span class="text-dark mr-2 small">Unit Price:</span>';
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								}
							?>-->
							<!-- Product Quantity --> 
							<div class="product-quantity my-3" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
					
								//Bogo Snippet
								/*
								$raw_qty = $cart_item['quantity']; 
								
								if ( in_array(353, $cat_ids) ) {
									
								} elseif ( $raw_qty % 2 == 0 ) {
									
									echo "<p class='bogo-success' style='margin-top:1rem;color:green;font-weight:bold;'>Enjoy BOGO on this item.</p>";
								} else {
									
									echo "<p class='bogo-error' style='margin-top:1rem;color:#c00001;font-weight:bold;'>Add 1 more item to be eligible for BOGO. Mix and match not allowed</p>";
								}*/
									
							?>
							</div>
							<!-- Product Total --> 
							<?php 
					
								$total_discounted_number = if_more_discounted(); 	
								$discounted_products = array('18606', '337', '335', '332', '326', '315', '15789', '15791', '15793', '455', '443', '668', '15716');
								$if_discounted = false;
					
								if ( $cart_item['variation_id'] ) {
									$productID = $cart_item['variation_id'];
								} else {
									$productID = $cart_item['product_id'];
								}		
								if ( in_array( $productID, $discounted_products ) ) {
									$if_discounted = true; 
								}
					
								$discounted_items_array = find_cheapest_cart_item();
				
								if ( $cart_item_key === $discounted_items_array[0]['cart_item_key'] ){
									$cheapest = true; 
									if ( $cart_item['quantity'] < $total_discounted_number ) {
										$loop = true; 
									} else {
										$loop = false; 										
									}
								} else {
									$cheapest = false; 
								}
					
								$qty_in_loop = 0; 
								for ($i=0; $i<count($discounted_items_array); $i++) {
									$qty_in_loop += $discounted_items_array[$i]['cart_item_qty'];
									if ($qty_in_loop >= $total_discounted_number) {
										$stopIndex = $i;
										$remaining_qty = $qty_in_loop - $total_discounted_number;
										break; 
									}
								}
					
							 	if (gettype($total_discounted_number) == 'string') {
									
									//All discounted products print reduced prices 
					
									if ( $if_discounted ) {
										$regular_price = $_product->get_price();
										$reduced_price = $regular_price * 0.5;
										$reduced_subtotal = $reduced_price * $cart_item['quantity'];
										$reduced_subtotal_string = bcdiv($reduced_subtotal, 1, 2);
										echo '<span class="text-dark mr-2 small">Total:</span>';	
										echo '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$reduced_subtotal_string.'</bdi></span>';
										echo '<span class="mydel">'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ).'</span>';

									} else {
										echo '<span class="text-dark mr-2 small">Total:</span>';
										echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									}		
									
								} else {
									
									// $total_discounted_number = integer 
									// Discounted products number > allowed discounted products number
									
									if ( $if_discounted ){
										
										//echo "Cheapest: ".$cheapest; 
										//echo "Loop: ".$loop;
										//echo "StopIndex ".$stopIndex;
										
										if ($loop) {
											for ($x=0; $x < count($discounted_items_array); $x++) {
												if ($cart_item_key === $discounted_items_array[$x]['cart_item_key']) {
													$currentIndex = $x;
													break;
												}
											}
											if ( $currentIndex > $stopIndex ) {
												// Print regular prices 
												echo '<span class="text-dark mr-2 small">Total:</span>';
												echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
											} elseif ( $currentIndex < $stopIndex ) {
												// Print reduced prices for cart quantity 
												$regular_price = $_product->get_price();
												$reduced_price = $regular_price * 0.5;
												$reduced_subtotal = $reduced_price * $cart_item['quantity']; 
												$reduced_subtotal_string = bcdiv($reduced_subtotal, 1, 2);

												echo '<span class="text-dark mr-2 small">Total:</span>';	
												echo '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$reduced_subtotal_string.'</bdi></span>';
												echo '<span class="mydel">'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ).'</span>';
											} elseif ( $currentIndex == $stopIndex ) {
												
												// Special attention 
												if ( $remaining_qty == 0 ) {
													$regular_price = $_product->get_price();
													$reduced_price = $regular_price * 0.5;
													$reduced_subtotal = $reduced_price * $cart_item['quantity']; 
													$reduced_subtotal_string = bcdiv($reduced_subtotal, 1, 2);

													echo '<span class="text-dark mr-2 small">Total:</span>';	
													echo '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$reduced_subtotal_string.'</bdi></span>';
													echo '<span class="mydel">'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ).'</span>';
												} else {
													$regular_price = $_product->get_price();
													$reduced_price = $regular_price * 0.5;
													$reduced_number = $cart_item['quantity'] - $remaining_qty; 
													$reduced_subtotal_raw = $reduced_price * $reduced_number; 
													$regular_priced_subtotal = $regular_price * $remaining_qty;
													$reduced_subtotal = $reduced_subtotal_raw + $regular_priced_subtotal;  
													$reduced_subtotal_string = bcdiv($reduced_subtotal, 1, 2);
													echo '<span class="text-dark mr-2 small">Total:</span>';	
													echo '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$reduced_subtotal_string.'</bdi></span>';
													echo '<span class="mydel">'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ).'</span>';
												}
												
											}
											
										} else {
											if ( $cart_item_key === $discounted_items_array[0]['cart_item_key'] ){
												$regular_price = $_product->get_price();
												$reduced_price = $regular_price * 0.5;
												$reduced_subtotal_raw = $reduced_price * $total_discounted_number; 
												$regular_priced_subtotal = $regular_price * ( $cart_item['quantity'] - $total_discounted_number );
												$reduced_subtotal = $reduced_subtotal_raw + $regular_priced_subtotal;  
												$reduced_subtotal_string = bcdiv($reduced_subtotal, 1, 2);
												echo '<span class="text-dark mr-2 small">Total:</span>';	
												echo '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$reduced_subtotal_string.'</bdi></span>';
												echo '<span class="mydel">'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ).'</span>';
											} else {
												echo '<span class="text-dark mr-2 small">Total:</span>';
												echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
											}
										}		
										
									} else {
										// Not discounted products, print regular prices
										echo '<span class="text-dark mr-2 small">Total:</span>';
										echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									}
								}
					
								
					
								/*Original Price HTML
								echo '<span class="text-dark mr-2 small">Total:</span>';
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); 
								*/
								
							?><!-- end of Product Total -->
							
							<!-- Free Shipping? --> 
							<?php 
								$shipping_class = $_product->get_shipping_class();

								if ( $shipping_class == 'free-shipping' ) {
								  
									echo '<p class="mt-3 pl-0 pr-3 py-1 text-left text-uppercase font-weight-bold" style="font-size:0.85rem;color:#77a464">Free Shipping</p>';
							  
								}
							?>
							<!-- Eligible for Sale? --> 
							<?php 
								if ($product_id == 43593) {
									echo "<p style='color:#c00001!important;font-weight:bold!important;'>Not Eligible for Memorial Day Sale</p>";
								}
							?>
						</div>

						<div style="width: 4%">
							
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>

						</div>

					</div>

					<hr style="height: 0.5px; background-color: #000; border: none;">

			<?php 
				}
			}
		?>

		<?php do_action( 'woocommerce_cart_contents' ); ?>

		<div class="row px-3 my-4 justify-content-center">

			<button type="submit" class="button rounded-0 btn btn-dark px-5 font-weight-normal text-uppercase" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

		</div>

		<?php do_action( 'woocommerce_cart_actions' ); ?>

		<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

		<div class="row p-3 border mx-1 mb-3">

			<h7 class="text-uppercase font-weight-bold mb-3">Coupon Code</h7>

			<?php 

				if ( wc_coupons_enabled() ) { ?>

					<div class="coupon d-flex justify-content-between align-items-center w-100">
						<input type="text" name="coupon_code" class="input-text py-1" style="width:50%;height:52px;border:1px solid #000;padding-left:.5em;" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" style="width:50%;background-color:#fcf7f2;height:52px;" class="button text-uppercase rounded-0" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>

			<?php 
				
				} ?>

		</div>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>

	</div>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals px-3 container-fluid container-lg">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
