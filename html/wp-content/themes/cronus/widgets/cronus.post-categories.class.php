<?php

	/**
     *  Post Categories
     *	This widget can be used only for single post template
     */

	if( !class_exists( 'cronus_widget_post_categories' ) ){
		class cronus_widget_post_categories extends WP_Widget
		{
			/**
             *  Widget Constructor
             */

		    function __construct()
		    {
		        parent::__construct( 'cronus_widget_post_categories', esc_html__( 'Post Categories', 'cronus' ) . ' [' . esc_attr( tempo_core::theme( 'Name' ) ) . ']', array(
		            'classname'     => 'tempo_widget_categories',
		            'description'   => esc_html__( 'This widget can be used only for single post template', 'cronus' )
		        ));
		    }

		    /**
             *  Widget Preview
             */

		    function widget( $args, $instance )
		    {
		        global $post;

		        // extract args
		        extract( $args , EXTR_SKIP );

		        $instance = wp_parse_args( (array) $instance, array(
		            'title' => esc_html__( 'Post Categories', 'cronus' )
		        ));

		        if( is_singular( 'post' ) && has_category( ) ){
		            echo $before_widget;

		            if( !empty( $instance[ 'title' ] ) ){
		                echo $before_title;
		                echo apply_filters( 'widget_title', esc_attr( $instance[ 'title' ] ), $instance, $this -> id_base );
		                echo $after_title;
		            }

		            $categories = tempo_post_categories( $post -> ID );

		            echo '<div><ul>';

		            foreach( $categories as $c ){

		                $link = esc_url( get_term_link( absint( $c[ 'term_id' ] ) , 'category' ) );

		                if ( is_wp_error( $link ) )
		                    continue;

		                echo '<li>';
		                echo '<a href="' . esc_url( $link ) . '" rel="category">' . esc_html( $c[ 'name' ] ) . ' <span class="category tempo-category-' . absint( $c[ 'term_id' ] ) . '">' . absint( $c[ 'count' ] ) . '</span></a>';
		                echo '</li>';
		            }

		            echo '</ul></div>';

		            echo $after_widget;
		        }
		    }

		    /**
             *  Widget Update
             */

		    function update( $new_instance, $old_instance )
		    {
		        $instance               = $old_instance;
		        $instance[ 'title' ]    = sanitize_text_field( $new_instance[ 'title' ] );

		        return $instance;
		    }

		    /**
             *  Widget Form ( admin side )
             */

		    function form( $instance )
		    {
		        $instance = wp_parse_args( (array) $instance, array(
		            'title' => null
		        ));

		        echo '<p>';
		        echo '<label for="' . $this -> get_field_id( 'title' ) . '">' . esc_html__( 'Title', 'cronus' );
		        echo '<input type="text" class="widefat" id="' . $this -> get_field_id( 'title' ) . '" name="' . $this -> get_field_name( 'title' ) . '" value="' . esc_attr( sanitize_text_field( $instance[ 'title' ] ) ) . '" />';
		        echo '</label>';
		        echo '</p>';
		    }
		}
	}
?>
