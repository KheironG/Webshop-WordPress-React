function mainMenu( trigger ) {

    const childTriggers = document.getElementsByClassName('parent-expander');
    for ( let childTrigger of childTriggers ) {
        let icon = childTrigger.lastElementChild;
        if ( childTrigger == trigger && icon.className === 'fa-solid fa-angle-down' ) {
            childTrigger.style.color = 'black';
            icon.className = 'fa-solid fa-angle-up';
        } else {
            icon.className = 'fa-solid fa-angle-down';
            childTrigger.style.color = '#999393';
        }
    }

    const childContainers = document.getElementsByClassName('menu-children');
    let thisContainer = trigger.nextElementSibling;
    for ( let childContainer of childContainers ) {
        if ( childContainer == thisContainer && childContainer.classList.contains('hidden') ) {
            childContainer.classList.remove('hidden')
        } else {
            childContainer.classList.add('hidden')
        }
    }

}

function toggleMobileMenu ( trigger ) {
    const menu = document.getElementById('main-menu');
    if ( trigger.id === 'hamburger' ) {
        menu.style.display = 'flex';
    } else {
        menu.style.display = 'none';
    }
}
