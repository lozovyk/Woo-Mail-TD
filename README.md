# Woocommerce email details with time dependent
I added a small change that will allow you to quickly and easily customize the body of the email that the client will receive when you receive the order.

![alt Mail example](https://user-images.githubusercontent.com/20230215/48972916-0e656f00-f03d-11e8-968d-fc95cd1a75d4.jpg)

## Installation

Change the file ```customer-processing-order.php```

```bash
/wp-content/plugins/woocommerce/templates/emails
```


### Changes

```php
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
```
