import {produk} from './ajax/produk/index.js';
$(function() {
    // Datatables
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
      });

    // Alert Login
    let login_msg = $('.login_msg').data();
    if (login_msg) {
        message(login_msg.judul,login_msg.message,login_msg.type);        
    }

    // Produk
    produk();
});

const message = (judul,message,type) => {
    Swal.fire({
        title : judul,
        html : message,
        icon : type,
        confirmButtonColor: '#5b6be8',
    })    
}