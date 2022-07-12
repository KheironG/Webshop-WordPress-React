function photolabGetProducts() {

    event.preventDefault();

    const limit = '&limit=' +document.getElementById('products-limit').value;
    const category = '&category=' + document.getElementById('products-category-selected').value;
    const task = '&task=get';

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + task + limit + category )
        .then(response => response.text())
        .then(data => console.log(data));

    return;

}

function photolabPaginateProducts() {

    event.preventDefault();

    const limit = '&limit=' +document.getElementById('products-limit').value;
    const offset  = '&offset=' + document.getElementById('products-offset').value;
    const category = '&categories=' + document.getElementById('products-category').value;
    const task = '&task=paginate';

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + task + limit + offset + category )
        .then(response => response.text())
        .then( html => {
            const domParser = new DOMParser();
            const products = domParser.parseFromString( html, "text/html");
            for ( let product of products.body.children ) {
                document.getElementById('product-previews-container').append(product);
            }
        } );

    return;

}
