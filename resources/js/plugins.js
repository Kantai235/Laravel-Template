import i18next from "i18next";

/**
 * Translate text via i18next
 * 
 * @param {string} text 
 * @returns translated string
 */
function __(text) {
    return i18next.t(text);
}

/**
 * Place any helper plugins in here.
 */
window.onload = function () {
    /**
     * Checkbox tree for permission selecting
     */
    let permissionTree = document.querySelectorAll('.permission-tree input[type=checkbox]');

    permissionTree.forEach(function (perm) {
        addListenerMulti(perm, "click change", function (e) {
            const target = e.target;
            if (target.checked) {
                target.parentElement.querySelectorAll("input[type=checkbox]").forEach(function (el) {
                    if (el === target) {
                        return true;
                    }
                    el.setAttribute("disabled", true);
                    el.checked = true;
                });
            } else {
                target.parentElement.querySelectorAll("input[type=checkbox]").forEach(function (el) {
                    el.removeAttribute("disabled");
                    el.checked = false;
                });
            }
        })


    });

    permissionTree.forEach(function (perm) {
        if (perm.checked) {
            perm.parentElement.querySelectorAll("input[type=checkbox]").forEach(function (el) {
                if (el === perm) {
                    return true;
                }
                el.setAttribute("disabled", true);
                el.checked = true;
            });
        }
    })

    /**
     * Disable submit inputs in the given form
     *
     * @param form
     */
    function disableSubmitButtons(form) {
        form.querySelectorAll('input[type="submit"]').forEach(function (el) { el.setAttribute("disabled", true); });
        form.querySelectorAll('button[type="submit"]').forEach(function (el) { el.setAttribute("disabled", true); });
    }

    /**
     * Enable the submit inputs in a given form
     *
     * @param form
     */
    function enableSubmitButtons(form) {
        form.querySelectorAll('input[type="submit"]').forEach(function (el) { el.removeAttribute("disabled"); });
        form.querySelectorAll('button[type="submit"]').forEach(function (el) { el.removeAttribute("disabled"); });
    }

    /**
     * Disable all submit buttons once clicked
     */
    document.querySelectorAll("form")
        .forEach(function (el) {
            el.addEventListener("submit", function () {
                disableSubmitButtons(this);
                return true;
            });
        });

    document.querySelectorAll("body")
        .forEach(function (body) {
            body.querySelectorAll('form[name="delete-item"] *').forEach(function (el) {
                el.addEventListener('click', deleteConfirmHandler());
            })
            body.querySelectorAll('form[name="confirm-item"] *').forEach(function (el) {
                el.addEventListener('click', submitConfirmHandler());
            })
            body.querySelectorAll('a[name="confirm-item]').forEach(function (el) {
                el.addEventListener('click', redirectToUrlHandler());
            })
        });

    // Remember tab on page load
    document.querySelectorAll('a[data-bs-toggle="tab"], a[data-bs-toggle="pill"]')
        .forEach(function (el) {
            el.addEventListener("shown.bs.tab", function (e) {
                let hash = e.target.setAttribute("href");
                history.pushState
                    ? history.pushState(null, null, hash)
                    : (location.hash = hash);
            });
        });


    // TODO: bootstrap related, needs to rewrite after jQuery is completely removed.
    let hash = window.location.hash;
    if (hash) {
        $('.nav-link[href="' + hash + '"]').tab("show");
    }

    // Enable tooltips everywhere
    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    /**
     * Add one or more listeners to an element.
     *
     * @param  {DOMElement}  element  -  DOM element to add listeners to
     * @param  {string}  eventNames   -  space separated list of event names, e.g. 'click change'
     * @param  {Function}  listener   -  function to attach for each event as a listener
     */
    function addListenerMulti(el, s, fn) {
        s.split(" ").forEach((e) => el.addEventListener(e, fn, false));
    }

    function deleteConfirmHandler() {
        return actionConfirmHandler(__("Are you sure you want to delete this item?"), __("Confirm Delete"), __("Cancel"), "warning");
    }

    function submitConfirmHandler() {
        return actionConfirmHandler(__("Are you sure you want to do this?"), __("Confirm"), __("Cancel"), "warning");
    }

    function redirectToUrlHandler() {
        return actionConfirmHandler(__("Are you sure you want to do this?"), __("Confirm"), __("Cancel"), "info");
    }

    function actionConfirmHandler(title, confirmButtonText, cancelButtonText, icon) {
        let isDone = false;
        return function (e) {
            const showCancelButton = true;
            if (isDone === true) {
                isDone === false;
                return;
            }
            e.preventDefault();
            Swal.fire({
                title, showCancelButton, confirmButtonText, cancelButtonText, icon
            }).then((result) => {
                if (result.value) {
                    isDone = true;
                    this.dispatchEvent(new e.constructor(e.type, e));
                } else {
                    enableSubmitButtons(e.target);
                }
            });
        }
    }
};

