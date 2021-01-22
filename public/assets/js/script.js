$(function() {
    // Datatables
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
      });

    // Alert Login
    let login_msg = $('.login_msg').data();
    if (login_msg) {
        alert_msg(login_msg.judul,login_msg.message,login_msg.type);        
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