$.fn.exists = function () {
    if (this === null) {
        return "is null";
    }

    return this.length !== 0;
};

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

});