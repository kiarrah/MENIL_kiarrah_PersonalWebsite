$('.carousel').owlCarousel({
    items:1,
    margin:10,
    autoHeight:true,
    nav: false,
    lazyLoad:true,
    loop:true,
    dots: false
});


let modal = $('.modal');
let btn = $('[data-toggle="modal"] + .modal');
let span = $('.modal > .close');

btn.on('click', function() {

});

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
} 