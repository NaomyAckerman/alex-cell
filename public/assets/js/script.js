$(function () {
    // ? Konter
    // * Info Konter
    konter();
    // * Create Konter
    $(".tambah-konter").click(function (e) {
        e.preventDefault();
        tambah_konter($(this));
    });
    
    // ? Produk
    //* Info Produk
    produk();
    //* Create Produk
    $(".tambah-produk").click(function (e) {
        e.preventDefault();
        tambah_produk($(this));
    });
    
    // ? User
    //* Info user
    user();
    profile();
    //* Create user
    $(".tambah-user").click(function (e) {
        e.preventDefault();
        tambahUser($(this));
    });

    // ? Stok
    //* Info Stok
    stok();
    
    // ? trx
    //* Info trx-saldo
    trxSaldo();
    //* Create trx-saldo
    $(".tambah-trx-saldo").click(function (e) {
        e.preventDefault();
        tambahTrxSaldo($(this));
    });
    
    //* Info trx-reseller
    trxReseller();
    //* Create trx-reseller
    $(".tambah-trx-reseller").click(function (e) {
        e.preventDefault();
        tambahTrxReseller($(this));
    });

    //* Info trx-acc
    trxAcc();
    //* Create trx-acc
    $(".tambah-trx-acc").click(function (e) {
        e.preventDefault();
        tambahTrxAcc($(this));
    });

    //* Info trx-kartu
    trxKartu();
    //* Create trx-kartu
    $(".tambah-trx-kartu").click(function (e) {
        e.preventDefault();
        tambahTrxKartu($(this));
    });

    //* Info trx-rekap
    trxRekap();
    //* info trx
    infoTrx()

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
// * Fungsi formatRupiah
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

// ? Stok
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
                            <div class="info-box mt-3 shadow">
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
                            <div class="info-box mt-3 shadow">
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


// ? Produk
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
                    iDisplayLength: 5,
                    aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
                    fnDrawCallback: function () {
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
                    }
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
    $("body").on('submit','.simpan-produk',function (e) {
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
        e.stopPropagation();
        e.stopImmediatePropagation();
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


// ? User
//* Upload Avatar gambar
const gambarAvatar = () => {
    let avatarimgfile = $("input[type=file]#avatar");
    let avatarimg = $(".avatar-img");
    let avatarimgicon = $(".avatar-img-icon");
    let avatarimgtext = $(".avatar-img-text");
    avatarimgfile.change(function () {
        const file = $(this).prop("files")[0];
        if (file) {
            avatarimgtext.text(file.name);
            const reader = new FileReader();
            avatarimgicon.addClass("d-none");
            avatarimg.removeClass("d-none");
            reader.onload = function () {
                avatarimg.attr("src", reader.result);
            };
            reader.readAsDataURL(file);
        } else {
            avatarimgtext.text("Pilih gambar avatar");
            avatarimg.attr("src", "");
            avatarimgicon.toggleClass("d-none");
            avatarimg.toggleClass("d-none");
        }
    });
};
//* info User
const user = () => {
    const viewUser = $("#content-view-user");
    if (viewUser) {
        $.ajax({
            url: viewUser.data("url"),
        })
            .done((res) => {
                viewUser.html(res.data);
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
                detailUser()
                deleteUser()
                blockUser()
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
//* Modal Tambah user
const tambahUser = e => {
    $.ajax({
        url: e.attr("href"),
    })
        .done((res) => {
            $("#modal-user").html(res.data);
            $("#modal-tambah-user").modal("show");
            $('#modal-tambah-user').on('hidden.bs.modal', function (e) {
                $("#modal-user").html(null);
            })
            $(".select2").select2({
                width: "100%",
            });
            simpanUser();
        })
        .fail((res) => {
            let err = res.responseJSON;
            console.log(err);
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
            user();
        });
};
//* Simpan user
const simpanUser = () => {
    $("body").on('submit','.simpan-user',function (e) {
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
                $(".btn-simpan-user").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $("#modal-tambah-user").modal("hide");
                $(".btn-simpan-user").html("Simpan");
                alert_msg("Berhasil", res.data);
                user();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".simpan-user input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".simpan-user input,.simpan-user select,.simpan-user textarea"
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
                    user();
                }
                $(".btn-simpan-user").html("Simpan");
            });
    });
};
// * Detail User
const detailUser = e => {
    $(".detail-user").click(function (e) {
        e.preventDefault();
        let user = $(this).data("user")
        console.log(user)
        alert_msg(
            `Info`,
            `<h5>Nama ${user.nama}<strong></strong></h5><br><h6>Alamat : ${user.alamat}<h6><br>No hp : ${user.no_telp}`,
            "info"
        );        
    });
};
//* Delete user
const deleteUser = () => {
    $("body").on("submit", ".hapus-user", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Hapus",
            `Hapus Karyawan <strong>${
                $(this).serializeArray()[1].value
            }</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $(".btn-hapus-user").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        alert_msg("Berhasil", res.data);
                        user();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        user();
                    });
            }
        );
    });
};
//* Block user
const blockUser = () => {
    $("body").on("submit", ".block-user", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Block",
            `Block Karyawan <strong>${
                $(this).serializeArray()[1].value
            }</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $(".btn-block-user").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        alert_msg("Berhasil", res.data);
                        user();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        user();
                    });
            }
        );
    });
};
//* info Profile
const profile = () => {
    const viewProfile = $("#content-view-profile");
    if (viewProfile) {
        $.ajax({
            url: viewProfile.data("url"),
        })
            .done((res) => {
                viewProfile.html(res.data);
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
                $(".avatar-img-icon").addClass("d-none");
                $(".avatar-img").removeClass("d-none");
                gambarAvatar();
                updateProfile();
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
//* Update Profile
const updateProfile = () => {
    $(".update-profile").submit(function (e) {
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
                $(".btn-update-profile").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                alert_msg("Berhasil", res.data);
                profile();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".update-profile input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".update-profile input"
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
                    profile();
                }
                $(".btn-update-profile").html("Update");
            });
    });
};


// ? Konter
// // Upload Konter gambar
// const gambarUpload = (element = null) => {
//     let imgfile = $(`input[type=file]#${element}-gambar`);
//     let img = $(".img");
//     let imgicon = $(".img-icon");
//     let imgtext = $(".img-text");

//     imgfile.change(function () {
//         const file = $(this).prop("files")[0];
//         if (file) {
//             imgtext.text(file.name);
//             const reader = new FileReader();
//             imgicon.addClass("d-none");
//             img.removeClass("d-none");
//             reader.onload = function () {
//                 img.attr("src", reader.result);
//             };
//             reader.readAsDataURL(file);
//         } else {
//             imgtext.text(`Pilih gambar ${element}`);
//             img.attr("src", "");
//             imgicon.toggleClass("d-none");
//             img.toggleClass("d-none");
//         }
//     });
// };
//* Upload Avatar gambar
const gambarKonter = () => {
    let konterimgfile = $("input[type=file]#konter-gambar");
    let konterimg = $(".konter-img");
    let konterimgicon = $(".konter-img-icon");
    let konterimgtext = $(".konter-img-text");
    konterimgfile.change(function () {
        const file = $(this).prop("files")[0];
        if (file) {
            konterimgtext.text(file.name);
            const reader = new FileReader();
            konterimgicon.addClass("d-none");
            konterimg.removeClass("d-none");
            reader.onload = function () {
                konterimg.attr("src", reader.result);
            };
            reader.readAsDataURL(file);
        } else {
            konterimgtext.text("Pilih gambar konter");
            konterimg.attr("src", "");
            konterimgicon.toggleClass("d-none");
            konterimg.toggleClass("d-none");
        }
    });
};
//* info konter
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
                    iDisplayLength: 5,
                    aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]
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
                edit_konter();
                delete_konter();
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
//* Modal Tambah Konter
const tambah_konter = (e) => {
    $.ajax({
        url: e.attr("href"),
    })
        .done((res) => {
            $("#modal-konter").html(res.data);
            $("#modal-tambah-konter").modal("show");
            gambarKonter();
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
//* Simpan Konter
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
// * Modal Edit konter
const edit_konter = () => {
    $("body").on("click", ".edit-konter", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-konter").html(res.data);
                $("#modal-edit-konter").modal("show");
                $('#modal-edit-konter').on('hidden.bs.modal', function (e) {
                    $("#modal-konter").html(null);
                })
                $(".konter-img-icon").addClass("d-none");
                $(".konter-img").removeClass("d-none");
                gambarKonter();
                update_konter();
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
    });
};
// * Update konter
const update_konter = () => {
    $(".update-konter").submit(function (e) {
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
                $(".btn-update-konter").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $("#modal-edit-konter").modal("hide");
                $(".btn-update-konter").html("Update");
                alert_msg("Berhasil", res.data);
                konter();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".update-konter input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".update-konter input,.update-konter select,.update-konter textarea"
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
                    konter();
                }
                $(".btn-update-konter").html("Update");
            });
    });
};
// * Delete konter
const delete_konter = () => {
    $("body").on("submit", ".hapus-konter", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Hapus",
            `Hapus konter <strong>${
                $(this).serializeArray()[1].value
            }</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $(".btn-hapus-konter").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        alert_msg("Berhasil", res.data);
                        konter();
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
            }
        );
    });
};


// ? Transaksi
// * trx saldo
// * info trx-saldo
const trxSaldo = () => {
    const viewTrxSaldo = $("#content-view-trx-saldo");
    if (viewTrxSaldo) {
        $.ajax({
            url: viewTrxSaldo.data("url"),
        })
            .done((res) => {
                viewTrxSaldo.html(res.data);
                editTrxSaldo();
                deleteTrxSaldo();
                submitTrxSaldo();
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
//* Modal Tambah trx-saldo
const tambahTrxSaldo = e => {
    $.ajax({
        url: e.attr("href"),
    }).done((res) => {
        $("#modal-trx-saldo").html(res.data);
        $("#modal-tambah-trx-saldo").modal("show");
        $('#modal-tambah-trx-saldo').on('hidden.bs.modal', function (e) {
            $("#modal-trx-saldo").html(null);
        })
        simpanTrxSaldo();
    }).fail((res) => {
        let err = res.responseJSON;
        console.log(err);
        if (err.submit_err) {
            alert_msg(
                `Warning`,
                `<h6><strong>${err.submit_err.title}</strong></h6><br>${err.submit_err.message}`,
                "warning"
            );
            $("#modal-tambah-trx-saldo").modal("hide");
        }else{
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
        }
        trxSaldo();
    })
}
//* Simpan trx-saldo
const simpanTrxSaldo = () => {
    $("body").on('submit','.simpan-trx-saldo',function (e) {
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
                $(".btn-simpan-trx-saldo").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-tambah-trx-saldo').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-saldo").html(null);
                })
                $("#modal-tambah-trx-saldo").modal("hide");
                $(".btn-simpan-trx-saldo").html("Simpan");
                alert_msg("Berhasil", res.data);
                trxSaldo();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".simpan-trx-saldo input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".simpan-trx-saldo input"
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
                    trxSaldo();
                }
                $(".btn-simpan-trx-saldo").html("Simpan");
            });
    });
};
//* Modal Edit trx-saldo
const editTrxSaldo = () => {
    $("body").on("click", ".edit-trx-saldo", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-trx-saldo").html(res.data);
                $("#modal-edit-trx-saldo").modal("show");
                $('#modal-edit-trx-saldo').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-saldo").html(null);
                })
                updateTrxSaldo();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                trxSaldo();
            });
    });
};
//* Update trx-saldo
const updateTrxSaldo = () => {
    $(".update-trx-saldo").submit(function (e) {
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
                $(".btn-update-trx-saldo").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-edit-trx-saldo').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-saldo").html(null);
                })
                $("#modal-edit-trx-saldo").modal("hide");
                $(".btn-update-trx-saldo").html("Update");
                alert_msg("Berhasil", res.data);
                trxSaldo();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.errors) {
                    $(".update-trx-saldo input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".update-trx-saldo input"
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
                    trxSaldo();
                }
                $(".btn-update-trx-produk").html("Update");
            });
    });
};
//* Delete trx-saldo
const deleteTrxSaldo = () => {
    $("body").on("submit", ".hapus-trx-saldo", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Hapus",
            `Hapus Transaksi <strong>${
                $(this).serializeArray()[1].value
            }</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $(".btn-hapus-trx-saldo").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        alert_msg("Berhasil", res.data);
                        trxSaldo();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        trxSaldo();
                    });
            }
        );
    });
};
// * submit trx-saldo
const submitTrxSaldo = () => {
    $("body").on('submit', '.submit-trx-saldo', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Submit",
            `Apakah anda yakin <strong>Submit Transaksi</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $(".btn-submit-trx-saldo").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        $(".btn-submit-trx-saldo").html("Submit Transaksi");
                        alert_msg("Berhasil", res.submit);
                        trxSaldo();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        trxSaldo();
                        $(".btn-submit-trx-saldo").html("Submit Transaksi");
                    });
            }
        );
    });
};


// * trx reseller
// * info trx-reseller
const trxReseller = () => {
    const viewTrxReseller = $("#content-view-trx-reseller");
    if (viewTrxReseller) {
        $.ajax({
            url: viewTrxReseller.data("url"),
        })
            .done((res) => {
                viewTrxReseller.html(res.data);
                deleteTrxReseller();
                submitTrxReseller();
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
//* Modal Tambah trx-reseller
const tambahTrxReseller = e => {
    $.ajax({
        url: e.attr("href"),
    }).done((res) => {
        $("#modal-trx-reseller").html(res.data);
        $("#modal-tambah-trx-reseller").modal("show");
        $('#modal-tambah-trx-reseller').on('hidden.bs.modal', function (e) {
            $("#modal-trx-reseller").html(null);
        })
        $(".select2").select2({
            width: "100%",
        });
        simpanTrxReseller();
    }).fail((res) => {
        let err = res.responseJSON;
        console.log(err);
        if (err.submit_err) {
            alert_msg(
                `Warning`,
                `<h6><strong>${err.submit_err.title}</strong></h6><br>${err.submit_err.message}`,
                "warning"
            );
            $("#modal-tambah-trx-reseller").modal("hide");
        }else{
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
        }
        trxReseller();
    })
}
//* Simpan trx-reseller
const simpanTrxReseller = () => {
    $('.simpan-trx-reseller').submit(function (e) {
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
                $(".btn-simpan-trx-reseller").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-tambah-trx-reseller').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-reseller").html(null);
                })
                $("#modal-tambah-trx-reseller").modal("hide");
                $(".btn-simpan-trx-reseller").html("Simpan");
                alert_msg("Berhasil", res.data);
                trxReseller();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.err) {
                    alert_msg(
                        `Warning`,
                        `<h6><strong>${err.err.title}</strong></h6><br>${err.err.message}`,
                        "warning"
                    );
                    $(".simpan-trx-reseller input[name=csrf_test_name]").val(
                        err.token
                    );
                } else if (err.errors) {
                    $(".simpan-trx-reseller input[name=csrf_test_name]").val(
                        err.token
                    );
                    $(
                        ".simpan-trx-reseller input, .simpan-trx-reseller select"
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
                    trxReseller();
                }
                $(".btn-simpan-trx-reseller").html("Simpan");
            });
    });
};
//* Delete trx-reseller
const deleteTrxReseller = () => {
    $("body").on("submit", ".hapus-trx-reseller", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Hapus",
            `Hapus Transaksi <strong>${
                $(this).serializeArray()[2].value
            } milik ${
                $(this).serializeArray()[3].value
            }</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $(".btn-hapus-trx-reseller").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        alert_msg("Berhasil", res.data);
                        trxReseller();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        trxReseller();
                    });
            }
        );
    });
};
// * submit trx-reseller
const submitTrxReseller = () => {
    $("body").on('submit', '.submit-trx-reseller', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Submit",
            `Apakah anda yakin <strong>Submit Transaksi</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $(".btn-submit-trx-reseller").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        $(".btn-submit-trx-reseller").html("Submit Transaksi");
                        alert_msg("Berhasil", res.submit);
                        trxReseller();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        trxSaldo();
                        $(".btn-submit-trx-reseller").html("Submit Transaksi");
                    });
            }
        );
    });
};


// * trx acc
// * info trx-acc
const trxAcc = () => {
    const viewTrxAcc = $("#content-view-trx-acc");
    if (viewTrxAcc) {
        $.ajax({
            url: viewTrxAcc.data("url"),
        })
            .done((res) => {
                viewTrxAcc.html(res.data);
                editTrxAcc();
                submitTrxAcc();
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
//* Modal Tambah trx-acc
const tambahTrxAcc = e => {
    $.ajax({
        url: e.attr("href"),
    }).done((res) => {
        $("#modal-trx-acc").html(res.data);
        $("#modal-tambah-trx-acc").modal("show");
        $('#modal-tambah-trx-acc').on('hidden.bs.modal', function (e) {
            $("#modal-trx-acc").html(null);
        })
        simpanTrxAcc();
    }).fail((res) => {
        let err = res.responseJSON;
        console.log(err);
        if (err.submit_err) {
            alert_msg(
                `Warning`,
                `<h6><strong>${err.submit_err.title}</strong></h6><br>${err.submit_err.message}`,
                "warning"
            );
            $("#modal-tambah-trx-acc").modal("hide");
        }else if(err.tambah_err){
            alert_msg(
                `Warning`,
                `<h6><strong>${err.tambah_err.title}</strong></h6><br>${err.tambah_err.message}`,
                "warning"
            );
            $("#modal-tambah-trx-acc").modal("hide");
        }else{
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
        }
        trxAcc();
    })
}
//* Simpan trx-acc
const simpanTrxAcc = () => {
    $('.simpan-trx-acc').submit(function (e) {
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
                $(".btn-simpan-trx-acc").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-tambah-trx-acc').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-acc").html(null);
                })
                $("#modal-tambah-trx-acc").modal("hide");
                $(".btn-simpan-trx-acc").html("Simpan");
                alert_msg("Berhasil", res.data);
                trxAcc();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.err) {
                    alert_msg(
                        err.err.tipe,
                        `<h6><strong>${err.err.title}</strong></h6><br>${err.err.message}`,
                        "warning"
                    );
                    $(".simpan-trx-acc input[name=csrf_test_name]").val(
                        err.token
                    );
                }else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    trxAcc();
                }
                $(".btn-simpan-trx-acc").html("Simpan");
            });
    });
};
//* Modal Edit trx-acc
const editTrxAcc = () => {
    $("body").on("click", ".edit-trx-acc", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-trx-acc").html(res.data);
                $("#modal-edit-trx-acc").modal("show");
                $('#modal-edit-trx-acc').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-acc").html(null);
                })
                updateTrxAcc();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                trxAcc();
            });
    });
};
//* Update trx-acc
const updateTrxAcc = () => {
    $(".update-trx-acc").submit(function (e) {
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
                $(".btn-update-trx-acc").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-edit-trx-acc').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-acc").html(null);
                })
                $("#modal-edit-trx-acc").modal("hide");
                $(".btn-update-trx-acc").html("Update");
                alert_msg("Berhasil", res.data);
                trxAcc();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.err) {
                    alert_msg(
                        err.err.tipe,
                        `<h6><strong>${err.err.title}</strong></h6><br>${err.err.message}`,
                        "warning"
                    );
                    $(".update-trx-acc input[name=csrf_test_name]").val(
                        err.token
                    );
                }else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    trxAcc();
                }
                $(".btn-update-trx-acc").html("Update");
            });
    });
};
// * submit trx-acc
const submitTrxAcc = () => {
    $("body").on('submit', '.submit-trx-acc', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Submit",
            `Apakah anda yakin <strong>Submit Transaksi</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $(".btn-submit-trx-acc").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        $(".btn-submit-trx-acc").html("Submit Transaksi");
                        alert_msg("Berhasil", res.submit);
                        trxAcc();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        trxAcc();
                        $(".btn-submit-trx-acc").html("Submit Transaksi");
                    });
            }
        );
    });
};

