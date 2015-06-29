@section('pageCSS')
<style>	
	#dialog-form { font-size:75%; }
	#dialog-form label, input { display:block; }
	#dialog-form input.text { margin-bottom:12px; width:95%; padding: .4em; }
	#dialog-form fieldset { padding:0; border:0; margin-top:5px; }
	#dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; }
	.ui-dialog .ui-dialog-titlebar, .ui-dialog .ui-dialog-buttonpane { font-size: 75%; }
</style>
@stop
@section('pageJS')
<script>

function addToLightbox(event, lightbox_id)
{
	event.preventDefault();
	//JQuery code...
	$.get("lightbox/add/1/"+lightbox_id,
	{
	},
	function(data, status){
		alert(data['message']);
	});			
	
	$( "#dialog-form" ).dialog( "close" );
	
}

$(function() {
	var dialog, form,
		tag = $( "#tag" ),
		allFields = $( [] ).add( tag ),
		tips = $( ".validateTips" );

	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}

	function addTag() {
		var valid = true;
		allFields.removeClass( "ui-state-error" );

		valid = valid && checkLength( tag, "tag", 3, 16 );

		//valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

		if ( valid ) {

			//JQuery code...
			$.post("lightbox/add/1",
			{
				name: tag.val()
			},
			function(data, status){
				alert(data['message']);
			});			
			
			dialog.dialog( "close" );
		}
		return valid;
	}

	dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		//height: 300,
		width: 250,
		modal: true,
		buttons: {
			"Add to your Lightbox": addTag,
			Cancel: function() {
				dialog.dialog( "close" );
			}
		},
		close: function() {
			form[ 0 ].reset();
			allFields.removeClass( "ui-state-error" );
		}
	});

	form = dialog.find( "form" ).on( "submit", function( event ) {
		event.preventDefault();
		addTag();
	});

	$( "#add-tag" ).button().on( "click", function() {
		
		$.get("/lightbox/show-lightbox-names/",{},
		function(data, status){
			$('#div-show-lightbox-name').html(data['html']);
			dialog.dialog( "open" );
		});														
	});
	
});
</script>
@stop

@section('content')
@if (Auth::user()->check())
	<button role="button" id="add-tag"><span class="ui-button-text">Add to Lightbox</span></button><br />
@else
	<p>No profile yet.</p>
@endif


<div id="lightbox-dialog" role="dialog" tabindex="-1" style="position: absolute; display: none;">    
    <div id="dialog-form">
	<p class="validateTips">Add to your Lightbox.</p>
    <div id="div-show-lightbox-name" style="display: inline-block; width:225px">
        	
    </div>
	<form>
		<fieldset>
			<label for="tag">Name</label>
			<input name="tag" id="tag" value="" class="text ui-widget-content ui-corner-all" type="text">

			<!-- Allow form submission with keyboard without duplicating the dialog button -->
			<input tabindex="-1" style="position:absolute; top:-1000px" type="submit">
		</fieldset>
	</form>
	</div>
</div>
@stop