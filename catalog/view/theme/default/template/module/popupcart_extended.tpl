<div id="popupcart_extended">   
<div class="head"><?php echo $head; ?> <img onclick="$('#popupcart_extended').popup('hide')" class="close" src="catalog/view/theme/default/image/remove-small.png" /></div>
<?php if ($products || $vouchers) { ?>
	<div class="popupcart_info">
    <table>
	<tr>
	<td class="image"><?php echo $text_foto; ?></td>
	<td class="name"><?php echo $text_name ?></td>
	<?php if ($manufacturer_show) { ?>
	<td class="brand"><?php echo $text_manufacturer; ?></td>
	<?php } ?>
	<td class="quantity"><?php echo $text_quantity; ?></td>
	<td class="price"><?php echo $text_price; ?></td>
	<td></td>
	</tr>
	<tr class="hr"><td colspan="6"></td></tr>
    <?php foreach ($products as $key => $product) { ?>
		<tr class="row_<?php echo $key; ?>_<?php echo $product['id']; ?>">
			<td class="image">
			<?php if ($product['thumb']) { ?>
				<img src="<?php echo $product['thumb']; ?>" onclick="location='<?php echo $product['href']; ?>'" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
			<?php } ?>
			</td>
			<td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
			<div><?php foreach ($product['option'] as $option) { ?>- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br /><?php } ?></div>
			<?php if (!$product['stock']) { ?><?php if ($product['quantity'] >= $product['maximum']) { ?><span style="font-size:10px; color:#f00;"><?php echo $in_stock; ?> <?php echo ($product['maximum'] > 1) ? $left : $left1; ?> <?php echo $just; ?> <?php echo $product['maximum']; ?> <?php echo $pcs; ?></span><?php } ?><?php } ?>
			</td>
			<?php if ($manufacturer_show) { ?>
			<td class="brand"><?php echo $product['manufacturer']; ?></td>
			<?php } ?>
			<td class="quantity q_<?php echo $product['id']; ?>">
			<span onclick="updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '-1', '1', $(this).parent().parent().attr('class'))" class="update minus">&lt;</span>
			<input type="text" name="<?php echo $product['key']; ?>" size="2" value="<?php echo $product['quantity']; ?>" onchange="updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', $(this).val(), '0', $(this).parent().parent().attr('class'))" />
			<?php if (!$product['stock']) { ?>
				<?php if ($product['quantity'] < $product['maximum']) { ?>
					<span onclick="updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '+1', '1', $(this).parent().parent().attr('class'))" class="update plus">&gt;</span>
				<?php } else { ?>
					<span class="update plus" style="opacity:0.5; cursor:default">&gt;</span>
				<?php } ?>
			<?php } else { ?>
				<span onclick="updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '+1', '1', $(this).parent().parent().attr('class'))" class="update plus">&gt;</span>
			<?php } ?>
			</td>
			<td class="price"><?php echo $product['total']; ?></td>
			<td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="removeFromCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>')" /></td>
		</tr>
		<tr class="hr"><td colspan="6"></td></tr>
    <?php } ?>
    </table>
	</div>
    <div class="popupcart_total">
    <table>
		<tr>
			<td class="right"><?php echo $text_total; ?></td>
			<td class="right"><?php echo $total_summ; ?></td>
		</tr>
    </table>
    </div>
	<div class="popupcart_buttons">
	<?php if($button_shopping_show) { ?>
		<input type="button" class="button btn" onclick="$('#popupcart_extended').popup('hide')" value="<?php echo $button_shopping; ?>" />
	<?php } else { ?>
		<a class="continue" onclick="$('#popupcart_extended').popup('hide')"><?php echo $button_shopping; ?></a>
	<?php } ?>
	<?php if ($button_cart_show) { ?><input type="button" class="button" value="<?php echo $button_cart; ?>" onclick="location='<?php echo $cart; ?>'" /><?php } ?>
	<input type="button" class="button btn" value="<?php echo $button_checkout; ?>" onclick="location='<?php echo $checkout; ?>'" />
	</div>
	<?php if($related && isset($products_related)) { ?>
	<div id="related">
	<div class="heading"><?php echo $text_related; ?></div>
	<div class="related_product">
	<?php foreach ($products_related as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
		<div>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
			<div class="cart"><a onclick="addToCart('<?php echo $product['product_id']; ?>', 1, 1);" class="button"><img src="catalog/view/theme/default/image/add_to_cart.png" alt="" /></a></div>
      </div>
	  </div>
	  <?php } ?>
	  </div>
	</div>
	<?php } ?>
<?php } else { ?>
    <div class="empty"><?php echo $text_empty; ?></div>
<?php } ?>
<input type="hidden" name="addtocart_logic" value="<?php echo $addtocart_logic; ?>" />
<input type="hidden" name="click_on_cart" value="<?php echo $click_on_cart; ?>" />
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#popupcart_extended').popup({transition: 'all 0.3s',	scrolllock: true});
	carousel();		
});

function carousel () {
	$('.related_product').owlCarousel({
		responsiveBaseWidth: '.related_product',
		navigation: true,
		slideSpeed: 200,
		paginationSpeed: 300,
		touchDrag: true,
		mouseDrag: false,
		navigationText: ['&lt;', '&gt;'],
		pagination: false,
	});
}
	
function p_array() {
<?php foreach ($products as $product) { ?>
<?php if($product['option']) { ?>
	replace_button('<?php echo $product['id']; ?>', 1);
<?php } else { ?>
	replace_button('<?php echo $product['id']; ?>', 0);
<?php } ?>
<?php } ?>
}

function replace_button(product_id, options){
if(options && $('.'+product_id).attr('id') == 'button-cart') {
	var text = '<?php echo $button_incart_with_options; ?>';
} else {
	var text = '<?php echo $button_incart; ?>';
}
<?php if($button_incart_logic) { ?>
	$('html, body').find('.'+product_id).val(text).text(text).addClass('in_cart');
<?php } else { ?>
if(options) {
	$('html, body').find('.'+product_id).val(text).text(text).addClass('in_cart');
} else {
	$('html, body').find('.'+product_id).attr('onclick', '$(\'#popupcart_extended\').popup(\'show\');').val(text).text(text).addClass('in_cart');
}
<?php } ?>
}

function replace_button_del(product_id, data){
	$('.'+product_id).attr('onclick', 'addToCart(\''+ product_id +'\');').val('<?php echo $button_cart_default; ?>').html(data).removeClass('in_cart');
}
</script>