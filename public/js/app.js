

/* =====================================================
   MOBILE MENU
===================================================== */

const mobileMenuButton =
    document.getElementById('mobileMenuButton');

const navMenu =
    document.getElementById('navMenu');


if (mobileMenuButton && navMenu) {

    mobileMenuButton.addEventListener(
        'click',
        function () {

            navMenu.classList.toggle('active');

        }
    );

}


/* =====================================================
   AUTO HIDE ALERTS
===================================================== */

const alerts =
    document.querySelectorAll('.alert');


alerts.forEach(function (alert) {

    setTimeout(function () {

        alert.style.transition =
            'opacity 0.5s ease';

        alert.style.opacity = '0';


        setTimeout(function () {

            alert.remove();

        }, 500);

    }, 5000);

});


/* =====================================================
   DELETE CONFIRMATION
===================================================== */

const deleteForms =
    document.querySelectorAll(
        'form[data-confirm-delete]'
    );


deleteForms.forEach(function (form) {

    form.addEventListener(
        'submit',
        function (event) {

            const confirmed =
                confirm(
                    'Are you sure you want to delete this?'
                );


            if (!confirmed) {

                event.preventDefault();

            }

        }
    );

});


/* =====================================================
   IMAGE PREVIEW
===================================================== */

const imageInputs =
    document.querySelectorAll(
        'input[type="file"][data-preview]'
    );


imageInputs.forEach(function (input) {

    input.addEventListener(
        'change',
        function () {

            const file = this.files[0];

            const previewId =
                this.dataset.preview;

            const preview =
                document.getElementById(previewId);


            if (!file || !preview) {
                return;
            }


            if (!file.type.startsWith('image/')) {

                preview.style.display = 'none';

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    preview.src =
                        event.target.result;

                    preview.style.display =
                        'block';

                };


            reader.readAsDataURL(file);

        }
    );

});


/* =====================================================
   CHARACTER COUNTER
===================================================== */

const textareas =
    document.querySelectorAll(
        'textarea[data-maxlength]'
    );


textareas.forEach(function (textarea) {

    const maxLength =
        Number(
            textarea.dataset.maxlength
        );

    const counter =
        document.getElementById(
            textarea.dataset.counter
        );


    function updateCounter() {

        if (!counter) {
            return;
        }


        const currentLength =
            textarea.value.length;


        counter.textContent =
            `${currentLength} / ${maxLength}`;

    }


    textarea.addEventListener(
        'input',
        updateCounter
    );


    updateCounter();

});