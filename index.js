// Login/Register popups
const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const formBoxLogin = document.querySelector('.form-boxlogin');
const formBoxRegister = document.querySelector('.form-boxregister');
const btnPopupLogin = document.querySelector('.btnLogin-popup');
const btnPopupRegister = document.querySelector('.btnRegister-popup');
const iconClose = document.querySelector('.icon-close');
const navbarcars = document.getElementById("cars");
const bttBtn = document.querySelector('.back-to-top');
const aboutus = document.getElementById("aboutus");

if(loginLink != null) {
    loginLink.addEventListener('click', function(e) {
        e.preventDefault();
        wrapper.classList.add('active-login');
        wrapper.classList.add('active-loginpopup');
        formBoxRegister.classList.add('inactive');
        wrapper.classList.remove('active-register');
        wrapper.classList.remove('active-registerpopup');
        formBoxLogin.classList.remove('inactive');

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

if(btnPopupLogin != null) {

    btnPopupLogin.addEventListener('click', function(e) {
        e.preventDefault();
        wrapper.classList.add('active-login');
        wrapper.classList.add('active-loginpopup');
        formBoxRegister.classList.add('inactive');
        wrapper.classList.remove('active-register');
        wrapper.classList.remove('active-registerpopup');
        formBoxLogin.classList.remove('inactive');
    
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
    
}

if(registerLink != null) {

    registerLink.addEventListener('click', function(e) {
        e.preventDefault();
        wrapper.classList.add('active-register');
        wrapper.classList.add('active-registerpopup');
        formBoxLogin.classList.add('inactive');
        wrapper.classList.remove('active-login');
        wrapper.classList.remove('active-loginpopup');
        formBoxRegister.classList.remove('inactive');

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

}

if(btnPopupRegister != null) {

    btnPopupRegister.addEventListener('click', function(e) {
        e.preventDefault();
        wrapper.classList.add('active-register');
        wrapper.classList.add('active-registerpopup');
        formBoxLogin.classList.add('inactive');
        wrapper.classList.remove('active-login');
        wrapper.classList.remove('active-loginpopup');
        formBoxRegister.classList.remove('inactive');
    
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

if(iconClose != null) {

    iconClose.addEventListener('click', function(e) {
        e.preventDefault();
        wrapper.classList.remove('active-login');
        wrapper.classList.remove('active-loginpopup');
        formBoxLogin.classList.add('inactive');
        wrapper.classList.remove('active-register');
        wrapper.classList.remove('active-registerpopup');
        formBoxRegister.classList.add('inactive');
    });

}

// Cars section scrolldown
if(navbarcars != null) {

    navbarcars.addEventListener('click', function(e) {
        e.preventDefault();

        // Calculate the offset of the "Our Cars" heading
        var ourCarsOffset = document.getElementById("our-cars").offsetTop;

        // Subtract a certain amount from the offset
        var stickyStopOffset = ourCarsOffset - 69;

        window.scrollTo({
            top: stickyStopOffset,
            behavior: "smooth"
        });

    });
}


//Back to top button
if(bttBtn != null) {

    bttBtn.addEventListener('click', function(e) {
        e.preventDefault();

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

}


// About Us section scrolldown
if(aboutus != null) {

    aboutus.addEventListener('click', function(e) {
        e.preventDefault();

        // Calculate the offset of the "Our Cars" heading
        var ourCarsOffset = document.getElementById("aboutusfooter").offsetTop;

        window.scrollTo({
            top: ourCarsOffset,
            behavior: "smooth"
        });

    });

}