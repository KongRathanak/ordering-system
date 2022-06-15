require('./vue');

window.tooltipTrigger = () => {
    const ele = $('.tooltip-selector');
    if (ele.length > 0) {
        ele.tooltip();
    }
};

$(function() {
    tooltipTrigger();
});
