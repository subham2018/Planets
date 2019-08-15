var $s2input = $('#star2_input');
	    $('#star2').starrr({
	      max: 5,
	      rating: $s2input.val(),
	      change: function(e, value){
	        $s2input.val(value).trigger('input');
	      }
	   });