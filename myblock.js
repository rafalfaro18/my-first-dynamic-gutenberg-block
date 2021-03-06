var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    withSelect = wp.data.withSelect;

registerBlockType( 'my-first-dynamic-gutenberg-block/latest-post', {
    title: 'Latest Post Custom Block',
    icon: 'megaphone',
    category: 'widgets',

    /*Edit can be rendered using PHP with ServerSideRender.
    See https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks*/
    edit: withSelect( function( select ) {
        return {
            posts: select( 'core' ).getEntityRecords( 'postType', 'post' )
        };
    } )( function( props ) {

        if ( ! props.posts ) {
            return "Loading...";
        }

        if ( props.posts.length === 0 ) {
            return "No posts";
        }
        var className = props.className;
        var post = props.posts[ 0 ];

        return el(
            'a',
            { className: className, href: post.link },
            post.title.rendered
        );
    } ),

    save: function(props) {
        // Rendering in PHP
        return null;
    },
} );