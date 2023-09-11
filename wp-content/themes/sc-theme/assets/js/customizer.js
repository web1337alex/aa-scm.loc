jQuery(document).ready(function($) {
    let colors = customizerData.colors;

    console.log(colors);

    let styleTag = $('<style id="custom-color-styles"></style>').appendTo('head');
    let styleContent = ':root {';

    colors.forEach(function (color) {
        let colorName = color['key'];

        wp.customize(colorName, function (value) {
            value.bind(function (newVal) {
                if (newVal !== undefined && newVal !== null) {
                    styleContent += '--' + colorName + ': ' + newVal + ';';
                    styleTag.html(styleContent + '}');
                }
            });
        });
    });
});