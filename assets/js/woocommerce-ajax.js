function photolabPaginateProducts() {

    event.preventDefault();

    const limit = '&limit=' +document.getElementById('products-limit').value;
    const offset  = '&offset=' + document.getElementById('products-offset').value;
    const category = '&categories=' + document.getElementById('products-category').value;

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + limit + offset + category )
        .then(response => response.json())
        .then(data => console.log(data));

    return;

}
