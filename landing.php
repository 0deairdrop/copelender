<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Coplender - Your Trusted Loan Partner</title>

  <!-- ✅ Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>

  <!-- ✅ Font Awesome (for social media icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

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
            --dark: #0a0e27;
            --dark-light: #1a1e3e;
            --text: #2c3e50;
            --text-light: #6c757d;
            --gray: #f8f9fa;
            --white: #ffffff;
            --gradient: linear-gradient(135deg, #AB54DB 0%, #C47EED 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        }

        nav {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 2rem;
        }

        .logo {
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo img {
            display: block;
            max-height: 50px;
            width: auto;
            max-width: 180px;
        }

        .nav-menu {
            display: flex;
            gap: 2.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-menu a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 20px rgba(171, 84, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(171, 84, 219, 0.5);
        }

        .btn-white {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
        }

        /* Hero Section */
        .hero {
            margin-top: 90px;
            min-height: 90vh;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 1000px;
            height: 1000px;
            background: radial-gradient(circle, rgba(171, 84, 219, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(196, 126, 237, 0.06) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3.8rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-content h1 span {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.15rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1.2rem;
            flex-wrap: wrap;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(171, 84, 219, 0.2);
        }

        .stat-item h3 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }

        .stat-item p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .hero-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-visual {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .floating-card {
            position: absolute;
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            animation: float 3s ease-in-out infinite;
        }

        .card-1 {
            top: 10%;
            left: -10%;
            animation-delay: 0s;
        }

        .card-2 {
            top: 50%;
            right: -15%;
            animation-delay: 1s;
        }

        .card-3 {
            bottom: 15%;
            left: 5%;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        .main-card {
            width: 100%;
            height: 400px;
            background: var(--gradient);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(171, 84, 219, 0.3);
            position: relative;
            overflow: hidden;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        /* Section Styles */
        section {
            padding: 6rem 2rem;
        }

        .container {
            max-width: 1320px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-tag {
            display: inline-block;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .section-header h2 {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 650px;
            margin: 0 auto;
        }

       /* About Section */
.about {
  background: white;
}

.about-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  align-items: center;
}

/* 🟣 Left image column */
.about-image {
  position: relative;
}

.about-image svg {
  width: 100%;
  height: auto;
  border-radius: 20px;
  display: block;
}

/* 🟣 Floating “10+ Years Experience” badge */
.about-badge {
  position: absolute;
  bottom: 30px;
  right: -20px;
  background: white;
  padding: 2rem 1.5rem;
  border-radius: 20px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  text-align: center;
  z-index: 2;
}

.about-badge h3 {
  font-size: 2.5rem;
  color: var(--primary);
  font-weight: 800;
  margin: 0;
}

.about-badge p {
  color: var(--text-light);
  font-size: 0.9rem;
  margin: 0;
}

/* 🟣 Right text column */
.about-text h3 {
  font-size: 2.2rem;
  color: var(--dark);
  margin-bottom: 1.5rem;
  font-weight: 700;
}

.about-text p {
  color: var(--text-light);
  margin-bottom: 1.5rem;
  line-height: 1.8;
}

.about-features {
  display: grid;
  gap: 1.5rem;
  margin-top: 2rem;
}

.feature-item {
  display: flex;
  gap: 1.2rem;
  align-items: start;
}

.feature-icon {
  width: 55px;
  height: 55px;
  background: linear-gradient(135deg, rgba(171, 84, 219, 0.1), rgba(196, 126, 237, 0.1));
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.feature-item h4 {
  color: var(--dark);
  margin-bottom: 0.3rem;
  font-weight: 600;
}

.feature-item p {
  color: var(--text-light);
  font-size: 0.95rem;
}


        /* Services Section */
        .services {
            background: var(--gray);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(171, 84, 219, 0.15);
        }

        .service-icon {
            width: 75px;
            height: 75px;
            background: var(--gradient);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .service-card p {
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .service-card a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .service-card a:hover {
            gap: 0.8rem;
        }

        /* Process Section */
        .process {
            background: white;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            position: relative;
        }

        .process-step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            position: relative;
            z-index: 2;
        }

        .process-step:not(:last-child)::after {
            content: '→';
            position: absolute;
            top: 40px;
            right: -50%;
            font-size: 2rem;
            color: var(--primary);
            opacity: 0.3;
        }

        .process-step h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.8rem;
            font-weight: 600;
        }

        .process-step p {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Why Choose Us */
        .why-choose {
            background: var(--dark);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .why-choose::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="1" fill="rgba(171,84,219,0.1)"/></svg>');
            opacity: 0.5;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            position: relative;
            z-index: 1;
        }

        .why-item {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .why-item:hover {
            background: rgba(171, 84, 219, 0.2);
            transform: translateY(-5px);
        }

        .why-number {
            font-size: 3rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .why-item h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .why-item p {
            opacity: 0.8;
            font-size: 0.95rem;
        }

        /* Loan Calculator */
        .rates {
            background: var(--gray);
        }

        .calculator-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .calculator-card {
            background: white;
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .calculator-inputs .form-group {
            margin-bottom: 2rem;
        }

        .calculator-inputs input[type="number"] {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .calculator-inputs input[type="range"] {
            width: 100%;
            height: 6px;
            border-radius: 5px;
            background: #e9ecef;
            outline: none;
            -webkit-appearance: none;
        }

        .calculator-inputs input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--gradient);
            cursor: pointer;
        }

        .calculator-inputs input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--gradient);
            cursor: pointer;
            border: none;
        }

        .calculator-inputs select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .calculator-results {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 20px;
            padding: 2.5rem;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .calculator-results h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .result-amount {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
        }

        .result-details {
            display: grid;
            gap: 1.5rem;
            flex-grow: 1;
        }

        .result-item {
            padding: 1.2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-item span {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .result-item strong {
            font-size: 1.3rem;
            font-weight: 700;
        }



        /* Testimonials */
        .testimonials {
            background: white;
        }

        .testimonials-slider {
            position: relative;
            overflow: hidden;
        }

        .testimonials-track {
            display: flex;
            gap: 2rem;
            transition: transform 0.5s ease;
        }

        .testimonial-card {
            min-width: calc(33.333% - 1.5rem);
            background: var(--gray);
            padding: 2.5rem;
            border-radius: 20px;
            position: relative;
        }

        .quote-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .testimonial-text {
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 2rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .author-info h4 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .author-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .stars {
            color: #ffc107;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        /* FAQ Section */
        .faq-section {
          background: white;
          padding: 6rem 2rem;
        }

        .faq-container {
          max-width: 900px;
          margin: 0 auto;
        }

        .faq-item {
          background: var(--gray);
          border-radius: 15px;
          margin-bottom: 1.5rem;
          overflow: hidden;
          transition: all 0.3s ease;
          border: 1px solid #eee;
        }

        .faq-item:hover {
          box-shadow: 0 5px 20px rgba(171, 84, 219, 0.1);
        }

        .faq-question {
          padding: 1.8rem 2rem;
          cursor: pointer;
          display: flex;
          justify-content: space-between;
          align-items: center;
          user-select: none;
        }

        .faq-question h4 {
          font-size: 1.15rem;
          color: var(--dark);
          font-weight: 600;
          margin: 0;
        }

        .faq-icon {
          width: 30px;
          height: 30px;
          background: var(--gradient);
          color: white;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 1.2rem;
          transition: transform 0.3s ease;
          flex-shrink: 0;
          margin-left: 1rem;
        }

        .faq-item.active .faq-icon {
          transform: rotate(180deg);
        }

        .faq-answer {
          max-height: 0;
          overflow: hidden;
          opacity: 0;
          transition: max-height 0.4s ease, padding 0.3s ease, opacity 0.4s ease;
          padding: 0 2rem;
        }

        .faq-item.active .faq-answer {
          max-height: 500px;
          opacity: 1;
          padding: 0 2rem 1.8rem;
        }

        /* Get In Touch Section */
        .get-in-touch {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 4rem 2rem;
        }

        /* Contact Section */
        .contact-section {
            padding: 6rem 2rem;
            background: white;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 5rem;
        }

        .contact-info-card {
            background: var(--gray);
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
        }

        .info-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .info-content h3 {
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .info-content p {
            color: var(--text-light);
            line-height: 1.8;
            font-size: 1rem;
        }

        .info-content a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .info-content a:hover {
            color: var(--primary-dark);
        }

        /* Contact Form */
        .contact-form-card {
            background: var(--gray);
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
        }

        .contact-form-card h2 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .contact-form-card p {
            color: var(--text-light);
            margin-bottom: 2.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(171, 84, 219, 0.1);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        /* Footer */
        footer {
            background: #000000;
            color: white;
            padding: 4rem 2rem 2rem;
        }

        .footer-content {
            max-width: 1320px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 4rem;
            padding-bottom: 3rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-about h3 {
            margin-bottom: 1.5rem;
            font-weight: 800;
        }

        .footer-about img {
            max-height: 60px;
            width: auto;
            max-width: 200px;
            margin-bottom: 1.5rem;
        }

        .footer-about p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .social-links {
          display: flex;
          gap: 12px;
          margin-top: 1rem;
        }

        .social-links a {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 40px;
          height: 40px;
          background: var(--gradient);
          color: white;
          border-radius: 50%;
          font-size: 1.2rem;
          transition: all 0.3s ease;
        }

        .social-links a:hover {
          transform: translateY(-3px);
          box-shadow: 0 4px 12px rgba(171, 84, 219, 0.4);
        }

        .footer-links h4 {
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 0.9rem;
        }

        .footer-links ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .footer-links ul li a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 2.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container,
            .about-content,
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .calculator-card {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .process-grid {
                grid-template-columns: 1fr;
            }

            .why-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-step:not(:last-child)::after {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                grid-template-columns: 1fr;
            }

            .why-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .floating-card {
                display: none;
            }
        }
    </style>
    <style>

/* Preloader Styles */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #AB54DB 0%, #8B3CB8 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

#preloader.fade-out {
    opacity: 0;
    visibility: hidden;
}

.preloader-content {
    text-align: center;
}

.preloader-logo {
    width: 150px;
    height: auto;
    margin-bottom: 2rem;
    animation: logoFloat 2s ease-in-out infinite;
}

@keyframes logoFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.spinner {
    width: 60px;
    height: 60px;
    margin: 0 auto 1.5rem;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.preloader-text {
    color: white;
    font-size: 1.2rem;
    font-weight: 500;
    margin-top: 1rem;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Loading dots animation */
.loading-dots {
    display: inline-block;
}

.loading-dots::after {
    content: '';
    animation: dots 1.5s steps(4, end) infinite;
}

@keyframes dots {
    0%, 20% {
        content: '';
    }
    40% {
        content: '.';
    }
    60% {
        content: '..';
    }
    80%, 100% {
        content: '...';
    }
}
</style>

<!-- ✅ FAQ improved styles -->
<style>
.faq-answer {
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: max-height 0.35s ease, opacity 0.35s ease, margin 0.35s ease;
  margin-top: 0;
}
.faq-item.active .faq-answer {
  max-height: 1000px; /* large value to accommodate content */
  opacity: 1;
  margin-top: 0.75rem;
}
.faq-item .faq-question {
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 600;
  padding: 0.5rem 0;
}
.faq-item.active {
  background-color: rgba(171,84,219,0.06); /* subtle highlight matching theme */
  border-radius: 8px;
  padding: 0.6rem;
}
.faq-item .faq-icon {
  transition: transform 0.3s ease;
}
.faq-item.active .faq-icon {
  transform: rotate(180deg);
}
</style>
</head>
<body>

<!-- Header -->
<header id="header">
  <nav>
    <a class="logo" href="#home">
      <img alt="Coplender" src="assets/img/cope2.png"/>
    </a>
    <ul class="nav-menu">
      <li><a href="#about">About</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#rates">Get loan</a></li>
      <li><a href="#testimonials">Testimonials</a></li>
      <li><a href="#contact-us">Contact</a></li>
      <li><a class="btn btn-primary" href="register">Sign Up</a></li>
    </ul>
  </nav>
</header>

<!-- Hero Section -->
<section class="hero" id="home">
<div class="hero-container">
<div class="hero-content">
<h1>Get Your <span>Dream Loan</span> in Minutes</h1>
<p>Fast, secure, and hassle-free lending solutions tailored to your needs. Experience the future of lending with competitive rates and instant approvals.</p>
<div class="hero-buttons">
<a class="btn btn-primary" href="#rates">Apply Now</a>
<a class="btn btn-white" href="#about">Learn More</a>
</div>
<div class="hero-stats">
<div class="stat-item">
<h3>15K+</h3>
<p>Happy Customers</p>
</div>
<div class="stat-item">
<h3>$500M+</h3>
<p>Loans Disbursed</p>
</div>
<div class="stat-item">
<h3>98%</h3>
<p>Approval Rate</p>
</div>
</div>
</div>
<div class="hero-image">
<div class="hero-visual">
<div class="main-card"></div>
<div class="floating-card card-1">
<div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
<div style="font-weight: 600; color: var(--dark);">$50,000</div>
<div style="font-size: 0.85rem; color: var(--text-light);">Instant Approval</div>
</div>
<div class="floating-card card-2">
<div style="font-size: 2rem; margin-bottom: 0.5rem;">✓</div>
<div style="font-weight: 600; color: var(--dark);">Approved</div>
<div style="font-size: 0.85rem; color: var(--text-light);">In 5 Minutes</div>
</div>
<div class="floating-card card-3">
<div style="font-size: 2rem; margin-bottom: 0.5rem;">🔒</div>
<div style="font-weight: 600; color: var(--dark);">100% Secure</div>
<div style="font-size: 0.85rem; color: var(--text-light);">Bank-level Security</div>
</div>
</div>
</div>
</div>
</section>

<!-- About Section -->
<section class="about" id="about">
  <div class="container">
    <div class="about-content">
      
      <!-- Left: Image and Badge -->
      <div class="about-image">
        <svg viewBox="0 0 500 600" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="grad1" x1="0%" x2="100%" y1="0%" y2="100%">
              <stop offset="0%" style="stop-color:#AB54DB;stop-opacity:1"></stop>
              <stop offset="100%" style="stop-color:#C47EED;stop-opacity:1"></stop>
            </linearGradient>
          </defs>
          <rect fill="#f8f9fa" height="500" rx="30" width="400" x="50" y="50"></rect>
          <rect fill="url(#grad1)" height="200" opacity="0.2" rx="20" width="300" x="100" y="100"></rect>
          <circle cx="250" cy="200" fill="url(#grad1)" r="60"></circle>
          <path d="M 230 200 L 245 215 L 270 185" fill="none" stroke="white" stroke-linecap="round" stroke-width="5"></path>
          <rect fill="url(#grad1)" height="15" opacity="0.3" rx="7" width="200" x="150" y="320"></rect>
          <rect fill="url(#grad1)" height="15" opacity="0.3" rx="7" width="150" x="150" y="360"></rect>
          <rect fill="url(#grad1)" height="15" opacity="0.3" rx="7" width="180" x="150" y="400"></rect>
        </svg>
        <div class="about-badge">
          <h3>10+</h3>
          <p>Years Experience</p>
        </div>
      </div>

      <!-- Right: Text Content -->
      <div class="about-text">
        <span class="section-tag">About Coplender</span>
        <h3>Your Trusted Financial Partner</h3>
        <p>At Coplender, we believe that everyone deserves access to fair and transparent financial services. With years of experience in the lending industry, we've helped thousands of customers achieve their dreams through our flexible loan products.</p>
        <p>Our mission is to simplify the borrowing process, making it quick, secure, and accessible to all. We leverage cutting-edge technology to provide instant loan approvals while maintaining the highest standards of customer service.</p>

        <div class="about-features">
          <div class="feature-item">
            <div class="feature-icon">🚀</div>
            <div>
              <h4>Quick Approval Process</h4>
              <p>Get approved in minutes with our streamlined application process</p>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">🔒</div>
            <div>
              <h4>Secure & Safe Platform</h4>
              <p>Bank-level encryption ensures your data is always protected</p>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">💰</div>
            <div>
              <h4>Competitive Interest Rates</h4>
              <p>Best rates in the market with transparent pricing</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



<!-- Services Section -->
<section class="services" id="services">
<div class="container">
<div class="section-header">
<span class="section-tag">Our Services</span>
<h2>Comprehensive Lending Solutions</h2>
<p>We offer a wide range of loan products designed to meet your specific financial needs</p>
</div>
<div class="services-grid">
<div class="service-card">
<div class="service-icon">🏠</div>
<h3>Home Loans</h3>
<p>Make your dream home a reality with our flexible home loan options featuring low interest rates and extended repayment periods.</p>
<a href="#contact-us">Learn More →</a>
</div>
<div class="service-card">
<div class="service-icon">🚗</div>
<h3>Auto Loans</h3>
<p>Drive your dream car today with our hassle-free auto financing solutions and competitive interest rates.</p>
<a href="#contact-us">Learn More →</a>
</div>
<div class="service-card">
<div class="service-icon">💼</div>
<h3>Business Loans</h3>
<p>Fuel your business growth with our tailored business loan packages designed for entrepreneurs and SMEs.</p>
<a href="#contact-us">Learn More →</a>
</div>
<div class="service-card">
<div class="service-icon">🎓</div>
<h3>Education Loans</h3>
<p>Invest in your future with our education loans that cover tuition, books, and living expenses.</p>
<a href="#contact-us">Learn More →</a>
</div>
<div class="service-card">
<div class="service-icon">💳</div>
<h3>Personal Loans</h3>
<p>Quick personal loans for any purpose - weddings, medical emergencies, travel, or debt consolidation.</p>
<a href="#contact-us">Learn More →</a>
</div>
<div class="service-card">
<div class="service-icon">⚡</div>
<h3>Instant Cash</h3>
<p>Need money urgently? Get instant cash loans approved within minutes with minimal documentation.</p>
<a href="#contact-us">Learn More →</a>
</div>
</div>
</div>
</section>

<!-- Process Section -->
<section class="process">
<div class="container">
<div class="section-header">
<span class="section-tag">How It Works</span>
<h2>Get Your Loan in 3 Simple Steps</h2>
<p>Our streamlined process makes borrowing quick and hassle-free</p>
</div>
<div class="process-grid">
<div class="process-step">
<div class="step-number">1</div>
<h3>Apply Online</h3>
<p>Fill out our simple online application form in just a few minutes with basic information about yourself and your loan requirements.</p>
</div>
<div class="process-step">
<div class="step-number">2</div>
<h3>Get Approved</h3>
<p>Our AI-powered system reviews your application instantly and provides you with an approval decision within minutes.</p>
</div>
<div class="process-step">
<div class="step-number">3</div>
<h3>Receive Funds</h3>
<p>Once approved, funds are transferred directly to your bank account within 24 hours. It's that simple!</p>
</div>
</div>
</div>
</section>

<!-- Why Choose Us -->
<section class="why-choose">
<div class="container">
<div class="section-header">
<span class="section-tag" style="color: rgba(255,255,255,0.8);">Why Choose Us</span>
<h2 style="color: white;">Experience Excellence in Lending</h2>
<p style="color: rgba(255,255,255,0.9);">Join thousands of satisfied customers who trust us with their financial needs</p>
</div>
<div class="why-grid">
<div class="why-item">
<div class="why-number">15K+</div>
<h3>Happy Customers</h3>
<p>Trusted by thousands of satisfied borrowers nationwide</p>
</div>
<div class="why-item">
<div class="why-number">$500M+</div>
<h3>Loans Disbursed</h3>
<p>Helping dreams come true with substantial funding</p>
</div>
<div class="why-item">
<div class="why-number">98%</div>
<h3>Approval Rate</h3>
<p>One of the highest approval rates in the industry</p>
</div>
<div class="why-item">
<div class="why-number">24/7</div>
<h3>Customer Support</h3>
<p>Always available when you need assistance</p>
</div>
</div>
</div>
</section>

<!-- Loan Calculator -->
<section class="rates" id="rates">
  <div class="container">
    <!-- Centered Header -->
    <div class="section-header center-text fade-in">
      <span class="section-tag">Calculator</span>
      <h2>Loan Calculator</h2>
      <p>Calculate your monthly payments and see how much you can borrow</p>
    </div>

    <div class="loan-section fade-in">
      <div class="loan-image fade-in-left">
        <img src="assets/img/chooseus.jpg" alt="Loan Consultation" />
      </div>

      <div class="loan-calculator fade-in-right">
        <div class="calculator-container">
          <div class="calculator-card">
            <div class="calculator-inputs">
              <div class="form-group">
                <label>Loan Amount (₦)</label>
                <input id="loanAmount" type="number" value="100000" min="10000" max="10000000" step="10000" />
                <input id="loanAmountRange" type="range" value="100000" min="10000" max="10000000" step="10000" />
              </div>

              <div class="form-group">
                <label>Interest Rate (% per month)</label>
                <input id="interestRate" type="number" value="2.5" min="2.5" max="5" step="0.1" />
                <input id="interestRateRange" type="range" value="2.5" min="2.5" max="5" step="0.1" />
              </div>

              <div class="form-group">
                <label>Loan Tenure (Months)</label>
                <input id="loanTenure" type="number" value="6" min="3" max="24" step="1" />
                <input id="loanTenureRange" type="range" value="6" min="3" max="24" step="1" />
              </div>

              <div class="form-group">
                <label>Loan Type</label>
                <select id="loanType">
                  <option value="2.5">Personal Loan (2.5%)</option>
                  <option value="3.0">Business Loan (3.0%)</option>
                  <option value="3.5">Emergency Loan (3.5%)</option>
                  <option value="4.0">Quick Cash (4.0%)</option>
                </select>
              </div>
            </div>

            <div class="calculator-results">
              <h3>Your Monthly Payment</h3>
              <div class="result-amount" id="monthlyPayment">₦0</div>
              <div class="result-details">
                <div class="result-item">
                  <span>Total Amount Payable</span>
                  <strong id="totalAmount">₦0</strong>
                </div>
                <div class="result-item">
                  <span>Total Interest Payable</span>
                  <strong id="totalInterest">₦0</strong>
                </div>
                <div class="result-item">
                  <span>Principal Amount</span>
                  <strong id="principalAmount">₦0</strong>
                </div>
              </div>
              <a class="btn btn-primary" href="register.php" style="width: 100%; margin-top: 2rem;">Apply for this Loan</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 🎨 Updated Styles -->
<style>
.center-text {
  text-align: center;
  margin: 0 auto 4rem auto;
  width: 100%;
}
.center-text h2 {
  font-size: 3rem;
  font-weight: 800;
  margin: 0.5rem 0;
  background: linear-gradient(90deg, #7c3aed, #ec4899);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: 0.5px;
}
.center-text p {
  color: #555;
  font-size: 1.3rem;
  max-width: 700px;
  margin: 0.5rem auto 0;
}

/* Layout */
.loan-section {
  display: flex;
  align-items: stretch;
  justify-content: center;
  width: 100%;
  max-width: 1500px;
  margin: 0 auto;
  padding: 3rem 0;
  gap: 0;
}

/* Image Section */
.loan-image {
  flex: 0.8; /* smaller image */
  max-width: 35%;
  overflow: hidden;
}
.loan-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 20px 0 0 20px;
  transition: transform 1s ease;
}
.loan-image img:hover {
  transform: scale(1.05);
}

/* Calculator Box */
.loan-calculator {
  flex: 1.8; /* bigger calculator */
  max-width: 65%;
  background: linear-gradient(135deg, #ffffff, #f9f6ff);
  border-radius: 0 20px 20px 0;
  padding: 4.5rem 5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  box-shadow: 0 5px 25px rgba(0,0,0,0.08);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.loan-calculator:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 35px rgba(139,92,246,0.15);
}

/* Calculator Layout */
.calculator-card {
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  gap: 2.5rem;
}

/* Inputs */
.form-group {
  margin-bottom: 1.5rem;
}
.form-group label {
  display: block;
  font-weight: 600;
  color: #333;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}
input[type="number"],
select {
  width: 100%;
  padding: 1rem 1.2rem;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-size: 1.1rem;
  outline: none;
  transition: border-color 0.3s;
}
input[type="number"]:focus,
select:focus {
  border-color: #8b5cf6;
}

/* Range Slider */
input[type="range"] {
  width: 100%;
  height: 8px;
  background: linear-gradient(90deg, #8b5cf6, #ec4899);
  border-radius: 4px;
  outline: none;
  margin-top: 0.6rem;
  appearance: none;
}
input[type="range"]::-webkit-slider-thumb {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: #8b5cf6;
  cursor: pointer;
  appearance: none;
  transition: background 0.3s;
}
input[type="range"]::-webkit-slider-thumb:hover {
  background: #ec4899;
}

/* Results */
.calculator-results {
  text-align: center;
  padding: 2.5rem;
  border-radius: 15px;
  background: #ffffff;
}
.calculator-results h3 {
  color: #333;
  margin-bottom: 1.5rem;
  font-size: 1.6rem;
}
.result-amount {
  font-size: 2.8rem;
  font-weight: 800;
  color: #7c3aed;
  margin-bottom: 1.5rem;
}
.result-details {
  display: grid;
  gap: 1rem;
}
.result-item span {
  color: #666;
}
.result-item strong {
  color: #333;
}

/* Animation */
.fade-in {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeInUp 1s ease forwards;
}
.fade-in-left {
  opacity: 0;
  transform: translateX(-60px);
  animation: fadeInLeft 1s ease forwards;
}
.fade-in-right {
  opacity: 0;
  transform: translateX(60px);
  animation: fadeInRight 1s ease forwards;
}
@keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInRight { to { opacity: 1; transform: translateX(0); } }
@keyframes fadeInLeft { to { opacity: 1; transform: translateX(0); } }

/* Soft animated background for the calculator */
.loan-calculator {
  position: relative;
  flex: 1.3;
  max-width: 55%;
  background: white;
  border-radius: 0 20px 20px 0;
  padding: 3.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

/* Gradient glow animation behind calculator */
.loan-calculator::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(120deg, #ab54db, #0099ff, #ff66cc);
  background-size: 300% 300%;
  z-index: 0;
  opacity: 0.15;
  animation: gradientFlow 8s ease infinite;
  border-radius: inherit;
}

/* Ensure calculator content stays above glow */
.loan-calculator * {
  position: relative;
  z-index: 1;
}

/* Animate gradient movement */
@keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}


/* Responsive */
@media (max-width: 992px) {
  .loan-section {
    flex-direction: column;
  }
  .loan-image, .loan-calculator {
    max-width: 100%;
    border-radius: 20px;
  }
  .loan-image img {
    border-radius: 20px 20px 0 0;
  }
  .loan-calculator {
    padding: 2.5rem;
  }
  .center-text h2 {
    font-size: 2.3rem;
  }
}
</style>

<!-- Get In Touch / Newsletter Section -->
<section class="get-in-touch">
<div class="container">
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; max-width: 1000px; margin: 0 auto;">
<div style="color: white;">
<span class="section-tag" style="color: rgba(255,255,255,0.8);">Get in Touch</span>
<h2 style="color: white; font-size: 2.5rem; margin-bottom: 1rem;">Ready to Get Started?</h2>
<p style="color: rgba(255,255,255,0.9); font-size: 1.1rem;">Subscribe to our newsletter and stay updated with the latest loan offers and financial tips</p>
</div>
<div>
<form id="subscribeForm">
<div style="display: flex; gap: 1rem; background: white; padding: 0.5rem; border-radius: 50px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
<input placeholder="Enter your email address" required type="email" style="flex: 1; padding: 1rem 1.5rem; border: none; outline: none; font-size: 1rem; font-family: 'Poppins', sans-serif; border-radius: 50px;"/>
<button class="btn btn-primary" type="submit" style="margin: 0;">Subscribe</button>
</div>
</form>
</div>
</div>
</div>
</section>

<!-- Testimonials -->
<section class="testimonials" id="testimonials">
<div class="container">
<div class="section-header">
<span class="section-tag">Testimonials</span>
<h2>What Our Clients Say</h2>
<p>Don't just take our word for it - hear from our satisfied customers</p>
</div>
<div class="testimonials-slider">
<div class="testimonials-track">
<div class="testimonial-card">
<div class="quote-icon">"</div>
<p class="testimonial-text">Coplender made my home loan process incredibly smooth. The approval was instant and the rates were unbeatable. Highly recommended for anyone looking for hassle-free lending!</p>
<div class="testimonial-author">
<div class="author-avatar">JD</div>
<div class="author-info">
<h4>John Doe</h4>
<p>Home Loan Customer</p>
<div class="stars">★★★★★</div>
</div>
</div>
</div>
<div class="testimonial-card">
<div class="quote-icon">"</div>
<p class="testimonial-text">I was amazed by how quickly I got approved for my business loan. The team was professional and the entire process was transparent. Coplender is truly changing the lending game!</p>
<div class="testimonial-author">
<div class="author-avatar">SA</div>
<div class="author-info">
<h4>Sarah Anderson</h4>
<p>Business Loan Customer</p>
<div class="stars">★★★★★</div>
</div>
</div>
</div>
<div class="testimonial-card">
<div class="quote-icon">"</div>
<p class="testimonial-text">Excellent service! Got my personal loan approved within hours. The interest rates are competitive and the customer support team is always helpful. Thank you Coplender!</p>
<div class="testimonial-author">
<div class="author-avatar">MB</div>
<div class="author-info">
<h4>Michael Brown</h4>
<p>Personal Loan Customer</p>
<div class="stars">★★★★★</div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- FAQ Section -->

<section id="faq"  class="faq-section">
<div class="container">
<div class="section-header">
<span class="section-tag">FAQ</span>
<h2>Frequently Asked Questions</h2>
<p>Find answers to common questions about our loan services</p>
</div>

<div class="faq-container">
<div class="faq-item">
<div class="faq-question">
<h4>What types of loans do you offer?</h4>
<span class="faq-icon">▼</span>
</div>
<div class="faq-answer">
<p>We offer personal and business loans with flexible terms and competitive rates. Visit our Loan Products page for more details.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-question">
<h4>What is the minimum and maximum period for loan repayment?</h4>
<span class="faq-icon">▼</span>
</div>
<div class="faq-answer">
<p>Loan repayment terms range from 3 to 24 months, depending on the amount and your selected plan.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-question">
<h4>Who is eligible to apply?</h4>
<span class="faq-icon">▼</span>
</div>
<div class="faq-answer">
<ul style="list-style: none; padding: 0;">
<li style="padding: 0.5rem 0;">• Must be at least 18 years old</li>
<li style="padding: 0.5rem 0;">• A Nigerian citizen or resident</li>
<li style="padding: 0.5rem 0;">• Have a steady income source</li>
<li style="padding: 0.5rem 0;">• Provide a valid ID (e.g., National ID, Driver's License, Passport)</li>
</ul>
</div>
</div>

<div class="faq-item">
<div class="faq-question">
<h4>How do I apply?</h4>
<span class="faq-icon">▼</span>
</div>
<div class="faq-answer">
<p>Apply through our website or mobile app by completing the form and submitting required documents.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-question">
<h4>Can I repay my loan early?</h4>
<span class="faq-icon">▼</span>
</div>
<div class="faq-answer">
<p>Yes! Early repayments are allowed, and you may qualify for an interest discount.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-question">
<h4>Is there a late repayment penalty?</h4>
<span class="faq-icon">▼</span>
</div>
<div class="faq-answer">
<p>Yes, late repayment fees apply as per loan terms. Frequent delays may lead to additional penalties.</p>
</div>
</div>
</div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact-us">
<div class="container">
<div class="section-header">
<span class="section-tag">Contact Us</span>
<h2>Get in Touch</h2>
<p>Get in touch with our team. We're here to help you with all your loan needs</p>
</div>

<div class="contact-grid">
<!-- Contact Information -->
<div class="contact-info-card">
<div class="info-item">
<div class="info-icon">📍</div>
<div class="info-content">
<h3>Visit Our Office</h3>
<p>123 Herbert Macaulay Way,<br>Yaba, Lagos State,<br>Nigeria</p>
</div>
</div>
<div class="info-item">
<div class="info-icon">📞</div>
<div class="info-content">
<h3>Call Us</h3>
<p>Mobile: <a href="tel:+2348012345678">+234 801 234 5678</a><br>
Office: <a href="tel:+2341234567">+234 1 234 567</a></p>
</div>
</div>
<div class="info-item">
<div class="info-icon">✉️</div>
<div class="info-content">
<h3>Email Us</h3>
<p>Support: <a href="mailto:support@coplender.com">support@coplender.com</a><br>
Info: <a href="mailto:info@coplender.com">info@coplender.com</a></p>
</div>
</div>
<div class="info-item">
<div class="info-icon">⏰</div>
<div class="info-content">
<h3>Working Hours</h3>
<p>Monday - Friday: 09:00 - 18:00<br>
Saturday: 10:00 - 14:00<br>
Sunday: Closed</p>
</div>
</div>
</div>

<!-- Contact Form -->
<div class="contact-form-card">
<h2>Send Us a Message</h2>
<p>Fill out the form below and we'll get back to you within 24 hours</p>
<form id="contactForm">
<div class="form-row">
<div class="form-group">
<label>Full Name *</label>
<input type="text" placeholder="John Doe" required>
</div>
<div class="form-group">
<label>Email Address *</label>
<input type="email" placeholder="john@example.com" required>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label>Phone Number *</label>
<input type="tel" placeholder="+234 801 234 5678" required>
</div>
<div class="form-group">
<label>Subject *</label>
<select required>
<option value="">Select a subject</option>
<option value="loan">Loan Inquiry</option>
<option value="support">Technical Support</option>
<option value="complaint">Complaint</option>
<option value="feedback">Feedback</option>
<option value="other">Other</option>
</select>
</div>
</div>
<div class="form-group">
<label>Message *</label>
<textarea placeholder="Tell us how we can help you..." required></textarea>
</div>
<button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
</form>
</div>
</div>
</div>
</section>

<!-- Footer -->
<footer>
<div class="footer-content">
<div class="footer-about">
<img alt="Coplender" src="assets/img/cope2.png"/>
<p>Your trusted partner for all lending needs. We provide fast, secure, and transparent loan solutions to help you achieve your financial goals.</p>
<div class="social-links">
<a href="https://facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
<a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
<a href="https://linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
<a href="https://instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
</div>
</div>
<div class="footer-links">
<h4>Quick Links</h4>
<ul>
<li><a href="#about">About Us</a></li>
<li><a href="#services">Services</a></li>
<li><a href="#rates">Interest Rates</a></li>
<li><a href="#contact-us">Contact Us</a></li>
</ul>
</div>
<div class="footer-links">
<h4>Services</h4>
<ul>
<li><a href="#services">Home Loans</a></li>
<li><a href="#services">Auto Loans</a></li>
<li><a href="#services">Business Loans</a></li>
<li><a href="#services">Personal Loans</a></li>
</ul>
</div>
<div class="footer-links">
<h4>Support</h4>
<ul>
<li><a href="#faq">FAQs</a></li>

<li><a href="#">Privacy Policy</a></li>
<li><a href="#">Terms of Service</a></li>
<li><a href="#">Help Center</a></li>
</ul>
</div>
</div>
<div class="footer-bottom">
<p>© 2025 Coplender. All rights reserved. | Designed with ❤️ for your financial success</p>
</div>
</footer>

<div id="preloader">
    <div class="preloader-content">
        <!-- If you have a logo image -->
        <img src="assets/img/cope2.png" alt="Coplender" class="preloader-logo">
        
        <!-- Spinner -->
        <div class="spinner"></div>
        
        <!-- Loading text -->
        <div class="preloader-text">
            Loading<span class="loading-dots"></span>
        </div>
    </div>
</div>

<script>



// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Header scroll effect
window.addEventListener('scroll', function() {
    const header = document.getElementById('header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Contact Form submission
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Thank you for your message! We will get back to you within 24 hours.');
    this.reset();
});

// Loan Calculator
        <!-- ✅ Loan Calculator Script -->
<script>
  // Function to format currency (₦100,000)
  function formatCurrency(amount) {
    return '₦' + amount.toLocaleString('en-NG', { minimumFractionDigits: 0 });
  }

  function calculateLoan() {
    const loanAmount = parseFloat(document.getElementById('loanAmount').value);
    const interestRate = parseFloat(document.getElementById('interestRate').value);
    const loanTenure = parseFloat(document.getElementById('loanTenure').value);

    // Convert monthly interest rate from % to decimal
    const monthlyRate = interestRate / 100;

    // EMI Formula: [P * r * (1+r)^n] / [(1+r)^n - 1]
    const emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTenure)) /
                (Math.pow(1 + monthlyRate, loanTenure) - 1);

    const totalAmount = emi * loanTenure;
    const totalInterest = totalAmount - loanAmount;

    // Display results
    document.getElementById('monthlyPayment').innerText = formatCurrency(Math.round(emi));
    document.getElementById('totalAmount').innerText = formatCurrency(Math.round(totalAmount));
    document.getElementById('totalInterest').innerText = formatCurrency(Math.round(totalInterest));
    document.getElementById('principalAmount').innerText = formatCurrency(Math.round(loanAmount));
  }

  // Sync range and number inputs
  function syncInputs(rangeId, numberId) {
    const range = document.getElementById(rangeId);
    const number = document.getElementById(numberId);

    range.addEventListener('input', () => {
      number.value = range.value;
      calculateLoan();
    });

    number.addEventListener('input', () => {
      range.value = number.value;
      calculateLoan();
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Link sliders and inputs
    syncInputs('loanAmountRange', 'loanAmount');
    syncInputs('interestRateRange', 'interestRate');
    syncInputs('loanTenureRange', 'loanTenure');

    // Update rate when loan type changes
    document.getElementById('loanType').addEventListener('change', (e) => {
      document.getElementById('interestRate').value = e.target.value;
      document.getElementById('interestRateRange').value = e.target.value;
      calculateLoan();
    });

    // Calculate immediately on load
    calculateLoan();
  });
</script>

<!-- ✅ Loan Calculator Script -->
<script>
  function formatCurrency(amount) {
    return '₦' + amount.toLocaleString('en-NG', { minimumFractionDigits: 0 });
  }

  function calculateLoan() {
    const loanAmount = parseFloat(document.getElementById('loanAmount').value);
    const interestRate = parseFloat(document.getElementById('interestRate').value);
    const loanTenure = parseFloat(document.getElementById('loanTenure').value);
    const monthlyRate = interestRate / 100;
    const emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTenure)) /
                (Math.pow(1 + monthlyRate, loanTenure) - 1);
    const totalAmount = emi * loanTenure;
    const totalInterest = totalAmount - loanAmount;
    document.getElementById('monthlyPayment').innerText = formatCurrency(Math.round(emi));
    document.getElementById('totalAmount').innerText = formatCurrency(Math.round(totalAmount));
    document.getElementById('totalInterest').innerText = formatCurrency(Math.round(totalInterest));
    document.getElementById('principalAmount').innerText = formatCurrency(Math.round(loanAmount));
  }

  function syncInputs(rangeId, numberId) {
    const range = document.getElementById(rangeId);
    const number = document.getElementById(numberId);
    range.addEventListener('input', () => { number.value = range.value; calculateLoan(); });
    number.addEventListener('input', () => { range.value = number.value; calculateLoan(); });
  }

  document.addEventListener('DOMContentLoaded', () => {
    syncInputs('loanAmountRange', 'loanAmount');
    syncInputs('interestRateRange', 'interestRate');
    syncInputs('loanTenureRange', 'loanTenure');
    document.getElementById('loanType').addEventListener('change', (e) => {
      document.getElementById('interestRate').value = e.target.value;
      document.getElementById('interestRateRange').value = e.target.value;
      calculateLoan();
    });
    calculateLoan();
  });
</script>

<!-- ✅ FAQ Accordion Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
      const question = item.querySelector('.faq-question');
      question.addEventListener('click', () => {
        item.classList.toggle('active');
        faqItems.forEach(other => {
          if (other !== item) other.classList.remove('active');
        });
      });
    });
  });
</script>

<!-- ✅ Testimonials Auto Slider -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.testimonial-item');
    let current = 0;
    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.style.display = (i === index) ? 'block' : 'none';
      });
    }
    function nextSlide() {
      current = (current + 1) % slides.length;
      showSlide(current);
    }
    if (slides.length > 0) {
      showSlide(current);
      setInterval(nextSlide, 10000); // 10 seconds
    }
  });
</script>

<style>

.faq-answer {
  display: none;
  overflow: hidden;
  transition: all 0.3s ease;
}

.faq-item.active .faq-answer {
  display: block;
}

.faq-item .faq-question {
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 600;
  padding: 0.5rem 0;
}

.faq-item.active {
  background-color: #f9fafb; /* Add your preferred highlight color */
}

.faq-item.active .faq-icon {
  transform: rotate(180deg);
  transition: transform 0.3s ease;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const faqs = document.querySelectorAll(".faq-item");

  faqs.forEach(faq => {
    const question = faq.querySelector(".faq-question");

    question.addEventListener("click", () => {
      // Close all others first
      faqs.forEach(otherFaq => {
        if (otherFaq !== faq) otherFaq.classList.remove("active");
      });
      
      // Toggle the clicked FAQ
      faq.classList.toggle("active");
    });
  });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    question.addEventListener('click', () => {
      const isActive = item.classList.contains('active');
      faqItems.forEach(other => other.classList.remove('active'));
      if (!isActive) item.classList.add('active');
    });
  });
});
</script>



<!-- ✅ FAQ Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');

    // Hover: open this item and close others
    item.addEventListener('mouseenter', () => {
      faqItems.forEach(other => {
        if (other !== item) other.classList.remove('active');
      });
      item.classList.add('active');
    });

    // Click: toggle this item (close others)
    question.addEventListener('click', (e) => {
      const isActive = item.classList.contains('active');
      faqItems.forEach(other => other.classList.remove('active'));
      if (!isActive) {
        item.classList.add('active');
      } else {
        // allow clicking an open item to close it
        item.classList.remove('active');
      }
    });
  });

  // Optional: close all on mouseleave of the faq container (uncomment if desired)
  // const faqContainer = document.querySelector('.faq-container');
  // if (faqContainer) {
  //   faqContainer.addEventListener('mouseleave', () => {
  //     faqItems.forEach(i => i.classList.remove('active'));
  //   });
  // }
});
</script>

// Replace the broken script tag with this correct version:

<script>
// Preloader Script
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    
    // Add a minimum display time (optional, for smoother UX)
    setTimeout(function() {
        preloader.classList.add('fade-out');
        
        // Remove preloader from DOM after fade out
        setTimeout(function() {
            preloader.style.display = 'none';
        }, 500);
    }, 1000); // Shows for at least 1 second
});

// Fallback: Hide preloader after 5 seconds even if page hasn't fully loaded
setTimeout(function() {
    const preloader = document.getElementById('preloader');
    if (preloader && !preloader.classList.contains('fade-out')) {
        preloader.classList.add('fade-out');
        setTimeout(function() {
            preloader.style.display = 'none';
        }, 500);
    }
}, 5000);
</script>