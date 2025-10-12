<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coplender - Your Trusted Loan Partner</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #AB54DB;
            --primary-dark: #8B3CB8;
            --primary-light: #C47EED;
            --dark: #1a1a2e;
            --dark-light: #2a2a3e;
            --text: #333;
            --text-light: #666;
            --gray: #f8f9fa;
            --white: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo::before {
            content: "◆";
            font-size: 1.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn {
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(171, 84, 219, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(171, 84, 219, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
            padding-top: 80px; /* offset for fixed header */
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(171, 84, 219, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

      .hero-content {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-text h1 span {
            color: var(--primary);
        }

        .hero-text p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
        }

        .hero-image img {
            width: 100%;
            max-width: 500px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Sections */
        section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        section.full-width {
            max-width: 100%;
            padding: 0;
        }

        section.full-width > div:not(.section-header):not(.testimonials-grid) {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        /* About Section */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text h3 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .about-text p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .about-features {
            display: grid;
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: var(--primary);
            color: white;
            transform: translateX(10px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .feature-item:hover .feature-icon {
            background: white;
        }

        /* Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(171, 84, 219, 0.2);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .service-card p {
            color: var(--text-light);
            line-height: 1.6;
        }

        /* Why Choose Us */
        .why-choose {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 30px;
            padding: 5rem 3rem;
            margin: 5rem 2rem;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .why-item {
            text-align: center;
        }

        .why-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        .why-item h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .why-item p {
            opacity: 0.9;
        }

        /* Interest Rates */
        .rates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .rate-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .rate-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .rate-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
        }

        .rate-card.featured {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            transform: scale(1.05);
        }

        .rate-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .rate-card h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .rate-percentage {
            font-size: 3rem;
            font-weight: 800;
            margin: 1rem 0;
        }

        .rate-percentage small {
            font-size: 1.2rem;
            opacity: 0.8;
        }

        .rate-features {
            list-style: none;
            margin-top: 1.5rem;
        }

        .rate-features li {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .rate-card.featured .rate-features li {
            border-bottom-color: rgba(255, 255, 255, 0.2);
        }

        /* Testimonials */
        .testimonials {
            background: var(--gray);
            padding: 0;
            max-width: 100%;
        }

        .testimonials .section-header {
            padding: 5rem 2rem 2rem;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem 5rem;
        }

        .testimonial-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .testimonial-quote {
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.3;
            position: absolute;
            top: 1rem;
            left: 1.5rem;
        }

        .testimonial-text {
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .author-info h4 {
            color: var(--dark);
            margin-bottom: 0.2rem;
        }

        .author-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .stars {
            color: #ffc107;
            margin-top: 0.5rem;
        }

        /* Contact Form */
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        .contact-info h3 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .contact-info p {
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .contact-details {
            display: grid;
            gap: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray);
            border-radius: 10px;
        }

        .contact-item-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        .contact-form {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Footer */
        footer {
            background: #000000;
            color: white;
            padding: 3rem 2rem 1.5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-about h3 {
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .footer-about p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-links h4 {
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 0.8rem;
        }

        .footer-links ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links ul li a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }

            .hero-content,
            .about-content,
            .contact-content {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .why-choose {
                padding: 3rem 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <a href="#" class="logo">Coplender</a>
            <ul class="nav-links">
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#rates">Rates</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#login" class="btn btn-primary">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Get Your <span>Dream Loan</span> in Minutes</h1>
                <p>Fast, secure, and hassle-free lending solutions tailored to your needs. Experience the future of lending with competitive rates and instant approvals.</p>
                <div class="hero-buttons">
                    <a href="#contact" class="btn btn-primary">Apply Now</a>
                    <a href="#about" class="btn btn-outline">Learn More</a>
                </div>
            </div>
            <div class="hero-image">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#AB54DB;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#C47EED;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <circle cx="250" cy="250" r="200" fill="url(#grad1)" opacity="0.2"/>
                    <circle cx="250" cy="250" r="150" fill="url(#grad1)" opacity="0.3"/>
                    <rect x="150" y="150" width="200" height="250" rx="20" fill="white" stroke="url(#grad1)" stroke-width="3"/>
                    <rect x="180" y="180" width="140" height="8" rx="4" fill="url(#grad1)"/>
                    <rect x="180" y="210" width="100" height="8" rx="4" fill="#e0e0e0"/>
                    <rect x="180" y="240" width="120" height="8" rx="4" fill="#e0e0e0"/>
                    <circle cx="250" cy="320" r="40" fill="url(#grad1)"/>
                    <path d="M 235 320 L 245 330 L 265 310" stroke="white" stroke-width="4" fill="none" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="section-header">
            <h2>About Coplender</h2>
            <p>Empowering financial freedom through innovative lending solutions</p>
        </div>
        <div class="about-content">
            <div class="about-text">
                <h3>Your Trusted Financial Partner</h3>
                <p>At Coplender, we believe that everyone deserves access to fair and transparent financial services. With years of experience in the lending industry, we've helped thousands of customers achieve their dreams through our flexible loan products.</p>
                <p>Our mission is to simplify the borrowing process, making it quick, secure, and accessible to all. We leverage cutting-edge technology to provide instant loan approvals while maintaining the highest standards of customer service.</p>
            </div>
            <div class="about-features">
                <div class="feature-item">
                    <div class="feature-icon">🚀</div>
                    <div>
                        <h4>Quick Approval</h4>
                        <p>Get approved in minutes, not days</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <div>
                        <h4>Secure & Safe</h4>
                        <p>Bank-level encryption for your data</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💰</div>
                    <div>
                        <h4>Competitive Rates</h4>
                        <p>Best rates in the market guaranteed</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🎯</div>
                    <div>
                        <h4>Flexible Terms</h4>
                        <p>Customized repayment plans for you</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services">
        <div class="section-header">
            <h2>Our Services</h2>
            <p>Comprehensive lending solutions for every need</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🏠</div>
                <h3>Home Loans</h3>
                <p>Make your dream home a reality with our flexible home loan options featuring low interest rates and extended repayment periods.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🚗</div>
                <h3>Auto Loans</h3>
                <p>Drive your dream car today with our hassle-free auto financing solutions and competitive interest rates.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">💼</div>
                <h3>Business Loans</h3>
                <p>Fuel your business growth with our tailored business loan packages designed for entrepreneurs and SMEs.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🎓</div>
                <h3>Education Loans</h3>
                <p>Invest in your future with our education loans that cover tuition, books, and living expenses with flexible repayment.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">💳</div>
                <h3>Personal Loans</h3>
                <p>Quick personal loans for any purpose - weddings, medical emergencies, travel, or debt consolidation.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">⚡</div>
                <h3>Instant Cash</h3>
                <p>Need money urgently? Get instant cash loans approved within minutes with minimal documentation required.</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <div class="why-choose">
        <div class="section-header">
            <h2 style="color: white;">Why Choose Coplender?</h2>
            <p style="color: rgba(255,255,255,0.9);">Experience the difference with our exceptional service</p>
        </div>
        <div class="why-grid">
            <div class="why-item">
                <div class="why-number">15K+</div>
                <h3>Happy Customers</h3>
                <p>Trusted by thousands of satisfied borrowers</p>
            </div>
            <div class="why-item">
                <div class="why-number">$500M+</div>
                <h3>Loans Disbursed</h3>
                <p>Helping dreams come true every day</p>
            </div>
            <div class="why-item">
                <div class="why-number">98%</div>
                <h3>Approval Rate</h3>
                <p>One of the highest in the industry</p>
            </div>
            <div class="why-item">
                <div class="why-number">24/7</div>
                <h3>Customer Support</h3>
                <p>Always here when you need us</p>
            </div>
        </div>
    </div>

    <!-- Interest Rates -->
    <section id="rates">
        <div class="section-header">
            <h2>Interest Rates</h2>
            <p>Transparent pricing with no hidden charges</p>
        </div>
        <div class="rates-grid">
            <div class="rate-card">
                <span class="rate-badge">Personal</span>
                <h3>Personal Loans</h3>
                <div class="rate-percentage">8.9% <small>per annum</small></div>
                <ul class="rate-features">
                    <li>✓ Up to $50,000</li>
                    <li>✓ 1-5 years tenure</li>
                    <li>✓ Minimal documentation</li>
                    <li>✓ Quick approval</li>
                </ul>
            </div>
            <div class="rate-card featured">
                <span class="rate-badge">⭐ Most Popular</span>
                <h3>Home Loans</h3>
                <div class="rate-percentage">6.5% <small>per annum</small></div>
                <ul class="rate-features">
                    <li>✓ Up to $500,000</li>
                    <li>✓ Up to 30 years tenure</li>
                    <li>✓ Low EMI options</li>
                    <li>✓ Tax benefits available</li>
                </ul>
            </div>
            <div class="rate-card">
                <span class="rate-badge">Business</span>
                <h3>Business Loans</h3>
                <div class="rate-percentage">7.5% <small>per annum</small></div>
                <ul class="rate-features">
                    <li>✓ Up to $1,000,000</li>
                    <li>✓ Flexible tenure</li>
                    <li>✓ Business expansion support</li>
                    <li>✓ Dedicated relationship manager</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="testimonials full-width">
        <div class="section-header">
            <h2>What Our Clients Say</h2>
            <p>Don't just take our word for it</p>
        </div>


        <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-about">
                <h3>Coplender</h3>
                <p>Your trusted partner in achieving financial goals. Experience fast, secure, and transparent lending services designed just for you.</p>
                <div class="social-links">
                    <a href="#">🌐</a>
                    <a href="#">🐦</a>
                    <a href="#">📘</a>
                    <a href="#">📸</a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Company</h4>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Our Services</a></li>
                    <li><a href="#rates">Rates</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Contact</h4>
                <ul>
                    <li><a href="#">+1 (555) 123-4567</a></li>
                    <li><a href="#">support@coplender.com</a></li>
                    <li><a href="#">123 FinTech Street, New York, USA</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 Coplender. All rights reserved.</p>
        </div>
    </footer>
