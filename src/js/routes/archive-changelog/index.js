import ScrollSpy from "bootstrap/js/dist/scrollspy";

export default () => {
    new ScrollSpy(document.body, {
        target: '.hierarchy-menu',
        offset: 70
    });
};