$(function() {
    // Get All Produk
    produk()

    // Create Produk
    $('#tambah-produk').click(function(e){
        e.preventDefault()
        tambah_produk($(this))
    });
      
    // Alert Login
    let login_msg = $('.login_msg').data()
    if (login_msg) {
        alert_msg(login_msg.judul,login_msg.message,login_msg.type)
    }
});


const alert_msg = (judul,message,type) => {
    Swal.fire({
        title : judul,
        html : message,
        icon : type,
        confirmButtonColor: '#5b6be8',
    })    
}

// Produk image
const gambarproduk = () => {
    let produkimgfile = $('input[type=file]#produk-img-file')
    let produkimg = $('.produk-img')
    let produkimgicon = $('.produk-img-icon')
    let produkimgtext = $('.produk-img-text')

    produkimgfile.change(function() {
        const file = $(this).prop('files')[0]
        if (file) {
            produkimgtext.text(file.name)
            const reader = new FileReader()
            produkimgicon.addClass('d-none')
            produkimg.removeClass('d-none')
            reader.onload = function() {
                produkimg.attr('src',reader.result)
            }
            reader.readAsDataURL(file)
        }else{
            produkimgtext.text("Pilih gambar produk")
            produkimg.attr('src',"")
            produkimgicon.toggleClass('d-none')
            produkimg.toggleClass('d-none')
        }
    });
}

const produk = () => {
    const viewProduk = $("#content-view-produk")
    if (viewProduk) {
        $.ajax({
            url: viewProduk.data('url'),
            type: 'get',
        }).done(function(res) {
            viewProduk.html(res.data)
            // Datatables
            $("#datatable").DataTable({
                "responsive": true,
                "autoWidth": false,
            })
        }).fail(function(err) {
            console.log(err.responseJSON)
            alert(err.responseJSON)
        })
    }
}

const tambah_produk = e => {
    $.ajax({
        url : e.attr('href'),
        type: 'get',
        beforeSend: () => {
            e.addClass('disabled')
        }
    }).done(function(res) {
        $("#modal-produk").html(res.data)
        $('#modal-tambah-produk').modal('show')
        e.removeClass('disabled');
        gambarproduk()
        simpan_produk()
    }).fail(function(err) {
        console.log(err.responseJSON)
            alert(err.responseJSON)
    });
}

const simpan_produk = () => {
    $('#simpan-produk').submit(function(e) {
        e.preventDefault()
        $.ajax({
            url : $(this).attr('action'),
            type: 'post',
            data: $(this).serialize(),
            beforeSend: () => {
                $('.btn-simpan-produk').addClass('disabled')
            }
        }).done(function(res) {
            $('#simpan-produk input[name=csrf_test_name]').val(res.token)
            if (res.errors) {
                Object.keys(res.errors).map((objkey,i) => {
                        let err = res.errors[objkey]
                        if (objkey) {
                            $(`#${objkey.replaceAll('_','-')}`).addClass('is-invalid')
                            $(`#${objkey.replaceAll('_','-')}-err`).text(err)
                        }else{
                            $(`#${objkey.replaceAll('_','-')}`).removeClass('is-invalid')
                            $(`#${objkey.replaceAll('_','-')}-err`).text("")
                        }
                })
            }else{
                $('#modal-tambah-produk').modal('hide')
                $('.btn-simpan-produk').removeClass('disabled')
                produk()
            }
        }).fail(function(err) {
            console.log(err.responseJSON)
            alert(err.responseJSON)
        });
    })
}