function filterTrigger ( trigger ) {
    const filters = document.getElementById('product-filters');
    if ( trigger.className === 'filters-open' ) {
        filters.style.right = '0px';
    } else if ( trigger.className === 'filters-close' ) {
        console.log(window.innerWidth);
        if ( window.innerWidth > 1000 ) {
            filters.style.right = '-420px';
        } else {
            filters.style.right = '-100%';
        }
    }
    return;
}

function filterGroupTrigger ( trigger ) {
    if ( trigger.nextElementSibling.classList.contains('hidden') ) {
        trigger.nextElementSibling.classList.remove('hidden');
        trigger.lastElementChild.className = 'fa-solid fa-caret-up';
    } else {
        trigger.nextElementSibling.classList.add('hidden');
        trigger.lastElementChild.className = 'fa-solid fa-caret-down';
    }
    return;
}

function clearFilters () {
    const filters = document.getElementsByClassName('filter');
    for ( let filter of filters ) {
        if ( filter.checked == true ) {
            filter.checked = false;
        }
    }
    return;
}
