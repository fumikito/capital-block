/**
 * Add textarea
 */

const {registerBlockType} = wp.blocks;
const inputStyle = {
  width: '100%',
  padding: '10px',
  'box-sizing': 'border-box'
};

registerBlockType('capital-block/textarea', {

  title: 'TextArea',

  icon: 'edit',

  category: 'formatting',

  attributes: {
    string: {
      type: 'string',
      source: 'text',
      selector: 'textarea',
    },
  },

  edit({attributes, setAttributes}) {
    return (
      <textarea style={inputStyle} rows='3' onChange={(event) => setAttributes({string: event.target.value})}>{attributes.string}</textarea>
    );
  },

  save({attributes}) {
    return (
      <textarea style={inputStyle} rows='3'>{attributes.string}</textarea>
    );
  },

});
