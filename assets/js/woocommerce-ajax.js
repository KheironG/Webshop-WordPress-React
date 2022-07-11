function photolabGetProducts() {

    const xhr = new XMLHttpRequest();
    xhr.open('GET', woocommerce_ajax.ajax_url + '?action=photolab_ajax', true );
    xhr.onreadystatechange = function() {
        if ( this.readyState == 4 && this.status == 200 ) {

            const response  = JSON.parse(this.response);
            console.log(response);

        } else if ( this.status != 200 ) {
            console.log(this.status);
        }


}
    xhr.send();

}
