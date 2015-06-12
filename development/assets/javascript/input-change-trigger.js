/**
 * Change value of another input on current on '.wellcrafted_input_change_trigger' change
 * '.wellcrafted_input_change_trigger' can have data-attributes:
 * - data-target: selector of inputs to change
 * - data-change-on-empty: should empty value be used; dfeault is true
 */
$( '.wellcrafted_input_change_trigger' ).change( function() {
    var value = $( this ).val(),
        target_selector = $( this ).data( 'target' ),
        target = $( target_selector ),
        change_on_empty = $( this ).data( 'change-on-empty' );

    if ( ! target.length ) {
        return true;
    }

    if ( undefined === change_on_empty ) {
        change_on_empty = true;
    }

    if ( value || ( ! value && change_on_empty ) ) {
        target.val( value );
    }
});

$( '.wellcrafted_input_change_trigger' ).change();