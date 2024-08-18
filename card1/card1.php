<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoFood Page</title>
    <link rel="stylesheet" href="card1.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="gofood_logo.png" alt="GoFood Logo">
        </div>
        <div class="location">
            <span>Menteng</span>
        </div>
        <div class="auth">
            <button>Log in/Sign up</button>
        </div>
    </header>
    <main>
        <section class="breadcrumb">
            <a href="#">Home</a> / <a href="#">Jakarta</a> / <a href="#">Bubur Ayam Pon Djaya, CFD Hotel Pullman</a>
        </section>

        <section class="restaurant-info">
            <img src="restaurant_image.jpg" alt="Restaurant Image">
            <div class="restaurant-details">
                <h1>Bubur Ayam Pon Djaya, CFD Hotel Pullman</h1>
                <div class="super-partner">Super Partner</div>
                <div class="status">Closed • Opens at 06:00 Sunday</div>
                <div class="info">
                    <span class="new">New</span>
                    <span class="price">$$$</span>
                    <span class="price-range">16k-40k</span>
                </div>
            </div>
        </section>
        
        <!-- Info Container -->
        <section class="info-container">
            <div class="info-item">
                <span class="icon">
                    <img src="../card1/img/star.png" alt="star"></span>
                    <span class="label">New</span>
                <a href="#" class="link">See reviews</a>
            </div>
            <div class="info-item">
                <span class="icon">
                    <img src="../card1/img/calories.png" alt="cal"></span>
                    <span class="label">0.02 km</span>
                <span class="link">Distance</span>
            </div>
            <div class="info-item">
                <span class="icon">
                    <img src="../card1/img/dollar.png" alt="dollar"></span>
                <span class="price-range">16k-40k</span>
            </div>
        </section>

        <!-- Promo Container -->
        <section class="promo-container">
            <div class="promos">
                <span>3 promos are available</span>
                <ul>
                    <li>40% off food up to 80k</li>
                    <li>35% off food up to 35k</li>
                </ul>
            </div>
        </section>
        
        <section class="menu">
            <h2>Makanan Berat</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <img src="item_image.jpg" alt="Item Image">
                    <div class="item-details">
                        <h3>Bubur Ayam Negri Free 1 Sate</h3>
                        <p>Bubur dengan toping ayam negri, cakwe kering dan basah, bawang...</p>
                        <span class="price">25.000</span>
                    </div>
                </div>
                <div class="menu-item">
                    <img src="item_image.jpg" alt="Item Image">
                    <div class="item-details">
                        <h3>Bubur Ayam Kampung Free 1 Sate</h3>
                        <p>Bubur dengan toping ayam kampung, cakwe kering dan...</p>
                        <span class="price">30.000</span>
                    </div>
                </div>
                <div class="menu-item">
                    <img src="item_image.jpg" alt="Item Image">
                    <div class="item-details">
                        <h3>Bubur Sapi Special Free 1 Sate</h3>
                        <p>Bubur dengan toping daging sapi special yang lezatt, cakwe kering...</p>
                        <span class="price">30.000</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
