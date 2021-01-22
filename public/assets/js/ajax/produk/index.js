function produk() {
    const viewProduk = $("#content-view-produk");
    if (viewProduk) {
        $.ajax({
            url: viewProduk.data('url'),
            type: 'get',
        }).done(function(res) {
            viewProduk.html(res);
        }).fail(function(err) {
            alert(err);
        });
    }
}
export {produk};