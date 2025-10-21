document.addEventListener("DOMContentLoaded", function () {
  const faqTouchs = document.querySelectorAll(".faq-touch");

  faqTouchs.forEach((faqTouch) => {
    const faqBrother = faqTouch.nextElementSibling;
    const arrowIcon = faqTouch.querySelector("iconify-icon");

    faqTouch.addEventListener("click", function () {
      this.classList.toggle("font-bold");
      faqBrother.classList.toggle('hidden');
      arrowIcon.classList.toggle('rotate-180');
    });
  });
});
