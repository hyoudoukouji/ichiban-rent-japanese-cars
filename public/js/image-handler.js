function handleImageError(img) {
    // Set a fallback image if loading fails
    img.onerror = null; // Prevent infinite loop
    img.src = 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'14\' fill=\'%23666\' text-anchor=\'middle\'%3EImage not available%3C/text%3E%3C/svg%3E';
}

function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.onerror = () => handleImageError(img);
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeLazyLoading);
