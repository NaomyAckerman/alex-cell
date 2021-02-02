$(function () {
    //! Info Konter
    konter();
    //! Create Konter
    $(".tambah-konter").click(function (e) {
        e.preventDefault();
        tambah_konter($(this));
    });
    //* Info Produk
    produk();
    //* Create Produk
    $(".tambah-produk").click(function (e) {
        e.preventDefault();
        tambah_produk($(this));
    });
    //* Alert Login
    let login_msg = $(".login_msg").data();
    if (login_msg) {
        alert_msg(login_msg.judul, login_msg.message, login_msg.type);
    }
});
//* Alert Message
const alert_msg = (title, message, icon = "success") => {
    Swal.fire({
        title,
        html: message,
        icon,
        confirmButtonColor: "#5b6be8",
    });
};
//* Alert confirm
const alert_confirm = (title, message, callback, icon = "warning") => {
    Swal.fire({
        title,
        icon,
        html: message,
        showCancelButton: true,
        confirmButtonColor: "#5b6be8",
        cancelButtonColor: "#d33",
        confirmButtonText: `Yakin ${title}!`,
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
};
//* Upload Produk gambar
const gambarproduk = () => {
    let produkimgfile = $("input[type=file]#produk-gambar");
    let produkimg = $(".produk-img");
    let produkimgicon = $(".produk-img-icon");
    let produkimgtext = $(".produk-img-text");

    produkimgfile.change(function () {
        const file = $(this).prop("files")[0];
        if (file) {
            produkimgtext.text(file.name);
            const reader = new FileReader();
            produkimgicon.addClass("d-none");
            produkimg.removeClass("d-none");
            reader.onload = function () {
                produkimg.attr("src", reader.result);
            };
            reader.readAsDataURL(file);
        } else {
            produkimgtext.text("Pilih gambar produk");
            produkimg.attr("src", "");
            produkimgicon.toggleClass("d-none");
            produkimg.toggleClass("d-none");
        }
    });
};
//* info Produk
const produk = () => {
    const viewProduk = $("#content-view-produk");
    if (viewProduk) {
        $.ajax({
            url: viewProduk.data("url"),
        })
            .done((res) => {
                viewProduk.html(res.data);
                $("#datatable").DataTable({
                    responsive: true,
                    autoWidth: false,
                });
                $(".image-popup-no-margins").magnificPopup({
                    type: "image",
                    closeOnContentClick: true,
                    closeBtnInside: false,
                    fixedContentPos: true,
                    mainClass: "mfp-no-margins mfp-with-zoom",
                    image: {
                        verticalFit: true,
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                    },
                });
                edit_produk();
                delete_produk();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
            });
    }
};
//* Modal Tambah Produk
const tambah_produk = (e) => {
    $.ajax({
        url: e.attr("href"),
    })
        .done((res) => {
            $("#modal-produk").html(res.data);
            $("#modal-tambah-produk").modal("show");
            $("textarea.textarea").maxlength({
                alwaysShow: true,
                placement: "top",
                warningClass: "badge badge-info",
                limitReachedClass: "badge badge-warning",
            });
            $(".select2").select2({
                width: "100%",
            });
            gambarproduk();
            simpan_produk();
        })
        .fail((res) => {
            let err = res.responseJSON;
            console.log(err);
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
            produk();
        });
};
//* Simpan Produk
const simpan_produk = () => {
    $(".simpan-produk").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".btn-simpan-produk").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $("#modal-tambah-produk").modal("hide");
                $(".btn-simpan-produk").html("Simpan");
                alert_msg("Berhasil", res.data);
                produk();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".simpan-produk input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".simpan-produk input,.simpan-produk select,.simpan-produk textarea"
                    ).each((i, obj) => {
                        let errinp = err.errors[obj.name];
                        if (errinp) {
                            $(`#${obj.name.replaceAll("_", "-")}`).addClass(
                                "is-invalid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}`).removeClass(
                                "is-valid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}-err`).text(
                                errinp
                            );
                        } else {
                            $(`#${obj.name.replaceAll("_", "-")}`).removeClass(
                                "is-invalid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}`).addClass(
                                "is-valid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}-err`).text("");
                        }
                    });
                } else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    produk();
                }
                $(".btn-simpan-produk").html("Simpan");
            });
    });
};
//* Modal Edit Produk
const edit_produk = () => {
    $(".edit-produk").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-produk").html(res.data);
                $("#modal-edit-produk").modal("show");
                $(".produk-img-icon").addClass("d-none");
                $(".produk-img").removeClass("d-none");
                $("textarea.textarea").maxlength({
                    alwaysShow: true,
                    placement: "top",
                    warningClass: "badge badge-info",
                    limitReachedClass: "badge badge-warning",
                });
                $(".select2").select2({
                    width: "100%",
                });
                gambarproduk();
                update_produk();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                produk();
            });
    });
};
//* Update Produk
const update_produk = () => {
    $(".update-produk").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".btn-update-produk").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $("#modal-edit-produk").modal("hide");
                $(".btn-update-produk").html("Update");
                alert_msg("Berhasil", res.data);
                produk();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".update-produk input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".update-produk input,.update-produk select,.update-produk textarea"
                    ).each((i, obj) => {
                        let errinp = err.errors[obj.name];
                        if (errinp) {
                            $(`#${obj.name.replaceAll("_", "-")}`).addClass(
                                "is-invalid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}`).removeClass(
                                "is-valid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}-err`).text(
                                errinp
                            );
                        } else {
                            $(`#${obj.name.replaceAll("_", "-")}`).removeClass(
                                "is-invalid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}`).addClass(
                                "is-valid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}-err`).text("");
                        }
                    });
                } else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    produk();
                }
                $(".btn-update-produk").html("Update");
            });
    });
};
//* Delete Produk
const delete_produk = () => {
    $(".hapus-produk").submit(function (e) {
        e.preventDefault();
        alert_confirm(
            "Hapus",
            `Hapus produk <strong>${
                $(this).serializeArray()[1].value
            }</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $(".btn-hapus-produk").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        alert_msg("Berhasil", res.data);
                        produk();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        produk();
                    });
            }
        );
    });
};

//! Upload Produk gambar
const gambarUpload = (element = null) => {
    let imgfile = $(`input[type=file]#${element}-gambar`);
    let img = $(".img");
    let imgicon = $(".img-icon");
    let imgtext = $(".img-text");

    imgfile.change(function () {
        const file = $(this).prop("files")[0];
        if (file) {
            imgtext.text(file.name);
            const reader = new FileReader();
            imgicon.addClass("d-none");
            img.removeClass("d-none");
            reader.onload = function () {
                img.attr("src", reader.result);
            };
            reader.readAsDataURL(file);
        } else {
            imgtext.text(`Pilih gambar ${element}`);
            img.attr("src", "");
            imgicon.toggleClass("d-none");
            img.toggleClass("d-none");
        }
    });
};
//! info konter
const konter = () => {
    const viewKonter = $("#content-view-konter");
    if (viewKonter) {
        $.ajax({
            url: viewKonter.data("url"),
        })
            .done((res) => {
                viewKonter.html(res.data);
                $("#datatable-konter").DataTable({
                    responsive: true,
                    autoWidth: false,
                });
                $(".image-popup-no-margins").magnificPopup({
                    type: "image",
                    closeOnContentClick: true,
                    closeBtnInside: false,
                    fixedContentPos: true,
                    mainClass: "mfp-no-margins mfp-with-zoom",
                    image: {
                        verticalFit: true,
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                    },
                });
                // edit_konter();
                // delete_konter();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
            });
    }
};
//! Modal Tambah Konter
const tambah_konter = (e) => {
    $.ajax({
        url: e.attr("href"),
    })
        .done((res) => {
            $("#modal-konter").html(res.data);
            $("#modal-tambah-konter").modal("show");
            gambarUpload("konter");
            simpan_konter();
        })
        .fail((res) => {
            let err = res.responseJSON;
            console.log(err);
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
            konter();
        });
};
//! Simpan Konter
const simpan_konter = () => {
    $(".simpan-konter").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".btn-simpan-konter").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $("#modal-tambah-konter").modal("hide");
                $(".btn-simpan-konter").html("Simpan");
                alert_msg("Berhasil", res.data);
                konter();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".simpan-konter input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(".simpan-konter input").each((i, obj) => {
                        let errinp = err.errors[obj.name];
                        if (errinp) {
                            $(`#${obj.name.replaceAll("_", "-")}`).addClass(
                                "is-invalid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}`).removeClass(
                                "is-valid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}-err`).text(
                                errinp
                            );
                        } else {
                            $(`#${obj.name.replaceAll("_", "-")}`).removeClass(
                                "is-invalid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}`).addClass(
                                "is-valid"
                            );
                            $(`#${obj.name.replaceAll("_", "-")}-err`).text("");
                        }
                    });
                } else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    konter();
                }
                $(".btn-simpan-konter").html("Simpan");
            });
    });
};
