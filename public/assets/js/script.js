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

    //* Info Stok
    stok();

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
/* Fungsi formatRupiah */
const formatRupiah = (angka, prefix = 'Rp.') => {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      let separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }
    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return `${prefix} ${rupiah}`;
}


// * info Stok
const stok = () => {
    const viewStok = $("#content-view-stok");
    if (viewStok) {
        $.ajax({
            url: viewStok.data("url"),
        })
            .done((res) => {
                viewStok.html(res.data);
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
                $(".select2").select2({
                    width: "100%",
                });
                edit_stok();
                infoStokGlobal();
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
const infoStokGlobal = () => {
    $(".form-info-stok").submit(function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".btn-info-stok").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
                $(".btn-info-stok").attr("disabled", true);
            },
        })
            .done((res) => {
                $(".btn-info-stok").html("Cari");
                $(".btn-info-stok").removeAttr("disabled");
                $(".form-info-stok input[name=csrf_test_name]").val(res.token);
                let stok_kartu = ``;
                let stok_acc = ``;
                $.each(res.data.stok_kartu, function( key, val ) {
                    stok_kartu += /* html */`
                        <div class="col-12">
                            <div class="info-box mt-3">
                                <span class="info-box-icon">
                                    ${(() => {
                                        if (val.produk_gambar) {
                                            return /* html */`
                                                <a class="image-popup-no-margins" href='assets/images/products/${val.produk_gambar}'>
                                                    <img src='assets/images/products/${val.produk_gambar}' class='rounded-circle img-fluid' alt='produk'>
                                                </a>`
                                        }
                                        return /* html */`<img src='https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=${val.produk_nama}' class='rounded-circle img-fluid' alt='produk'>`
                                    })()}
                                </span>

                                <div class="info-box-content">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">${val.produk_nama}</span>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">Stok : ${val.stok}</span>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">${formatRupiah(val.harga_user, 'IDR')}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>`;
                });
                $.each(res.data.stok_acc, function( key, val ) {
                    stok_acc += /* html */`
                        <div class="col-12">
                            <div class="info-box mt-3">
                                <span class="info-box-icon">
                                    ${(() => {
                                        if (val.produk_gambar) {
                                            return /* html */`
                                                <a class="image-popup-no-margins" href='assets/images/products/${val.produk_gambar}'>
                                                    <img src='assets/images/products/${val.produk_gambar}' class='rounded-circle img-fluid' alt='produk'>
                                                </a>`
                                        }
                                        return /* html */`<img src='https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=${val.produk_nama}' class='rounded-circle img-fluid' alt='produk'>`
                                    })()}
                                </span>

                                <div class="info-box-content">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">${val.produk_nama}</span>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">Stok : ${val.stok}</span>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">${formatRupiah(val.harga_user, 'IDR')}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>`;
                });
                $("#info-stok-kartu").html(stok_kartu);
                $("#info-stok-acc").html(stok_acc);
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                stok();
                $(".btn-info-stok").html("Cari");
            });
    });
}
//* Modal Edit Stok
const edit_stok = () => {
    $("body").on("click", ".edit-stok", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-stok").html(res.data);
                $("#modal-edit-stok").modal("show");
                $('#modal-edit-stok').on('hidden.bs.modal', function (e) {
                    $("#modal-stok").html(null);
                })
                $(".select2").select2({
                    width: "100%",
                });
                update_stok();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                stok();
            });
    });
};
//* Update Stok
const update_stok = () => {
    $(".update-stok").submit(function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".btn-update-stok").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $("#modal-edit-stok").modal("hide");
                $(".btn-update-stok").html("Update");
                alert_msg("Berhasil", res.data);
                stok();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                $(".update-stok input[name=csrf_test_name]").val(
                    err.token
                );
                if (err.errors) {
                    $(".update-stok input,.update-stok select").each((i, obj) => {
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
                }else if (err.empty_qty) {
                    alert_msg(
                        `Warning`,
                        `<h6><strong>${err.empty_qty.title}</strong></h6><br>${err.empty_qty.message}`,
                        "warning"
                    );
                    stok();
                }else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    stok();
                }
                $(".btn-update-stok").html("Update");
            });
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
const tambah_produk = e => {
    $.ajax({
        url: e.attr("href"),
    })
        .done((res) => {
            $("#modal-produk").html(res.data);
            $("#modal-tambah-produk").modal("show");
            $('#modal-tambah-produk').on('hidden.bs.modal', function (e) {
                $("#modal-produk").html(null);
            })
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
    $("body").on("click", ".edit-produk", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-produk").html(res.data);
                $("#modal-edit-produk").modal("show");
                $('#modal-edit-produk').on('hidden.bs.modal', function (e) {
                    $("#modal-produk").html(null);
                })
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
    $("body").on("submit", ".hapus-produk", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
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
