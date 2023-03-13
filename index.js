const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const formBoxLogin = document.querySelector('.form-boxlogin');
const formBoxRegister = document.querySelector('.form-boxregister');
const btnPopupLogin = document.querySelector('.btnLogin-popup');
const btnPopupRegister = document.querySelector('.btnRegister-popup');
const iconClose = document.querySelector('.icon-close');
// const loginRegisterButton = document.querySelector('.btn');

loginLink.addEventListener('click', ()=> {
    wrapper.classList.add('active-login');
    wrapper.classList.add('active-loginpopup');
    formBoxRegister.classList.add('inactive');
    wrapper.classList.remove('active-register');
    wrapper.classList.remove('active-registerpopup');
    formBoxLogin.classList.remove('inactive');
});

btnPopupLogin.addEventListener('click', ()=> {
    wrapper.classList.add('active-login');
    wrapper.classList.add('active-loginpopup');
    formBoxRegister.classList.add('inactive');
    wrapper.classList.remove('active-register');
    wrapper.classList.remove('active-registerpopup');
    formBoxLogin.classList.remove('inactive');
});

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active-register');
    wrapper.classList.add('active-registerpopup');
    formBoxLogin.classList.add('inactive');
    wrapper.classList.remove('active-login');
    wrapper.classList.remove('active-loginpopup');
    formBoxRegister.classList.remove('inactive');
});

btnPopupRegister.addEventListener('click', ()=> {
    wrapper.classList.add('active-register');
    wrapper.classList.add('active-registerpopup');
    formBoxLogin.classList.add('inactive');
    wrapper.classList.remove('active-login');
    wrapper.classList.remove('active-loginpopup');
    formBoxRegister.classList.remove('inactive');
});

iconClose.addEventListener('click', ()=> {
    wrapper.classList.remove('active-login');
    wrapper.classList.remove('active-loginpopup');
    formBoxLogin.classList.add('inactive');
    wrapper.classList.remove('active-register');
    wrapper.classList.remove('active-registerpopup');
    formBoxRegister.classList.add('inactive');
});