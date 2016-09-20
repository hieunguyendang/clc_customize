<?php
/**
 * Newsletter Popup page
 *
 * @author Your Inspiration Themes
 * @package YITH Newsletter Popup
 * @version 1.0.0
 */
;?>
<!-- yith-newsletter-popup -->
<?php


$yith_use_woocommerce = yit_is_woocommerce_active()
    && get_option('yith_newsletter_popup_woocommerce_integration') == '1'
    && get_option('yith_newsletter_popup_woocommerce_product_id');

if ( $yith_use_woocommerce ){

    $yith_popup_product_id = get_option('yith_newsletter_popup_woocommerce_product_id') * 1;
    $yith_product = get_product( $yith_popup_product_id );

    $yith_title = $yith_product->post->post_title;
    $yith_image = wp_get_attachment_url( get_post_thumbnail_id($yith_product->id) );
    $yith_content = $yith_product->post->post_content;
    $yith_price = $yith_product->get_price_html();

    //create add to cart button
    $yith_addtocart = '';
    if( $yith_product->product_type == 'simple' ) {
        $yith_addtocart = add_query_arg('add-to-cart', $yith_product->id, home_url());
    } elseif( $yith_product->product_type == 'variation' ) {

        $yith_addtocart = add_query_arg('add-to-cart', $yith_product->id, home_url());
        $yith_addtocart = add_query_arg('variation_id', $yith_popup_product_id, $yith_addtocart);
        $yith_addtocart = add_query_arg('product_id', $yith_product->id, $yith_addtocart);
        $yith_addtocart = add_query_arg('quantity', 1, $yith_addtocart);

        if( !empty( $yith_product->variation_data ) ) {
            foreach( $yith_product->variation_data as $attribute=>$value ) {
                $yith_addtocart = add_query_arg($attribute, $value, $yith_addtocart);
            }
        }
    }

} else {

    $yith_title = get_option('yith_newsletter_popup_title');
    $yith_image = get_option('yith_newsletter_popup_image');
    $yith_content = get_option('yith_newsletter_popup_message');

}?>

<div class="yith-popup-container sns-custom-yith-popup-container">

    <div id="yith-popup-border" class="group <?php if($yith_use_woocommerce): ?> woocommerce<?php endif ?>">
        <h2 id="yith-popup-title"><?php echo $yith_title;?></h2>

        <?php if( $yith_image ): ?>
            <div id="yith-popup-left">
                <figure id="yith-popup-image"><img src="<?php echo $yith_image;?>" alt="<?php echo $yith_title;?>" /></figure>
            </div><!-- yith-popup-left -->
        <?php endif ?><!-- if $yith_image -->

        <div id="yith-popup-right" class="<?php if($yith_use_woocommerce): ?> product<?php endif ?><?php if( !$yith_image ): ?> yith-popup-full<?php endif ?>">
            <p id="yith-popup-message"><?php echo $yith_content;?></p>
            <?php if( $yith_use_woocommerce ): ?>
                <span class="price"><?php echo $yith_price ?></span>
                <a href="<?php echo $yith_addtocart ?>" id="yithhider" class="submit-field newslettersubmit button"><?php echo get_option('yith_newsletter_popup_woocommerce_submit_text') ?></a>
            <?php elseif ( get_option('yith_newsletter_popup_enable_newsletter_form') == true ): ?>
                <form method="<?php echo get_option('yith_newsletter_popup_newsletter_method') ?>" action="<?php echo get_option('yith_newsletter_popup_action') ?>" class="yith-popup-newsletter-form" id="yith-popup-newsletter-form">
                    <fieldset>
                        <?php if(get_option('yith_newsletter_popup_name_label')){?>
                            <ul class="newsletterfields">
                                <li class="newslettertop">
                                    <input type="text" name="<?php echo get_option('yith_newsletter_popup_name_name') ?>" id="<?php echo get_option('yith_newsletter_popup_name_name') ?>" class="name-field text-field" placeholder="<?php echo get_option('yith_newsletter_popup_name_label') ?>" />
                                </li>
                                <li class="newsletterbottom">
                                    <input type="text" name="<?php echo get_option('yith_newsletter_popup_email_name') ?>" id="<?php echo get_option('yith_newsletter_popup_email_name') ?>" class="email-field text-field" placeholder="<?php echo get_option('yith_newsletter_popup_email_label') ?>" />
                                </li>
                            </ul>
                            <input type="submit" value="<?php echo get_option('yith_newsletter_popup_submit_button_label') ?>" class="submit-field newslettersubmit" id="yithhider"/>
                        <?php } else { ?>
                            <input type="text" name="<?php echo get_option('yith_newsletter_popup_email_name') ?>" id="<?php echo get_option('yith_newsletter_popup_email_name') ?>" class="email-field text-field" placeholder="<?php echo get_option('yith_newsletter_popup_email_label') ?>" />
                            <input type="submit" value="<?php echo get_option('yith_newsletter_popup_submit_button_label') ?>" class="submit-field" />
                        <?php };?>
                        <?php $hiddenfields = get_option('yith_newsletter_popup_newsletter_hidden_fields');
                            if ($hiddenfields) :
                            $result = explode('&',$hiddenfields);
                                foreach ($result as $hivalue ) :
                                    $formvalue = explode('=',$hivalue);?>
                                <input type="hidden" id="<?php echo $formvalue[0] ?>" name="<?php echo $formvalue[0] ?>" value="<?php echo $formvalue[1] ?>" />
                                <?php endforeach;
                            endif;?>
                    </fieldset>
                </form>
            <?php endif; ?>
        </div><!-- yith-popup-right -->

        <div class="yith-popup-checkzone">
            <label for="hideforever">
                <input type="checkbox" id="hideforever" name="no-view" class="no-view yith-popup-checkbox"><?php echo get_option('yith_newsletter_popup_hide_text');?>
            </label>
        </div>
    </div><!-- yith-popup-border -->
</div><!-- yith-popup-container -->
<!-- END yith-newsletter-popup -->