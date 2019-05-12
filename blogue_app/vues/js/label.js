(function(){
            var inputs = document.querySelectorAll('.input-group input');

            inputs.forEach((input) => {
                input.addEventListener('focusout', (e) => {
                    if (e.target.value === "") {
                        return e.target.classList.remove('has-value');
                    }

                    return e.target.classList.add('has-value');
                });
            });
        })();