<?php

class Wellcrafted_Dom {

    private $dom;

    public function __construct() {
        $this->dom = new DOMDocument( '1.0', 'UTF-8' );
    }

    public function appendChild( $node ) {
        return $this->dom->appendChild( $node );
    }

    public function createElement( $tag, $text_or_attributes = '', $attributes = array() ) {
        if ( is_array( $text_or_attributes ) ) {
            $attributes = $text_or_attributes;
            $text_or_attributes = '';
        }
        
        $element = $this->dom->createElement( $tag, $text_or_attributes );

        if ( is_array( $attributes ) && ! empty( $attributes ) ) {
            foreach ( $attributes as $key => $value ) {
                $element->setAttribute( $key, $value );
            }
        }

        return $element;
    }

    public function __toString() {
        return $this->dom->saveHTML();
    }
}