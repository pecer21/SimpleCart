<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<script id="cart-item-template" type="text/x-custom-template">
	<div id="shopping-cart-item{id}" class="shopping-cart-item">
		<div class="buttons">
	    	<span onclick="onDeleteCartItem({id})" class="delete-btn"></span>
	    </div>
	    <div class="itemname">
	    	<span>{name}</span>
	    </div>
	    <div class="quantity">
	    	<button onclick="onMinusButton({id})" class="plus-btn" type="button" name="button">
	        	<?= Html::img('@web/minus.svg');?>
	      	</button>
	      	<input id="cartitem{id}" type="text" name="name" value="{quantity}">
	      	<button onclick="onPlusButton({id})" class="minus-btn" type="button" name="button">
	      		<?= Html::img('@web/plus.svg');?>
	      	</button>
	    </div>
	</div>
</script>

<script>

	function onDeleteCartItem(cartitemid)
	{
	   	var url = "<?= Url::to(['cart-item/delete-with-id']); ?>?cartitemid=" + cartitemid;	   	
	   	var onSuccess = function (result) {
	
	       	if(result.error)
	       	{
	       		var message = getErrorMessageFromResult(result);
	       		alert(message);
	       	}
	       	else
	       	{
		       	$("#shopping-cart-item" + cartitemid).remove();
		       	if($(".shopping-cart-item").length == 0)
		       	{
	       			$('#cart').append('<p>The cart is empty</p>');
		       	}
	       	}
	    };
	    ajaxCall('DELETE', url, null, onSuccess);
	}

	function onPlusButton(cartitemid)
	{
		$("#cartitem"+cartitemid).val(parseInt($("#cartitem"+cartitemid).val()) + 1);
		updateQuantityWithCartItem(cartitemid);
	}

	function onMinusButton(cartitemid)
	{
		if($("#cartitem"+cartitemid).val() - 1 > 0)
		{
			$("#cartitem"+cartitemid).val($("#cartitem"+cartitemid).val() - 1);
			updateQuantityWithCartItem(cartitemid);
		}
		else
		{
			alert('Quantity must be greater than 0!');
		}
	}

	function updateQuantityWithCartItem(cartitemid)
	{		
		var quantity = $("#cartitem"+cartitemid).val();		
	   	var url = "<?= Url::to(['cart-item/update-quantity-with-id']); ?>?cartitemid=" + cartitemid;	   	
	   	var data = {quantity : quantity};
	   	var onSuccess = function (result) {
	
	       	if(result.item)
	       	{
	           
	        }
	       	else if(result.error)
	       	{
	       		var message = getErrorMessageFromResult(result);
	       		alert(message);
	       	}
	    };
	    ajaxCall('PUT', url, data, onSuccess);
	}

</script>

<script>

	addCartItems();

	function addCartItems()
	{		
	   	var url = "<?= Url::to(['cart/get-cart-items']); ?>";
	   	var onSuccess = function (result) {	   	
	       	if(result)
	       	{
		       	if(result.items && result.items.length > 0)
		       	{
		           	for (var i = 0; i < result.items.length; i++)
		           	{
		               	var name = result.items[i].item.name;
		               	var quantity = result.items[i].quantity;
		               	var id = result.items[i].id;
	
		        		var data = {id : id, name : name, quantity : quantity};
		        		
		        		addCartItem(data);
		           	}
		       	}
		       	else
		       	{
		       		$('#cart').append('<p>The cart is empty</p>');
		       	}
	        }	
	    };
	    ajaxCall('GET', url, null, onSuccess);
	}

	function addCartItem(data)
	{
		$("#cart p").remove();
		
	    var cartitemtemplate = $('#cart-item-template').html();
       	var replacement = {id : data.id, name : data.name, quantity : data.quantity};
		
		var itembody = cartitemtemplate.replace(/{[^{}]+}/g, function(key){
       	    return replacement[key.replace(/[{}]+/g, "")] || "";
       	});
       	
		$('#cart').append(itembody);
	}
    	
</script>