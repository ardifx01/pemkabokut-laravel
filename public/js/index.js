document.addEventListener('DOMContentLoaded', function() {
    var submenuToggles = document.querySelectorAll('.submenu-toggle');

    submenuToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default (jika link)

            var iconId = this.getAttribute('data-icon-id');
            var selectedSubmenu = document.getElementById('iconMenu' + iconId);
            var iconRect = this.getBoundingClientRect(); // Dapatkan posisi ikon yang diklik
            var submenuRect = selectedSubmenu
                .getBoundingClientRect(); // Dapatkan posisi submenu

            // Hitung posisi segitiga agar sejajar dengan ikon yang diklik
            var trianglePosition = (iconRect.left + iconRect.width / 2) - submenuRect.left -
                10;

            // Pindahkan segitiga (::before) agar sejajar dengan ikon
            selectedSubmenu.style.setProperty('--triangle-position',
                `${trianglePosition}px`);

            // Tutup submenu lain jika terbuka
            document.querySelectorAll('.submenu-collapse').forEach(function(submenu) {
                if (submenu !== selectedSubmenu && submenu.classList.contains(
                        'show')) {
                    submenu.classList.remove('show');
                }
            });

            // Tampilkan submenu yang diklik
            selectedSubmenu.classList.toggle('show');
        });
    });
});

$(document).ready(function() {
    // Initialize Owl Carousel
    var owl = $('#latestArticle').owlCarousel({
        loop: true,
        margin: 10,
        nav: false, // Disable default nav
        autoplay: true, // Enable autoplay
        autoplayTimeout: 3000, // Set autoplay speed (in milliseconds)
        autoplayHoverPause: true, // Pause on hover
        responsive: {
            0: {
                items: 1 // Display 1 item at a time
            },
            600: {
                items: 1 // Display 1 item at a time
            },
            1000: {
                items: 1 // Display 1 item at a time
            }
        }
    });

    // Custom Navigation Events
    $('.owl-next').click(function() {
        owl.trigger('next.owl.carousel');
    });
    $('.owl-prev').click(function() {
        owl.trigger('prev.owl.carousel');
    });
});