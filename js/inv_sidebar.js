var sideBarIsOpen = true;

//Sidebar Expansion and Compression
toggleMenu.addEventListener( 'click', (event) => {
    event.preventDefault(); //stops navigation of the browser
    
    if(sideBarIsOpen){
        //changes the size of the sidebar when the button is toggled
        dbSidebar.style.width = '10%'; 
        dbBody.style.width = '90%';

        //changes the sizes of contents
        dbLogo.style.width = '134px';
        dbLogo.style.height = '67px';
        dbSidebarUser.style.flexDirection = 'column';
        dbSidebarUser.style.gap = '5px';
        userImage.style.width = '60px';
        userImage.style.height = '60px';
        userName.style.fontSize = '18px';

        //hides the icons in the sidebar
        let menuText = document.querySelectorAll('.menuText'); //selects all variables with defined class
        menuText.forEach(text => {
            text.style.display = 'none';
            let parent = text.parentElement;
            parent.style.fontSize = '30px';
        });

        dbMenuList.style.textAlign = 'center';
        sideBarIsOpen = false;
    } else {
        //changes the size of the sidebar when the button is toggled
        dbSidebar.style.width = '20%';
        dbBody.style.width = '80%';

        //changes the sizes of contents
        dbLogo.style.width = '180px';
        dbLogo.style.height = '90px';
        dbSidebarUser.style.flexDirection = 'row';
        dbSidebarUser.style.gap = '15px';
        userImage.style.width = '80px';
        userImage.style.height = '80px';
        userName.style.fontSize = '30px';

        //hides the icons in the sidebar
        let menuText = document.querySelectorAll('.menuText'); //selects all variables with defined class
        menuText.forEach(text => {
            text.style.display = 'inline-block';
            let parent = text.parentElement;
            parent.style.fontSize = '20px';
        });

        dbMenuList.style.textAlign = 'left';
        sideBarIsOpen = true;
    }  
});

//Dropdown Submenus
document.addEventListener('click', function(e) {
    const clickedEl = e.target.closest('.toggleSubMenu');

    if(clickedEl){
        let subMenu = clickedEl.closest('li').querySelector('.subMenus');
        
        if(subMenu){
            if (subMenu.style.display === 'block') subMenu.style.display = 'none';
            else subMenu.style.display = 'block';
        }
    }
});
