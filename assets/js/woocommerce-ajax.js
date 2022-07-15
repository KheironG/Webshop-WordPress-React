function photolabGetProducts() {

    event.preventDefault();

    const container = document.getElementById('product-previews-container');
    container.innerHTML = '';

    const button = document.getElementById('paginate');

    const $limit = document.getElementById('products-limit');
    const $offset = document.getElementById('products-offset');
    const $category = document.getElementById('products-category-selected');
    const $total = document.getElementById('products-total');

    const limit = '&limit=' + $limit.value;
    const category = '&category=' + $category.value;
    const task = '&task=get';

    console.log(woocommerce_ajax.ajax_url + '?action=photolab_ajax' + task + limit + category);

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + task + limit + category )
        .then(response => response.text())
        .then(html => {
            const domParser = new DOMParser();
            const products = domParser.parseFromString( html, "text/html");
            for ( let product of products.body.children ) {
                container.append(product.cloneNode(true));
            }
        });

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + '&task=total' + category )
        .then(response => response.json())
        .then( total => {
            $total.value = total;
            $offset.value = $limit.value;
            document.getElementById('products-category').value = $category.value;
            if ( document.getElementById('products-total').value > $limit.value ) {
                button.classList.remove('hidden');
            } else {
                button.classList.add('hidden');
            }
        });

    return;

}

function photolabPaginateProducts() {

    event.preventDefault();

    const container = document.getElementById('product-previews-container');
    const button = document.getElementById('paginate');

    const $limit = document.getElementById('products-limit');
    const $offset = document.getElementById('products-offset');
    const $category = document.getElementById('products-category');
    const $total = document.getElementById('products-total');

    const limit = '&limit=' + $limit.value;
    const offset  = '&offset=' + $offset.value;
    const category = '&categories=' + $category.value;
    const task = '&task=paginate';

    fetch( woocommerce_ajax.ajax_url + '?action=photolab_ajax' + task + limit + offset + category )
        .then(response => response.text())
        .then( html => {
            const domParser = new DOMParser();
            const products = domParser.parseFromString( html, "text/html");
            for ( let product of products.body.children ) {
                container.append(product.cloneNode(true));
            }
            $offset.value = ( parseInt( $offset.value ) + parseInt( products.children.length ) );
            if ( document.getElementById('products-offset').value == $total.value ) {
                button.classList.add('hidden');
            }
        } );

    return;

}
