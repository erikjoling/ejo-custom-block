/**
 * Block dependencies
 */
import './style.scss';

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Spinner } = wp.components;
const { withSelect } = wp.data;

registerBlockType(
    'ejo/subpages',
    {
        title: __( 'Subpages', 'ejo'),
        description: __( 'List all the subpages.', 'ejo'),
        icon: 'list-view',         
        category: 'widgets',
        edit: withSelect( ( select ) => {
        		const { getCurrentPostId } = select( 'core/editor' );
                const { getEntityRecords } = select( 'core' );

                return {
                    posts: getEntityRecords( 'postType', 'page', { 
                    	per_page: -1,
						parent: getCurrentPostId(),
						orderby: 'menu_order',
						order: 'asc',
                    } )
                };
            } )( ( { posts, className } ) => {
                
                if ( ! posts ) {
                    return (
                        <p className={className} >
                            <Spinner />
                            { __( 'Loading Subpages', 'ejo' ) }
                        </p>
                    );
                }
                if ( 0 === posts.length ) {
                    return <p>{ __( 'No Subpages', 'ejo' ) }</p>;
                }

                return (
                    <div className={ className }> 
                        <ul>
                            { posts.map( post => {
                                
                                // let editorPostLink = "javascript:void(0)";
                                // let editorPostLinkTarget = "_self";
                                let editorPostLink = "/wp-admin/post.php?post=" + post.id + "&action=edit";
                                let editorPostLinkTarget = "_blank";

                                return (
                                    <li>
                                        <a href={ editorPostLink } target={ editorPostLinkTarget }>
                                            { post.title.rendered }
                                        </a>
                                    </li>
                                );
                            }) }
                        </ul>
                    </div>
                );
            } ) 
        ,
        save() {
            // Rendering in PHP
            return null;
        },
	} 
);