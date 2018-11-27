/**
 * BLOCK: Testblock
 *
 * Test...
 */

// Import CSS.
import './style.scss';

// Import external dependencies.
import classnames from 'classnames';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { 
    RichText,
    InspectorControls,
} = wp.editor;
const { Fragment } = wp.element;
const {
    PanelBody,
    PanelRow,
    FormToggle,
} = wp.components;


/**
 * Register: Testblock.
 */
registerBlockType( 'ejo/testblock', {
    title: __( 'EJO Testblock', 'ejo' ),
    description: __( 'Create a testblock', 'ejo' ),
    category: 'common',
    icon: 'format-status',
    supports: { 
        html: false,
        alignWide: false,
    },
    attributes: {
        title: {
            type: 'array',
            source: 'children',
            selector: '.title'
        },
        content: {
            type: 'string',
            source: 'html',
            selector: '.content'
        },
        list: {
            type: 'array',
            source: 'children',
            selector: '.list',
        },
        reversed: {
            type: 'boolean',
            default: false,
        },
    },
    edit: ( props ) => {
        const {
            className,
            attributes: {
                title,
                content,
                list,
                reversed
            },
            setAttributes,
        } = props;

        const classes = classnames( className, {
            'test--reversed' : reversed,
        } );

        const onChangeTitle = (value) => {
            setAttributes( { title: value } );
        };

        const onChangeContent = (value) => {
            setAttributes( { content: value } );
        };

        const onChangeList = ( value ) => {
            setAttributes( { list: value } );
        };

        const toggleReversed = () => {
            setAttributes( { reversed: ! reversed } );
        };

        return (
            <Fragment>
                <div className= { classes }>
                    <RichText   
                        tagName="h2"
                        className="title"
                        placeholder={ __('Write in your testblock', 'ejo') }
                        value={ title }
                        onChange= { onChangeTitle }
                    />
                    <RichText   
                        tagName="div"
                        multiline="p"
                        className="content"
                        placeholder={ __('Write in your testblock', 'ejo') }
                        value={ content }
                        onChange= { onChangeContent }
                    />
                    <RichText
                        tagName="ul"
                        multiline="li"
                        className="list"
                        placeholder={ __( 'Write a list', 'ejo' ) }
                        value={ list }
                        onChange={ onChangeList }
                    />
                </div>
                <InspectorControls>
                    <PanelBody>
                        <PanelRow>
                            <label
                                htmlFor="reversed-form-toggle"
                                className="blocks-base-control__label"
                            >
                                { __( 'Reverse Layout' ) }
                            </label>
                            <FormToggle
                                id="reversed-form-toggle"
                                label={ __( 'Reverse Layout' ) }
                                checked={ !! reversed }
                                onChange={ toggleReversed }
                            />
                        </PanelRow>
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );

    },
    save: ( props ) => {
        const {
            className,
            attributes: {
                content,
                list,
                title,
                reversed,
            }
        } = props;

        const classes = classnames( className, {
            'test--reversed' : reversed,
        } );

        return ( 
            <div className={ classes }>
                <RichText.Content
                    tagName="h2"
                    className="title"
                    value={ title }
                />
                <RichText.Content 
                    tagName="div" 
                    className="content"
                    value={ content } 
                />
                <RichText.Content
                    tagName="ul"
                    multiline="li"
                    className="list"
                    value={ list }
                />
            </div>
        );
    }
} );