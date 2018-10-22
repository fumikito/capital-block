/**
 * Alert Richtext
 *
 * @package capital-block
 */

const { registerBlockType } = wp.blocks;
const { RichText }          = wp.editor;

registerBlockType( 'capital-block/richtext', {

  title: 'RichText',

  icon: 'edit',

  category: 'formatting',

  attributes: {
    content: {
      type: 'array',
      source: 'children',
      selector: 'div',
    }
  },

  edit({attributes, setAttributes}) {

    return (
      <RichText
        tagName="div"
        onChange={ (content) => setAttributes({content: content}) }
        value={attributes.content}
      />
    );
  },

  save({attributes}) {
    return (
        <RichText.Content
          tagName={'div'}
          value={attributes.content}/>
    );
  },

} );
