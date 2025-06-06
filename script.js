// Sample data for top rent cars
const topRentCars = [
    {
        name: 'Honda Civic Sir-II',
        price: 'Rp 3.020.000',
        reviews: '2200 Reviews',
        rents: '150 Rent',
        image: 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EHonda Civic%3C/text%3E%3C/svg%3E'
    },
    {
        name: 'Toyota 86 GT',
        price: 'Rp 3.599.000',
        reviews: '7002 Reviews',
        rents: '400 orders',
        image: 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EToyota 86%3C/text%3E%3C/svg%3E'
    },
    {
        name: 'Toyota GR86 RZ',
        price: 'Rp 5.090.000',
        reviews: '6090 Reviews',
        rents: '250 orders',
        image: 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EToyota GR86%3C/text%3E%3C/svg%3E'
    }
];

// Initialize the application when DOM is loaded
let isInitialized = false;

document.addEventListener('DOMContentLoaded', () => {
    // Prevent multiple initializations
    if (isInitialized) return;
    isInitialized = true;

    try {
        initializeTopRentSection();
        initializeColorSelection();
        initializeDurationControls();
        initializeFavoriteButton();
        initializeSearch();
        initializeNavigation();
    } catch (error) {
        console.error('Initialization error:', error);
    }
});

// Populate top rent section
function initializeTopRentSection() {
    const topRentList = document.querySelector('.top-rent-list');
    
    topRentCars.forEach(car => {
        const carElement = document.createElement('div');
        carElement.className = 'top-rent-item';
        carElement.innerHTML = `
            <div style="display: flex; align-items: center; gap: 1rem; background-color: #f8f9fa; padding: 1.5rem; border-radius: 12px; transition: all 0.3s ease;">
                <img src="${car.image}" alt="${car.name}" style="width: 100px; height: 80px; object-fit: contain; border-radius: 8px;" onerror="this.src='https://via.placeholder.com/100x80'">
                <div style="flex: 1;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem; font-weight: 600;">${car.name}</h3>
                    <div style="color: #666; font-size: 0.9rem;">${car.reviews} • ${car.rents}</div>
                    <div style="font-weight: 600; margin-top: 0.5rem; color: #1a1a1a;">${car.price}</div>
                </div>
            </div>
        `;
        topRentList.appendChild(carElement);

        // Add hover effect
        const carCard = carElement.querySelector('div');
        carCard.addEventListener('mouseenter', () => {
            carCard.style.transform = 'translateY(-5px)';
            carCard.style.boxShadow = '0 10px 20px rgba(0,0,0,0.05)';
        });
        carCard.addEventListener('mouseleave', () => {
            carCard.style.transform = 'translateY(0)';
            carCard.style.boxShadow = 'none';
        });
    });
}

// Color selection functionality
function initializeColorSelection() {
    const colorButtons = document.querySelectorAll('.color-btn');
    colorButtons.forEach(button => {
        button.addEventListener('click', () => {
            colorButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        });
    });
}

// Duration controls
function initializeDurationControls() {
    const minusBtn = document.querySelector('.minus');
    const plusBtn = document.querySelector('.plus');
    const durationSpan = document.querySelector('.duration span');
    let duration = 1;

    function updateDuration() {
        durationSpan.textContent = `${duration} Day${duration > 1 ? 's' : ''}`;
    }

    minusBtn.addEventListener('click', () => {
        if (duration > 1) {
            duration--;
            updateDuration();
        }
    });

    plusBtn.addEventListener('click', () => {
        duration++;
        updateDuration();
    });
}

// Favorite button functionality
function initializeFavoriteButton() {
    const favoriteBtn = document.querySelector('.favorite-btn');
    favoriteBtn.addEventListener('click', () => {
        const icon = favoriteBtn.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        
        // Add animation
        favoriteBtn.style.transform = 'scale(1.1)';
        setTimeout(() => {
            favoriteBtn.style.transform = 'scale(1)';
        }, 200);
    });
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('.search-bar input');
    const filterBtn = document.querySelector('.filter-btn');

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        // Add search logic here
        console.log('Searching for:', searchTerm);
    });

    filterBtn.addEventListener('click', () => {
        // Add filter logic here
        console.log('Filter clicked');
    });
}

// Navigation functionality
function initializeNavigation() {
    const navItems = document.querySelectorAll('nav ul li');
    
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            navItems.forEach(navItem => navItem.classList.remove('active'));
            item.classList.add('active');
        });
    });
}

// Add smooth scrolling
document.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 0) {
        header.style.boxShadow = '0 4px 12px rgba(0,0,0,0.05)';
    } else {
        header.style.boxShadow = 'none';
    }
});

// Add loading animation for car images with error handling
document.querySelectorAll('img').forEach(img => {
    // Set default opacity
    img.style.opacity = '0';
    img.style.transition = 'opacity 0.3s ease';

    // Handle successful load
    img.addEventListener('load', () => {
        img.style.opacity = '1';
    });

    // Handle load errors
    img.addEventListener('error', (e) => {
        console.error('Image load failed:', e.target.src);
        img.style.opacity = '1';
    });
});

// Initialize rent button
const rentBtn = document.querySelector('.rent-btn');
rentBtn.addEventListener('click', () => {
    // Add rent logic here
    console.log('Rent button clicked');
    rentBtn.style.transform = 'scale(0.95)';
    setTimeout(() => {
        rentBtn.style.transform = 'scale(1)';
    }, 200);
});
