document.addEventListener('DOMContentLoaded', () => {
  // -----------------------------
  // DROPDOWN NAVIGATION FUNCTIONALITY
  // -----------------------------
  const dropdowns = Array.from(document.querySelectorAll('.dropdown'));
  const menu = document.querySelector('.menu');
  const hamburgerIcon = document.querySelector('.hamburger-icon');

  function closeAllDropdowns() {
    dropdowns.forEach(d => {
      const cb = d.querySelector('input[type="checkbox"]');
      if (cb) {
        cb.checked = false;
        updateArrow(cb);
      }
    });
  }

  function updateArrow(checkbox) {
    if (!checkbox) return;
    const label = checkbox.nextElementSibling;
    if (!label) return;
    const arrow = label.querySelector('.nav-arrow');
    if (!arrow) return;
    arrow.textContent = checkbox.checked ? '▲' : '▼';
  }

  dropdowns.forEach(d => {
    const cb = d.querySelector('input[type="checkbox"]');
    if (!cb) return;

    cb.addEventListener('change', () => {
      if (cb.checked) {
        dropdowns.forEach(other => {
          const otherCb = other.querySelector('input[type="checkbox"]');
          if (otherCb && otherCb !== cb) {
            otherCb.checked = false;
            updateArrow(otherCb);
          }
        });
      }
      updateArrow(cb);
    });

    updateArrow(cb);
  });

  document.addEventListener('click', (e) => {
    const clickedDropdown = e.target.closest('.dropdown');
    if (clickedDropdown) {
      const clickedCb = clickedDropdown.querySelector('input[type="checkbox"]');
      dropdowns.forEach(d => {
        const cb = d.querySelector('input[type="checkbox"]');
        if (cb && cb !== clickedCb) {
          cb.checked = false;
          updateArrow(cb);
        }
      });
      return;
    }
    closeAllDropdowns();
  });

  document.querySelectorAll('nav a').forEach(a => {
    a.addEventListener('click', () => closeAllDropdowns());
  });

  hamburgerIcon.addEventListener('click', () => {
    menu.classList.toggle('active');
    hamburgerIcon.classList.toggle('active');
    if (hamburgerIcon.classList.contains('active')) closeAllDropdowns();
  });

  // -----------------------------
  // MULTIPLE HERO SECTION GALLERIES (AUTO + MANUAL)
  // -----------------------------
  // -----------------------------
// UNIVERSAL HERO GALLERY (supports multiple carousels)
// -----------------------------
document.querySelectorAll('.hero-section').forEach((section) => {
  const mainImage = section.querySelector('.gallery-main img');
  const thumbnails = section.querySelectorAll('.gallery-thumbs img');
  const prevButton = section.querySelector('.carousel-btn.previous');
  const nextButton = section.querySelector('.carousel-btn.proceed');

  let currentIndex = 0;
  let autoSwitchInterval;

  function changeImageByIndex(index) {
    if (!thumbnails.length) return;

    // loop around
    if (index < 0) index = thumbnails.length - 1;
    else if (index >= thumbnails.length) index = 0;

    // fade out
    mainImage.classList.add('fade-out');

    setTimeout(() => {
      mainImage.src = thumbnails[index].src;

      thumbnails.forEach(img => img.classList.remove('active'));
      thumbnails[index].classList.add('active');

      // fade in
      mainImage.classList.remove('fade-out');
      mainImage.classList.add('fade-in');

      setTimeout(() => mainImage.classList.remove('fade-in'), 400);
    }, 300);

    currentIndex = index;
  }

  // manual thumbnail click
  thumbnails.forEach((thumb, index) => {
    thumb.addEventListener('click', () => {
      clearInterval(autoSwitchInterval);
      changeImageByIndex(index);
      startAutoSwitch();
    });
  });

  // auto switch
  function startAutoSwitch() {
    clearInterval(autoSwitchInterval);
    autoSwitchInterval = setInterval(() => {
      changeImageByIndex(currentIndex + 1);
    }, 4000);
  }

  // button control
  if (prevButton && nextButton) {
    prevButton.addEventListener('click', () => {
      clearInterval(autoSwitchInterval);
      changeImageByIndex(currentIndex - 1);
      startAutoSwitch();
    });

    nextButton.addEventListener('click', () => {
      clearInterval(autoSwitchInterval);
      changeImageByIndex(currentIndex + 1);
      startAutoSwitch();
    });
  }

  // initialize
  if (thumbnails.length > 0) {
    thumbnails[0].classList.add('active');
    mainImage.src = thumbnails[0].src;
    startAutoSwitch();
  }
});


  // -----------------------------
  // REVIEW CAROUSEL
  // -----------------------------
  const reviewTrack = document.querySelector('.review-carousel .carousel-track');
  const reviewSlides = reviewTrack ? Array.from(reviewTrack.children) : [];
  const reviewNext = document.querySelector('.review-carousel .carousel-btn.proceed');
  const reviewPrev = document.querySelector('.review-carousel .carousel-btn.previous');
  let reviewIndex = 0;

  function updateReviewSlide() {
    if (!reviewTrack || !reviewSlides.length) return;

    const containerWidth = reviewTrack.parentElement.offsetWidth;
    const slideStyle = window.getComputedStyle(reviewSlides[0]);
    const slideWidth = reviewSlides[0].offsetWidth + parseInt(slideStyle.marginLeft) + parseInt(slideStyle.marginRight);

    reviewSlides.forEach(slide => slide.classList.remove('center'));
    reviewSlides[reviewIndex].classList.add('center');

    let offset = slideWidth * reviewIndex - containerWidth / 2 + slideWidth / 2;
    const maxOffset = slideWidth * reviewSlides.length - containerWidth;
    if (offset < 0) offset = 0;
    if (offset > maxOffset) offset = maxOffset;

    reviewTrack.style.transform = `translateX(-${offset}px)`;
  }

  if (reviewNext && reviewPrev) {
    reviewNext.addEventListener('click', () => {
      if (reviewIndex < reviewSlides.length - 1) {
        reviewIndex++;
        updateReviewSlide();
      }
    });

    reviewPrev.addEventListener('click', () => {
      if (reviewIndex > 0) {
        reviewIndex--;
        updateReviewSlide();
      }
    });
  }

  // Mobile swipe support
  let startX = 0, endX = 0;

  if (reviewTrack) {
    reviewTrack.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
    });

    reviewTrack.addEventListener('touchmove', (e) => {
      endX = e.touches[0].clientX;
    });

    reviewTrack.addEventListener('touchend', () => {
      const threshold = 50;
      if (startX - endX > threshold && reviewIndex < reviewSlides.length - 1) {
        reviewIndex++;
        updateReviewSlide();
      } else if (endX - startX > threshold && reviewIndex > 0) {
        reviewIndex--;
        updateReviewSlide();
      }
      startX = endX = 0;
    });

    updateReviewSlide();
    window.addEventListener('resize', updateReviewSlide);
  }

  // -----------------------------
  // VIDEO PLAY ON CLICK
  // -----------------------------
  document.querySelectorAll('.video-container').forEach(container => {
    container.addEventListener('click', function () {
      const iframe = this.querySelector('iframe');
      const videoSrc = iframe.getAttribute('data-src');
      iframe.setAttribute('src', videoSrc + "?autoplay=1");
      iframe.classList.add('playing');
    });
  });

  // -----------------------------
  // POP-UP FUNCTIONALITY
  // -----------------------------
  const viewButton = document.getElementById("viewButton");
  const popup = document.getElementById("popup");
  const closeButton = document.getElementById("closeButton");

  if (viewButton && popup && closeButton) {
    viewButton.addEventListener("click", () => {
      popup.style.display = "flex";
      setTimeout(() => popup.style.opacity = 1, 10);
    });

    closeButton.addEventListener("click", () => {
      popup.style.opacity = 0;
      setTimeout(() => popup.style.display = "none", 300);
    });
  }
});






