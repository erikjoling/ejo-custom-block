// Get functions from global scope
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

import Edit from './edit.js';
import './editor.scss'; //backend styling
import './style.scss'; //frontend styling

registerBlockType(
    'myplugin/intro',
    {
        title: __( 'Intro block', 'myplugin' ),
        description: __( 'Mooie intro', 'myplugin' ),
        category: 'common',
        attributes: {
            intro: {
                type: 'string',
                selector: '.intro'
            }
        },
        edit( props ){
            return ( <Edit {...props}/> );
        },
        save( props ){

            const { attributes: { intro } } = props;

            return (
                <p className="wp-block-paragraph wp-block-paragraph--intro">
                    {intro}
                </p>
            );
        }
    }
)