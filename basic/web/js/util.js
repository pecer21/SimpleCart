function ajaxCall(p_type, p_url, p_data, p_success)
{
	$.ajax(
          	 {
                type: p_type,
                url: p_url,
                data: p_data,
                success: p_success,
                error: function (exception) {
                    console.log(exception);
                }
    		}
       	);
}

function getErrorMessageFromResult(result)
{
	var message = "";
	$.each( result.error, function( key, value ) {
		message += value + '\n';
	});
	
	return message;
}