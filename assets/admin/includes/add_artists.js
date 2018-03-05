// JavaScript Validation For Registration Page

$( 'document' ).ready( function () {

   $( "#add-artists" ).validate( {

      errorPlacement: function ( error, element ) {
         $( element ).closest( '.form-group' ).find( '.help-block' ).html( error.html() );
      },
      highlight: function ( element ) {
         $( element ).closest( '.form-group' ).removeClass( 'has-success' ).addClass( 'has-error' );
      },
      unhighlight: function ( element, errorClass, validClass ) {
         $( element ).closest( '.form-group' ).removeClass( 'has-error' );
         $( element ).closest( '.form-group' ).find( '.help-block' ).html( '' );
      },

      submitHandler: submitForm
   } );

   function submitForm() {

      $.ajax( {
         url: 'admin/ajax-add-artist.php',
         type: 'POST',
         data: $( '#add-artists' ).serialize(),
         dataType: 'json'
      } )
         .done( function ( data ) {

            $( '#btn-add' ).html( '<img src="/admin/includes/ajax-loader.gif" /> &nbsp; signing up...' ).prop( 'disabled', true );
            $( 'input[type=text],input[type=email],input[type=password]' ).prop( 'disabled', true );

            setTimeout( function () {

               if ( data.status === 'success' ) {

                  $( '#errorDiv' ).slideDown( 'fast', function () {
                     $( '#errorDiv' ).html( '<div class="alert alert-info">' + data.message + '</div>' );
                     $( "#add-artists" ).trigger( 'reset' );
                     $( 'input[type=text],input[type=email],input[type=password]' ).prop( 'disabled', false );
                     $( '#btn-add' ).html( '<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign Me Up' ).prop( 'disabled', false );
                  } ).delay( 6000 ).slideUp( 'fast' );


               } else {

                  $( '#errorDiv' ).slideDown( 'fast', function () {
                     $( '#errorDiv' ).html( '<div class="alert alert-danger">' + data.message + '</div>' );
                     $( "#add-artists" ).trigger( 'reset' );
                     $( 'input[type=text],input[type=email],input[type=password]' ).prop( 'disabled', false );
                     $( '#btn-add' ).html( '<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign Me Up' ).prop( 'disabled', false );
                  } ).delay( 6000 ).slideUp( 'fast' );
               }

            }, 6000 );

         } )
         .fail( function () {
            $( "#add-artists" ).trigger( 'reset' );
            alert( 'An unknown error occoured, Please try again Later...' );
         } );
   }
} );