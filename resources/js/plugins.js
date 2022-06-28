/**
 * Place any helper plugins in here.
 */
window.onload = function () {
    /**
     * Checkbox tree for permission selecting
     */
    let permissionTree = document.querySelector('.permission-tree :checkbox');

    this.addListenerMulti(permissionTree, 'click change', function (e) {
        /**
         * @type {HTMLElement}
         */
        const target = e.target;

        if (target.matches(':checked')) {
            target.siblings('ul')
                .find('input[type="checkbox"]')
                .setAttribute('checked', true)
                .setAttribute('disabled', true);
        } else {
            target.siblings('ul')
                .find('input[type="checkbox"]')
                .removeAttribute('checked')
                .removeAttribute('disabled');
        }
    });

    permissionTree.each(function (e) {
        /**
         * @type {HTMLElement}
         */
        const target = e.target;

        if (target.matches(':checked')) {
            target.siblings('ul')
                .find('input[type="checkbox"]')
                .setAttribute('checked', true)
                .setAttribute('disabled', true);
        }
    });

    /**
     * Disable submit inputs in the given form
     *
     * @param form
     */
    function disableSubmitButtons(form) {
        form.find('input[type="submit"]')
            .setAttribute('disabled', true);
        form.find('button[type="submit"]')
            .setAttribute('disabled', true);
    }

    /**
     * Enable the submit inputs in a given form
     *
     * @param form
     */
    function enableSubmitButtons(form) {
        form.find('input[type="submit"]')
            .removeAttribute('disabled');
        form.find('button[type="submit"]')
            .removeAttribute('disabled');
    }

    /**
     * Disable all submit buttons once clicked
     */
    document.querySelector('form').addEventListener('submit', function () {
        disableSubmitButtons($(this));

        return true;
    });

    /**
     * Add a confirmation to a delete button/form
     */
    document.querySelector('body')
        .addEventListener('submit', function (e) {
            /**
             * @type {HTMLElement}
             */
            const target = e.target;

            if (target.getAttribute('name') !== 'delete-item') {

            }

        });

    document.querySelectorAll('body')
        .addEventListener('form[name="delete-item"]', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure you want to delete this item?',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                cancelButtonText: 'Cancel',
                icon: 'warning'
            }).then((result) => {
                if (result.value) {
                    this.submit()
                } else {
                    enableSubmitButtons($(this));
                }
            });
        })
        .addEventListener('form[name="confirm-item"]', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure you want to do this?',
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                icon: 'warning'
            }).then((result) => {
                if (result.value) {
                    this.submit()
                } else {
                    enableSubmitButtons($(this));
                }
            });
        })
        .addEventListener('a[name="confirm-item"]', function (e) {
            /**
             * Add an 'are you sure' pop-up to any button/link
             */
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure you want to do this?',
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                icon: 'info',
            }).then((result) => {
                result.value && window.location.assign($(this).attr('href'));
            });
        });

    // Remember tab on page load
    $('a[data-bs-toggle="tab"], a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
        let hash = $(e.target).attr('href');
        history.pushState ? history.pushState(null, null, hash) : location.hash = hash;
    });

    let hash = window.location.hash;
    if (hash) {
        $('.nav-link[href="' + hash + '"]').tab('show');
    }

    // Enable tooltips everywhere
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    /**
     * Add one or more listeners to an element.
     *
     * @param  {DOMElement}  element  -  DOM element to add listeners to
     * @param  {string}  eventNames   -  space separated list of event names, e.g. 'click change'
     * @param  {Function}  listener   -  function to attach for each event as a listener
     */
    function addListenerMulti(el, s, fn) {
        s.split(' ').forEach(e => el.addEventListener(e, fn, false));
    }
};
