// Main JavaScript for the bookmarklet platform

document.addEventListener('DOMContentLoaded', function() {
    // Initialize rating system
    initRatingSystem();
    
    // Initialize mobile menu toggle
    initMobileMenu();
    
    // Initialize search functionality
    initSearch();
});

// Initialize rating system
function initRatingSystem() {
    const ratingForms = document.querySelectorAll('.rating-form');
    
    ratingForms.forEach(form => {
        const bookmarkletId = form.dataset.id;
        const starOptions = form.querySelectorAll('.star-option');
        
        starOptions.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                
                // Send rating to server
                fetch('index.php?page=rate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${bookmarkletId}&rating=${rating}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the rating display
                        updateRatingDisplay(bookmarkletId, data.new_rating);
                        alert('Thank you for rating!');
                    } else {
                        alert('You have already rated this bookmarklet.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error submitting your rating.');
                });
            });
            
            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
                // Highlight stars up to current rating
                starOptions.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
        
        // Reset stars on mouseout
        form.addEventListener('mouseout', function() {
            starOptions.forEach(s => s.classList.remove('active'));
        });
    });
}

// Update rating display after rating
function updateRatingDisplay(bookmarkletId, newRating) {
    const ratingElements = document.querySelectorAll(`.rating-stars[data-id="${bookmarkletId}"]`);
    ratingElements.forEach(el => {
        // Update the stars based on new rating
        const fullStars = Math.floor(newRating);
        const halfStar = (newRating - fullStars) >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
        
        let html = '';
        for (let i = 0; i < fullStars; i++) {
            html += '<span class="star full">★</span>';
        }
        if (halfStar) {
            html += '<span class="star half">★</span>';
        }
        for (let i = 0; i < emptyStars; i++) {
            html += '<span class="star empty">★</span>';
        }
        html += ' <span class="rating-value">' + newRating.toFixed(1) + '</span>';
        
        el.innerHTML = html;
    });
}

// Initialize mobile menu toggle
function initMobileMenu() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
}

// Initialize search functionality
function initSearch() {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const query = document.querySelector('.search-input').value;
            const category = document.querySelector('.filter-category') ? document.querySelector('.filter-category').value : '';
            const sort = document.querySelector('.filter-sort') ? document.querySelector('.filter-sort').value : 'popular';
            
            // Build query string
            let queryString = `page=search`;
            if (query) queryString += `&q=${encodeURIComponent(query)}`;
            if (category) queryString += `&category=${encodeURIComponent(category)}`;
            if (sort) queryString += `&sort=${encodeURIComponent(sort)}`;
            
            window.location.href = `?${queryString}`;
        });
    }
}

// Copy to clipboard function for bookmarklet installation
function copyBookmarklet(code) {
    navigator.clipboard.writeText(code).then(function() {
        alert('Bookmarklet code copied to clipboard! Drag the link to your bookmarks bar to install.');
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
        alert('Failed to copy bookmarklet code. Please try again.');
    });
}

// Handle installation button clicks
function handleInstallClick(e) {
    e.preventDefault();
    const code = e.target.dataset.code;
    if (code) {
        copyBookmarklet(code);
    }
}