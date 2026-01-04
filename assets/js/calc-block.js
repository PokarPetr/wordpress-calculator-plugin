const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;
const ServerSideRender = wp.serverSideRender;

registerBlockType('calculator/block', {
    title: 'Calculator',
    icon: 'calculator',
    category: 'design',

    edit(props) {
        return createElement(
            ServerSideRender,
            {
              block: 'calculator/block',
              attributes: props.attributes,
            }
        );
    },

    save() {
        return null;
    },
});


