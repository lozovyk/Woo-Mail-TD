<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );

//<!--------------------------->
//<!-----Time filter START----->
//<!--------------------------->

$currentDateTime = new DateTime("now", new DateTimeZone("Europe/Kiev")); //place your time zone, you can find it on ~~ http://php.net/manual/en/timezones.php

if(isWeekend($currentDateTime)){
    _e( "Thank you for being with us!<br> We will ship your order after weekends.", 'woocommerce' ); //Delivery will be after weekends.
}else{
    if (isAfterLunch($currentDateTime)) {
    _e( "Thank you for being with us!<br> We will ship your order tomorrow.", 'woocommerce' ); //Delivery will be TOMORROW.
}else{
    _e( "If delivery<br> Will be today", 'woocommerce' ); //Delivery will be TODAY.
}
}

function isWeekend($currentDateTime) {
    if (isFridayWeekend($currentDateTime)) {
        return true;
    }
    return $currentDateTime->format('N') >= 6;
}
function isAfterLunch($currentDateTime){
    $currentTimeStamp = $currentDateTime->getTimestamp();
    $timeStamp = new DateTime("now", new DateTimeZone("Europe/Kiev")); //place your time zone
    $timeStamp->setTime(13, 0); //change time in format "(Hours, Minets)".
    $timeStamp = $timeStamp->getTimestamp();
    return $timeStamp < $currentTimeStamp;
}
function isFridayWeekend($currentDateTime){
    return $currentDateTime->format('N') == 5 && isAfterLunch($currentDateTime); //if it's time on Friday after lunch, then we use "isWeekend".
}

//<!--------------------------->
//<!------Time filter END------>
//<!--------------------------->

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
// do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
// do_action( 'woocommerce_email_footer', $email );
