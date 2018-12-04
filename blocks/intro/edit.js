/**
 * Bring in WP Dependencies
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { RichText } = wp.editor;

/**
 * Initiate an Edit component:
 */
export default class Edit extends Component {

    //constructor
    constructor() {
        super(...arguments);

        //bind this class to the setIntro function, so we
        //can use "this" in that function.
        this.setIntro = this.setIntro.bind(this);
    }

    /**
     * Render a simple RichText component
     */
    render(){
        return (
            <RichText
                identifier="content"
                tagName="p"
                className={ 'wp-block-paragraph wp-block-paragraph--intro' }
                value={this.props.attributes.intro}
                onChange={this.setIntro}
                placeholder={ __( 'Start writing or type / to choose a block' ) }
            />
        )
    }

    /**
     * Set the intro value and save it:
     * 
     * @param String value 
     */
    setIntro( value ){
        const { setAttributes } = this.props;
        setAttributes({
            intro: value
        });
    }
}