// * trx kartu
// * info trx-kartu
const trxKartu = () => {
    const viewTrxKartu = $("#content-view-trx-kartu");
    if (viewTrxKartu) {
        $.ajax({
            url: viewTrxKartu.data("url"),
        })
            .done((res) => {
                viewTrxKartu.html(res.data);
                editTrxKartu();
                submitTrxKartu();
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
//* Modal Tambah trx-kartu
const tambahTrxKartu = e => {
    $.ajax({
        url: e.attr("href"),
    }).done((res) => {
        $("#modal-trx-kartu").html(res.data);
        $("#modal-tambah-trx-kartu").modal("show");
        $('#modal-tambah-trx-kartu').on('hidden.bs.modal', function (e) {
            $("#modal-trx-kartu").html(null);
        })
        simpanTrxKartu();
    }).fail((res) => {
        let err = res.responseJSON;
        console.log(err);
        if (err.submit_err) {
            alert_msg(
                `Warning`,
                `<h6><strong>${err.submit_err.title}</strong></h6><br>${err.submit_err.message}`,
                "warning"
            );
            $("#modal-tambah-trx-kartu").modal("hide");
        }else if(err.tambah_err){
            alert_msg(
                `Warning`,
                `<h6><strong>${err.tambah_err.title}</strong></h6><br>${err.tambah_err.message}`,
                "warning"
            );
            $("#modal-tambah-trx-kartu").modal("hide");
        }else{
            alert_msg(
                `Error ${err.code}`,
                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                "error"
            );
        }
        trxKartu();
    })
}
//* Simpan trx-kartu
const simpanTrxKartu = () => {
    $('.simpan-trx-kartu').submit(function (e) {
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
                $(".btn-simpan-trx-kartu").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-tambah-trx-kartu').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-kartu").html(null);
                })
                $("#modal-tambah-trx-kartu").modal("hide");
                $(".btn-simpan-trx-kartu").html("Simpan");
                alert_msg("Berhasil", res.data);
                trxKartu();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.err) {
                    alert_msg(
                        err.err.tipe,
                        `<h6><strong>${err.err.title}</strong></h6><br>${err.err.message}`,
                        "warning"
                    );
                    $(".simpan-trx-kartu input[name=csrf_test_name]").val(
                        err.token
                    );
                }else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    trxKartu();
                }
                $(".btn-simpan-trx-kartu").html("Simpan");
            });
    });
};
//* Modal Edit trx-kartu
const editTrxKartu = () => {
    $("body").on("click", ".edit-trx-kartu", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr("href"),
        })
            .done((res) => {
                $("#modal-trx-kartu").html(res.data);
                $("#modal-edit-trx-kartu").modal("show");
                $('#modal-edit-trx-kartu').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-kartu").html(null);
                })
                updateTrxKartu();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                trxKartu();
            });
    });
};
//* Update trx-kartu
const updateTrxKartu = () => {
    $(".update-trx-kartu").submit(function (e) {
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
                $(".btn-update-trx-kartu").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
            },
        })
            .done((res) => {
                $('#modal-edit-trx-kartu').on('hidden.bs.modal', function (e) {
                    $("#modal-trx-kartu").html(null);
                })
                $("#modal-edit-trx-kartu").modal("hide");
                $(".btn-update-trx-kartu").html("Update");
                alert_msg("Berhasil", res.data);
                trxKartu();
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                if (err.err) {
                    alert_msg(
                        err.err.tipe,
                        `<h6><strong>${err.err.title}</strong></h6><br>${err.err.message}`,
                        "warning"
                    );
                    $(".update-trx-kartu input[name=csrf_test_name]").val(
                        err.token
                    );
                }else {
                    alert_msg(
                        `Error ${err.code}`,
                        `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                        "error"
                    );
                    trxKartu();
                }
                $(".btn-update-trx-kartu").html("Update");
            });
    });
};
// * submit trx-kartu
const submitTrxKartu = () => {
    $("body").on('submit', '.submit-trx-kartu', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        alert_confirm(
            "Submit",
            `Apakah anda yakin <strong>Submit Transaksi</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $(".btn-submit-trx-kartu").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        $(".btn-submit-trx-kartu").html("Submit Transaksi");
                        alert_msg("Berhasil", res.submit);
                        trxKartu();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        alert_msg(
                            `Error ${err.code}`,
                            `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                            "error"
                        );
                        trxKartu();
                        $(".btn-submit-trx-kartu").html("Submit Transaksi");
                    });
            }
        );
    });
};

// * trx rekap
// * info trx-rekap
const trxRekap = () => {
    const viewTrxRekap = $("#content-view-trx-rekap");
    if (viewTrxRekap) {
        $.ajax({
            url: viewTrxRekap.data("url"),
        })
            .done((res) => {
                viewTrxRekap.html(res.data);
                $("#datatable-rekap-kartu").DataTable({
                    responsive: true,
                    autoWidth: false,
                    iDisplayLength: 5,
                    aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]
                });
                $("#datatable-rekap-acc").DataTable({
                    responsive: true,
                    autoWidth: false,
                    iDisplayLength: 5,
                    aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]
                });
                submitTrxRekap();
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
// * submit trx-rekap
const submitTrxRekap = () => {
    $("body").on('submit', '.submit-trx-rekap', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        console.log(new FormData(this))
        alert_confirm(
            "Submit",
            `Apakah anda yakin <strong>Submit Rekap Transaksi</strong>`,
            () => {
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $(".btn-submit-trx-rekap").html(
                            '<i class="fa fa-spin fa-cog"></i>'
                        );
                    },
                })
                    .done((res) => {
                        $(".btn-submit-trx-rekap").html("Submit Transaksi");
                        alert_msg("Berhasil", res.submit);
                        trxRekap();
                    })
                    .fail((res) => {
                        let err = res.responseJSON;
                        console.log(err);
                        if (err.err) {
                            alert_msg(
                                err.err.tipe,
                                `<h6><strong>${err.err.title}</strong></h6><br>${err.err.message}`,
                                "warning"
                            );
                            $(".submit-trx-rekap input[name=csrf_test_name]").val(
                                err.token
                            );
                        }else{
                            alert_msg(
                                `Error ${err.code}`,
                                `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                                "error"
                            );
                        }
                        trxRekap();
                        $(".btn-submit-trx-rekap").html("Submit Transaksi");
                    });
            }
        );
    });
};
// * info trx
const infoTrx = () => {
    $(".info-trx").submit(function (e) {
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
                $(".btn-info-trx").html(
                    '<i class="fa fa-spin fa-cog"></i>'
                );
                $(".btn-info-trx").attr("disabled", true);
            },
        })
            .done((res) => {
                $(".btn-info-trx").html("Cari");
                $(".btn-info-trx").removeAttr("disabled");
                $(".info-trx input[name=csrf_test_name]").val(res.token);
                $("#content-view-info-trx").html(res.data);
                $("#datatable").DataTable({
                    responsive: true,
                    autoWidth: false,
                    iDisplayLength: 5,
                    aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]
                });
                $("#datatable2").DataTable({
                    responsive: true,
                    autoWidth: false,
                    iDisplayLength: 5,
                    aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]
                });
            })
            .fail((res) => {
                let err = res.responseJSON;
                console.log(err);
                alert_msg(
                    `Error ${err.code}`,
                    `<h6><strong>${err.title}</strong></h6><br>${err.message}`,
                    "error"
                );
                $(".info-trx input[name=csrf_test_name]").val(res.token);
                $(".btn-info-trx").html("Cari");
            });
    });
}