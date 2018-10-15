/**
 * Event box
 */

const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.components;

registerBlockType( 'capital-block/event', {

  title: 'Event',

  icon: 'calendar-alt',

  category: 'embed',

  attributes: {
    year: {
      type: 'integer',
    },
    month: {
      type: 'integer',
    },
  },

  edit( {attributes, setAttributes} ) {

    const years = [];
    for(let i = 0; i < 20; i++){
      years.push( 2016 + i );
    }
    const months = [];
    for(let i = 1; i <= 12; i++){
      months.push(i);
    }

    return (
      <div className='event-editor'>
        <select onChange={ (event) => { setAttributes({year: event.target.value}) } }>
          {years.map( (year) => {
            return (
              <option value={year} selected={year == attributes.year}>{year}年</option>
            )
          } )}
        </select>
        <select onChange={ (event) => { setAttributes({month: event.target.value}) } }>
          {months.map( (month) => {
            return (
              <option value={month} selected={month == attributes.month}>{month}月</option>
            )
          } )}
        </select>
        <hr/>
        <ServerSideRender
          block="capital-block/event"
          attributes={ attributes }
        />
      </div>


    );

  },

  save(){
    return null;
  }

} );
