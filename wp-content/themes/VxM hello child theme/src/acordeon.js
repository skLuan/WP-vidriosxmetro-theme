document.addEventListener("DOMContentLoaded", function () {
  const faqTouchs = document.querySelectorAll(".faq-touch");

  faqTouchs.forEach((faqTouch) => {
    const faqBrother = faqTouch.nextElementSibling;
    const arrowIcon = faqTouch.querySelector("iconify-icon");

    // Add accordion-slide class for animations
    faqBrother.classList.add('accordion-slide');

    faqTouch.addEventListener("click", function () {
      this.classList.toggle("font-bold");
      arrowIcon.classList.toggle('rotate-180');

      if (faqBrother.classList.contains('hidden')) {
        // Opening: remove hidden, then animate in
        faqBrother.classList.remove('hidden');
        // Force reflow to ensure the element is visible before animating
        faqBrother.offsetHeight;
        faqBrother.classList.add('slide-in');
        faqBrother.classList.remove('slide-out');
      } else {
        // Closing: animate out, then add hidden
        faqBrother.classList.add('slide-out');
        faqBrother.classList.remove('slide-in');
        // Wait for animation to complete before hiding
        setTimeout(() => {
          faqBrother.classList.add('hidden');
        }, 300); // Match transition duration
      }
    });
  });
});
