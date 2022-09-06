function categoryTrigger ( trigger ) {
    const categoryTabs = document.getElementsByClassName('category');
    for ( let categoryTab of categoryTabs ) {
        let parent = categoryTab.parentElement;
        if ( parent === trigger ) {
            parent.classList.add('active');
        } else {
            parent.classList.remove('active');
        }
    }
    //below function declared in woocommerce-ajax.js
    getProducts();
    return;
}
