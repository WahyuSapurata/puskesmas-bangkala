"use strict";
var KTModalAddPayment = function () {
    var t, e, n, o, i, a, r;
    return {
        init: function () {
            t = document.querySelector("#kt_modal_add_payment"), r = new bootstrap.Modal(t), a = t.querySelector("#kt_modal_add_payment_form"), e = a.querySelector("#kt_modal_add_payment_submit"), n = a.querySelector("#kt_modal_add_payment_cancel"), o = t.querySelector("#kt_modal_add_payment_close"), i = FormValidation.formValidation(a, {
                fields: {
                    invoice: {
                        validators: {
                            notEmpty: {
                                message: "Invoice number is required"
                            }
                        }
                    },
                    status: {
                        validators: {
                            notEmpty: {
                                message: "Invoice status is required"
                            }
                        }
                    },
                    amount: {
                        validators: {
                            notEmpty: {
                                message: "Invoice amount is required"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), $(a.querySelector('[name="status"]')).on("change", (function () {
                i.revalidateField("status")
            })), e.addEventListener("click", (function (t) {
                t.preventDefault(), i && i.validate().then((function (t) {
                    console.log("validated!"), "Valid" == t ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, setTimeout((function () {
                        e.removeAttribute("data-kt-indicator"), Swal.fire({
                            text: "Form has been successfully submitted!",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then((function (t) {
                            t.isConfirmed && (r.hide(), e.disabled = !1, a.reset())
                        }))
                    }), 2e3)) : Swal.fire({
                        text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            })), n.addEventListener("click", (function (t) {
                t.preventDefault(), Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then((function (t) {
                    t.value ? (a.reset(), r.hide()) : "cancel" === t.dismiss && Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            })), o.addEventListener("click", (function (t) {
                t.preventDefault(), Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then((function (t) {
                    t.value ? (a.reset(), r.hide()) : "cancel" === t.dismiss && Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalAddPayment.init()
}));
