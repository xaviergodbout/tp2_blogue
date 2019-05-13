(function(){
    var inputs = document.querySelectorAll('.input-group input');

    inputs.forEach((input) => {
        input.addEventListener('focusout', function(event) {
            if (event.target.value == "") {
                return event.target.classList.remove('has-value');
            }

            return event.target.classList.add('has-value');
        });
    });

    inputs.forEach((input) => {
        window.addEventListener('load', function() {
            if (input.value != "") {
                return input.classList.add('has-value');
            }else{
                return input.classList.remove('has-value');
            }
        });
    });
})();