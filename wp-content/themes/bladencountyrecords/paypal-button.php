<span class="featured-price">$<?php echo meta('domestic_price'); ?></span><br>
<form target="paypal" class="shop" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    
<input type="submit" class="button cart" value="Add To Cart" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"> 
<input type="hidden" name="add" value="1"> 
<input type="hidden" name="cmd" value="_cart"> 
<input type="hidden" name="business" value="josephbowden@bladencountyrecords.com"> 
<input type="hidden" name="item_name" value="<?php the_album_artist(get_the_ID())?> :: <?php the_title() ?> (domestic)"> 
<input type="hidden" name="amount" value="<?php echo meta('domestic_price') ?>"> 
<input type="hidden" name="shipping" value="0"> 
<input type="hidden" name="no_shipping" value="0"> 
<input type="hidden" name="no_note" value="1"> 
<input type="hidden" name="currency_code" value="USD"> 
<input type="hidden" name="tax" value="0.00"> 
<input type="hidden" name="lc" value="US"> 
<input type="hidden" name="bn" value="PP-ShopCartBF">
</form><br>
