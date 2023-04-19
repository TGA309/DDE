//Elements from the homepage
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

// Home Page Text Zoom-in and Zoom-out Effect.
var prevScrollPos = window.pageYOffset;
var element = document.querySelector(".bg-img-text-home");

if(element != null) {

    // Add the "fade" class on page load
    element.classList.add("fade");

    // Remove the "fade" class after a brief delay
    setTimeout(function() {
        element.classList.remove("fade");
    }, 500);

    window.addEventListener("scroll", function(e) {
        e.preventDefault();
        
        var currentScrollPos = window.pageYOffset;
        
        if (prevScrollPos < currentScrollPos) {
            element.classList.add("enlarge");
        } else {
            element.classList.remove("enlarge");
        }
        
        if (currentScrollPos === 0) {
            element.classList.remove("fade");
        } else {
            element.classList.add("fade");
        }
        
        prevScrollPos = currentScrollPos;
    });
}

// Login/Register popups
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

// Custom Forms

//Payments form validation elements
const cardNumber = document.querySelector('#card-number');
const expiryDate = document.querySelector('#expiry-date');
const cvv = document.querySelector('#cvv');

// Validates form inputs for payment fields.
function validateForm() {
    // Validate card number
    const regex = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
    if (!regex.test(cardNumber.value)) {
        alert('Invalid card number!');
        return false;
    }

    // Validate expiry date
    const today = new Date();
    const expiry = new Date(expiryDate.value + '-01');
    if (expiry < today) {
        alert('Card is expired!');
        return false;
    }

    // Validate CVV
    const cvvRegex = /^[0-9]{3,4}$/;
    if (!cvvRegex.test(cvv.value)) {
        alert('Invalid CVV!');
        return false;
    }   

    return true;
}

    
// Custom Form 1 JS
const customform1 = document.querySelector('#form1.customform');
const customForm1H2 = document.querySelector('#form1.customform-h2');

const btnContainerForm1 = document.querySelector('#form1.btncontainer');

// Get the form elements
const inputBoxesForm1 = document.querySelectorAll('#form1.input-box-customform');

// Add a click event listener to the header

if(customForm1H2 != null) {

    customform1.classList.add("fade");

    // Remove the "fade" class after a brief delay
    setTimeout(function() {
        customform1.classList.remove("fade");
    }, 500);

    
    customForm1H2.addEventListener('click', function(e) {

        e.preventDefault();

        if(customForm2H2 != null) {
        customForm2H2.textContent = "Click to Add a Reservation using Reservation ID";
        }

        if (customForm1H2.textContent === "Click to Reserve a Car") {
            customForm1H2.textContent = "Reserve a Car";
        } 
        
        else {
            customForm1H2.textContent = "Click to Reserve a Car";
        }
    
        // Toggle the 'expanded' class on required form elements.
        // Remove the 'expanded' class from required form elements.

        customform1.classList.toggle('expanded');
        if(customform2 != null)
        customform2.classList.remove('expanded');

        customForm1H2.classList.toggle('expanded');
        if(customForm2H2 != null)
        customForm2H2.classList.remove('expanded');
    
        btnContainerForm1.classList.toggle('expanded');
        if(btnContainerForm2 != null)
        btnContainerForm2.classList.remove('expanded');
    
        for (const inputbox of inputBoxesForm1) {
            inputbox.classList.toggle('expanded');
        }

        if(inputBoxesForm2 != null) {
            for (const inputbox of inputBoxesForm2) {
                inputbox.classList.remove('expanded');
            }
        }
        

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    
    });
}


// Custom Form 2 JS
const customform2 = document.querySelector('#form2.customform');
const customForm2H2 = document.querySelector('#form2.customform-h2');

const btnContainerForm2 = document.querySelector('#form2.btncontainer');

// Get the form elements
const inputBoxesForm2 = document.querySelectorAll('#form2.input-box-customform');

// Add a click event listener to the header