document.addEventListener('DOMContentLoaded', () => {
  // 🔹 Define all modals
  const modals = {
    requirements: document.getElementById('requirementsModal'),
    documents: document.getElementById('documentsModal'),
    lgu: document.getElementById('lguModal'),
    merchant: document.getElementById('merchantModal')
  };

  // 🔹 Define open buttons
  const openButtons = {
    requirements: document.getElementById('openRequirementsModal'),
    documents: document.getElementById('openDocumentsModal'),
    lgu: document.getElementById('openLGUModal'),
    merchant: document.getElementById('openMerchantModal')
  };

  // 🔹 Open modals
  if (openButtons.requirements)
    openButtons.requirements.addEventListener('click', () => modals.requirements.style.display = 'flex');
  
  if (openButtons.documents)
    openButtons.documents.addEventListener('click', () => modals.documents.style.display = 'flex');
  
if (openButtons.lgu)
  openButtons.lgu.addEventListener('click', () => modals.lgu.style.display = 'flex');

if (openButtons.merchant)
  openButtons.merchant.addEventListener('click', () => modals.merchant.style.display = 'flex');


  // 🔹 Close buttons (for both modal types)
  const closeButtons = document.querySelectorAll('.close-btn, .close-modal');

  closeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Find the closest parent modal container and hide it
      const modal = btn.closest('.modal, .merchant-modal');
      if (modal) modal.style.display = 'none';
    });
  });

  // 🔹 Close when clicking outside any modal
  window.addEventListener('click', (e) => {
    Object.values(modals).forEach(modal => {
      if (e.target === modal) modal.style.display = 'none';
    });
  });
});








function changeColor(color) {
  const productImage = document.getElementById('product-image');
  productImage.src = `images/pickapp-${color}.png`;
  productImage.alt = `PICKAPP Hi-GO ${color.charAt(0).toUpperCase() + color.slice(1)}`;

  // Optional: subtle zoom animation
  productImage.style.transform = 'scale(1.05)';
  setTimeout(() => {
    productImage.style.transform = 'scale(1)';
  }, 200);
}



