document.addEventListener('DOMContentLoaded', function() {
    const data = {
        restaurants: 4,
        dishes: 16,
        users: 1,
        totalOrders: 3,
        processingOrders: 0,
        deliveredOrders: 0,
        cancelledOrders: 0,
        restroCategories: 4,
        totalEarnings: 0
    };

    const dashboard = document.getElementById('dashboard');
    const keys = Object.keys(data);
    const labels = {
        restaurants: 'Restaurants',
        dishes: 'Dishes',
        users: 'Users',
        totalOrders: 'Total Orders',
        processingOrders: 'Processing Orders',
        deliveredOrders: 'Delivered Orders',
        cancelledOrders: 'Cancelled Orders',
        restroCategories: 'Restro Categories',
        totalEarnings: 'Total Earnings'
    };

    keys.forEach(key => {
        const card = document.createElement('div');
        card.classList.add('col-md-3');
        card.innerHTML = `
            <div class="dashboard-card">
                <div>
                    <h2>${data[key]}</h2>
                    <p>${labels[key]}</p>
                </div>
            </div>
        `;
        dashboard.appendChild(card);
    });
});
