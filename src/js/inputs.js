/**
 * Add input
 */

const {registerBlockType} = wp.blocks;
const inputStyle = {
  width: '100%',
};

registerBlockType('capital-block/input', {

  title: 'Input',

  icon: 'edit',

  category: 'formatting',

  attributes: {
    string: {
      type: 'string',
      source: 'attribute',
      selector: 'input',
      attribute: 'value'
    },
  },

  edit({attributes, setAttributes}) {
    return (
      <input type='text' value={attributes.string} style={inputStyle}
             onChange={(event) => setAttributes({string: event.target.value})}/>
    );
  },

  save({attributes}) {
    return (
      <input type='text' value={attributes.string} />
    );
  },

});