if(customForm2H2 != null) {

    customform2.classList.add("fade");

    // Remove the "fade" class after a brief delay
    setTimeout(function() {
        customform2.classList.remove("fade");
    }, 500);

    customForm2H2.addEventListener('click', function(e) {
  
        e.preventDefault();

        customForm1H2.textContent = "Click to Reserve a Car";

        if (customForm2H2.textContent === "Click to Add a Reservation using Reservation ID") {
            customForm2H2.textContent = "Add a Reservation using Reservation ID";
        } 
          
        else {
            customForm2H2.textContent = "Click to Add a Reservation using Reservation ID";
        }
    
        // Toggle the 'expanded' class on required form elements.
        // Remove the 'expanded' class from required form elements.

        customform2.classList.toggle('expanded');
        customform1.classList.remove('expanded');

        customForm2H2.classList.toggle('expanded');
        customForm1H2.classList.remove('expanded');
    
        btnContainerForm2.classList.toggle('expanded');
        btnContainerForm1.classList.remove('expanded');
    
        for (const inputbox of inputBoxesForm2) {
            inputbox.classList.toggle('expanded');
        }

        for (const inputbox of inputBoxesForm1) {
            inputbox.classList.remove('expanded');
        } 

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
      
    });
}


// Custom Form 3 JS
const customform3 = document.querySelector('#form3.customform');
const customForm3H2 = document.querySelector('#form3.customform-h2');

const btnContainerForm3 = document.querySelector('#form3.btncontainer');

// Get the form elements
const inputBoxesForm3 = document.querySelectorAll('#form3.input-box-customform');

// Add a click event listener to the header

if(customForm3H2 != null) {

    customform3.classList.add("fade");

    // Remove the "fade" class after a brief delay
    setTimeout(function() {
        customform3.classList.remove("fade");
    }, 500);

    customForm3H2.addEventListener('click', function(e) {
  
        e.preventDefault();

        customForm4H2.textContent = "Click to Delete a Reservation";

        if (customForm3H2.textContent === "Click to Update a Reservation") {
            customForm3H2.textContent = "Update a Reservation";
        } 
          
        else {
            customForm3H2.textContent = "Click to Update a Reservation";
        }
    
        // Toggle the 'expanded' class on required form elements.
        // Remove the 'expanded' class from required form elements.

        customform3.classList.toggle('expanded');
        customform4.classList.remove('expanded');

        customForm3H2.classList.toggle('expanded');
        customForm4H2.classList.remove('expanded');
    
        btnContainerForm3.classList.toggle('expanded');
        btnContainerForm4.classList.remove('expanded');
    
        for (const inputbox of inputBoxesForm3) {
            inputbox.classList.toggle('expanded');
        }

        for (const inputbox of inputBoxesForm4) {
            inputbox.classList.remove('expanded');
        }

          window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
      
    });
}


// Custom Form 4 JS
const customform4 = document.querySelector('#form4.customform');
const customForm4H2 = document.querySelector('#form4.customform-h2');

const btnContainerForm4 = document.querySelector('#form4.btncontainer');

// Get the form elements
const inputBoxesForm4 = document.querySelectorAll('#form4.input-box-customform');

// Add a click event listener to the header

if(customForm4H2 != null) {

    customform4.classList.add("fade");

    // Remove the "fade" class after a brief delay
    setTimeout(function() {
        customform4.classList.remove("fade");
    }, 500);

    customForm4H2.addEventListener('click', function(e) {
  
        e.preventDefault();

        customForm3H2.textContent = "Click to Update a Reservation";

        if (customForm4H2.textContent === "Click to Delete a Reservation") {
            customForm4H2.textContent = "Delete a Reservation";
        } 
          
        else {
            customForm4H2.textContent = "Click to Delete a Reservation";
        }
    
        // Toggle the 'expanded' class on required form elements.
        // Remove the 'expanded' class from required form elements.

        customform4.classList.toggle('expanded');
        customform3.classList.remove('expanded');

        customForm4H2.classList.toggle('expanded');
        customForm3H2.classList.remove('expanded');
    
        btnContainerForm4.classList.toggle('expanded');
        btnContainerForm3.classList.remove('expanded');
    
        for (const inputbox of inputBoxesForm4) {
            inputbox.classList.toggle('expanded');
        }

        for (const inputbox of inputBoxesForm3) {
            inputbox.classList.remove('expanded');
        }

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
      
    });
}

// Customtable JS
const wrapperCustomtable = document.querySelector('.wrapper-customtable');

if(wrapperCustomtable != null) {

    wrapperCustomtable.classList.add("fade");

    // Remove the "fade" class after a brief delay
    setTimeout(function() {
        wrapperCustomtable.classList.remove("fade");
    }, 500);

    const btnCustomtable = document.querySelectorAll('.customtable-btn');

    if(btnCustomtable != null) {
        for (const btnCt of btnCustomtable) {
            btnCt.addEventListener('click', function(e) {
                e.preventDefault();

                window.open("update_deletereservation.php", "_blank");
            });
        }
    }
}