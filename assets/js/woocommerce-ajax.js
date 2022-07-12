function photolabGetProducts() {

    event.preventDefault();

    const limit = '&limit=' +document.getElementById('products-limit').value;
    const category = '&category=' + document.getElementById('products-category-selected').value;
    const task = '&task=get';

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + task + limit + category )
        .then(response => response.json())
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
        .then(response => response.json())
        .then(data => console.log(data));

    return;

}
