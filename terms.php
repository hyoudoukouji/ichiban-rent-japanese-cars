<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .terms-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem;
        }

        .terms-section {
            margin-bottom: 2rem;
        }

        .terms-section h2 {
            color: #1a1a1a;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .terms-section p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .terms-section ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            color: #666;
            line-height: 1.6;
        }

        .terms-section li {
            margin-bottom: 0.5rem;
        }

        .contact-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .contact-info h3 {
            color: #1a1a1a;
            margin-bottom: 1rem;
        }

        .contact-info p {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .contact-info a {
            color: #1a1a1a;
            text-decoration: none;
            font-weight: 500;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Include Navigation -->
        <?php require_once 'components/navigation.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="header-content">
                    <h1>Terms & Conditions</h1>
                    <p>Please read our terms and conditions carefully.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="terms-content">
                <div class="terms-section">
                    <h2>1. Rental Agreement</h2>
                    <p>By renting a vehicle from Ichiban Rent, you agree to the following terms and conditions. This agreement is between you (the "Renter") and Ichiban Rent (the "Company").</p>
                </div>

                <div class="terms-section">
                    <h2>2. Eligibility Requirements</h2>
                    <ul>
                        <li>Must be at least 21 years of age</li>
                        <li>Must possess a valid driver's license</li>
                        <li>Must have a clean driving record</li>
                        <li>Must provide valid credit card for payment and security deposit</li>
                    </ul>
                </div>

                <div class="terms-section">
                    <h2>3. Vehicle Usage</h2>
                    <ul>
                        <li>Vehicles must be used only for their intended purpose</li>
                        <li>No racing or competitive driving</li>
                        <li>No smoking in vehicles</li>
                        <li>No pets without proper protection and cleaning</li>
                        <li>Vehicle must remain within agreed geographical boundaries</li>
                    </ul>
                </div>

                <div class="terms-section">
                    <h2>4. Insurance & Liability</h2>
                    <p>All rentals include basic insurance coverage. Additional coverage options are available. The renter is responsible for any damage not covered by insurance.</p>
                </div>

                <div class="terms-section">
                    <h2>5. Fees & Payments</h2>
                    <ul>
                        <li>Full payment required at time of rental</li>
                        <li>Security deposit required</li>
                        <li>Additional fees may apply for late returns</li>
                        <li>Fuel must be replaced to original level</li>
                    </ul>
                </div>

                <div class="terms-section">
                    <h2>6. Cancellation Policy</h2>
                    <p>Cancellations must be made at least 24 hours before scheduled pickup time for a full refund. Late cancellations may result in partial charges.</p>
                </div>

                <div class="contact-info">
                    <h3>Questions or Concerns?</h3>
                    <p>Contact our customer service team:</p>
                    <p>Email: <a href="mailto:support@ichibanrent.com">support@ichibanrent.com</a></p>
                    <p>Phone: <a href="tel:+1234567890">+123 456 7890</a></p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
