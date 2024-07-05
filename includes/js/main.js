// Go to top button
let span = document.querySelector(".up");

window.onscroll = function () {
    this.scrollY >= 100 ? span.classList.add("show") : span.classList.remove("show");
};

span.onclick = function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

// Loading spinner
let spinnerWrapper = document.querySelector('.spinner-wrapper');

window.addEventListener('load', () => {
    setTimeout(() => {
        spinnerWrapper.remove();
        document.body.style.overflow = 'auto';
    }, 1000); // تأخير لمدة 2 ثانية (2000 مللي ثانية)
});
