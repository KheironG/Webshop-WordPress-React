function filterTrigger ( trigger ) {
    const filters = document.getElementById('product-filters');
    if ( trigger.id === 'filters-open' ) {
        filters.style.right = '0px';
    } else if ( trigger.id === 'filters-close' || trigger === 'filters-close' ) {
        if ( window.innerWidth > 1000 ) {
            filters.style.right = '-420px';
        } else {
            filters.style.right = '-100%';
        }
        setActiveFilters();
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
    const $filters = document.getElementsByClassName('filter');
    for ( let filter of $filters ) {
        if ( filter.checked == true ) {
            filter.checked = false;
        }
    }
    const $activeFilters = document.getElementById('active-filters');
    $activeFilters.textContent = '';
    filterTrigger.parentElement.parentElement.classList.remove('active');
    return;
}

function setActiveFilters () {

    const $filterGroups = document.getElementsByClassName('inputs');
    let groupStatus = {};
    for ( let filterGroup of $filterGroups ) {
        const key = filterGroup.previousElementSibling.firstElementChild.textContent;
        let active = false;
        for ( let input of filterGroup.children ) {
            if ( input.firstElementChild.checked === true ) {
                active = true;
            }
        }
        groupStatus[key] = active;
        if ( active === true ) {
            filterGroup.classList.remove('hidden');
        } else {
            filterGroup.classList.add('hidden');
        }
    }

    let activeGroups = 0;
    const statusValues = Object.values(groupStatus);
    statusValues.forEach(( item ) => {
        if ( item === true ) {
            activeGroups += 1
        }
    });

    const $activeFilters = document.getElementById('active-filters');
    const filterTrigger = $activeFilters.parentElement.parentElement;
    if ( activeGroups > 0 ) {
        $activeFilters.textContent = '( ' + activeGroups + ' )';
        filterTrigger.classList.add('active');
    } else {
        $activeFilters.textContent = '';
        filterTrigger.classList.remove('active');
    }

    return;
}
