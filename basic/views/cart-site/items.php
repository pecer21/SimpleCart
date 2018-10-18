<?php
use yii\helpers\Url;
?>
<div id="items" class="row items">
	<div class="title">
		Products
	</div>
</div>

<script id="item-template" type="text/x-custom-template">
	<div class="col-sm-4 item">
  		<p>{name}</p>
  		<div class="row">
  			<input id="item{id}" type="number" value="1"/>
  		</div>
  		<div class="row">
  			<button class="minus-btn" type="button" onclick="hasItemInCart({id})">To Cart</button>
  		</div>
  	</div>
</script>

<script>

	function hasItemInCart(itemid)
	{
	   	var url = "<?= Url::to(['cart/has-item-in-cart']); ?>?itemid=" + itemid;
	   	var onSuccess = function (result) {
	       	if(result.item)
	       	{
	       		updateQuantityWithItem(itemid);
	        }
	       	else
	       	{
	       		addItemToCart(itemid);
	       	}
	    };
	    ajaxCall('GET', url, null, onSuccess);
	}

	function updateQuantityWithItem(itemid)
	{
		var quantity = $("#item"+itemid).val();		
	   	var url = "<?= Url::to(['cart-item/update-quantity-with-item']); ?>?itemid=" + itemid;	   	
	   	var data = {quantity : quantity};
	   	var onSuccess = function (result) {

	       	if(result.item)
	       	{
	       		$("#cartitem"+result.item.id).val(result.item.quantity);
	        }
	       	else if(result.error)
	       	{
	       		var message = getErrorMessageFromResult(result);
	       		alert(message);
	       	}
	    };
	    ajaxCall('PUT', url, data, onSuccess);
	}

	function addItemToCart(itemid)
	{
		var quantity = $("#item"+itemid).val();
	   	var url = "<?= Url::to(['cart/add-item-to-cart']); ?>";
	   	var data = {itemid : itemid, quantity : quantity};
	   	var onSuccess = function (result) {
	       	if(result.item)
	       	{
        		var itemdata = {id : result.item.id, name : result.item.item.name, quantity : quantity};

	       		addCartItem(itemdata);
	        }
	       	else if(result.error)
	       	{
	       		var message = getErrorMessageFromResult(result);
	       		alert(message);
	       	}
	    };
	    ajaxCall('POST', url, data, onSuccess);
	}
</script>

<script>

    var itemtemplate = $('#item-template').html();
   	var url = "<?= Url::to(['item/get-items']); ?>";
   	var onSuccess = function (result) {
       	if(result)
       	{
           	for (var i = 0; i < result.items.length; i++)
           	{
               	var replacement = result.items[i];
               	
               	var itembody = itemtemplate.replace(/{[^{}]+}/g, function(key){
               	    return replacement[key.replace(/[{}]+/g, "")] || "";
               	});
               	
        		$('#items').append(itembody);
           	}
        }	
    };
    ajaxCall('GET', url, null, onSuccess);
    	
</script>