@extends('layouts.main')

@push('title')
    <title>About Us - Gifts Hub</title>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #ffffff;
    min-height: 100vh;
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.about-header {
    text-align: center;
    margin-bottom: 80px;
    padding: 60px 40px;
    background: #f8f9fa;
    border: 2px solid rgba(102, 126, 234, 0.3);
    border-radius: 20px;
    position: relative;
    overflow: hidden;
}


.about-header h1 {
    font-size: 2.2em;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    letter-spacing: -1px;
}

.about-header p {
    font-size: 1.1em;
    color: #666;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.8;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-bottom: 80px;
}

.stat-item {
    background: #f8f9fa;
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 40px 30px;
    border-radius: 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}


.stat-item:hover {
    background: #e9ecef;
}

.stat-number {
    font-size: 2.2em;
    font-weight: 700;
    background: linear-gradient(135deg, #f093fb, #f5576c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1em;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 500;
}

.section {
    margin-bottom: 80px;
}

.section-title {
    font-size: 1.8em;
    margin-bottom: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 3px;
    background: #f093fb;
    border-radius: 2px;
}

.section-content {
    background: #f8f9fa;
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 50px;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
}

.section-content p {
    margin-bottom: 20px;
    font-size: 1em;
    color: #444;
    line-height: 1.8;
    font-weight: 400;
}

.section-content p:last-child {
    margin-bottom: 0;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.value-card {
    background: #f8f9fa;
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 40px 30px;
    border-radius: 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}


.value-card:hover {
    background: #e9ecef;
}

.value-number {
    font-size: 2.5em;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    display: block;
}

.value-title {
    font-size: 1.2em;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}

.value-description {
    color: #666;
    font-size: 1em;
    line-height: 1.6;
}

.quote-section {
    background: #f8f9fa;
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 60px 50px;
    border-radius: 20px;
    margin: 80px 0;
    position: relative;
}

.quote-section::before {
    content: '"';
    position: absolute;
    top: 20px;
    left: 30px;
    font-size: 8em;
    color: rgba(102, 126, 234, 0.1);
    font-family: Georgia, serif;
}

.quote-text {
    font-size: 1.4em;
    font-style: italic;
    margin-bottom: 30px;
    color: #333;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}

.quote-text strong {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600;
}

.quote-author {
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    z-index: 1;
}

.author-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.2em;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.author-info h4 {
    margin: 0;
    color: #333;
    font-size: 1.1em;
    font-weight: 600;
}

.author-info p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 0.9em;
}

@media (max-width: 768px) {
    .about-container {
        padding: 40px 15px;
    }
    
    .about-header {
        padding: 40px 25px;
    }
    
    .about-header h1 {
        font-size: 2.5em;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .section-content {
        padding: 30px 25px;
    }
    
    .quote-section {
        padding: 40px 25px;
    }
    
    .quote-author {
        flex-direction: column;
        text-align: center;
    }
    
    .quote-text {
        font-size: 1.4em;
    }
}
</style>
@endpush

@section('content')

<div class="about-container">
    <div class="about-header">
        <h1>About Gifts Hub</h1>
        <p>Your trusted partner for finding the perfect gifts for every occasion</p>
    </div>


    <div class="section">
        <h2 class="section-title">Our Mission</h2>
        <div class="section-content">
            <p>To make every moment of giving feel as special as the moment of receiving.</p>
            <p>We believe gifting is one of the most human things we do. Behind every wrapped box is a relationship, a memory, a feeling. Our role is to help you find the gift that carries all of that — effortlessly, beautifully, and with care.</p>
            <p>From birthdays and anniversaries to festivals and milestones, Gifts Hub is built to make you feel confident in every gift you give.</p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">What We Stand For</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-number">01</div>
                <div class="value-title">Thoughtful Curation</div>
                <div class="value-description">Every product in our store is handpicked for quality, meaning, and that "wow" factor.</div>
            </div>
            <div class="value-card">
                <div class="value-number">02</div>
                <div class="value-title">Personal Touch</div>
                <div class="value-description">We design the gifting experience to feel personal — never generic, never rushed.</div>
            </div>
            <div class="value-card">
                <div class="value-number">03</div>
                <div class="value-title">Trusted Quality</div>
                <div class="value-description">We stand behind every item. If it doesn't meet our standard, it doesn't make the shelf.</div>
            </div>
        </div>
    </div>

    <div class="quote-section">
        <div class="quote-text">
            We started Gifts Hub so no one ever has to settle for a gift that doesn't mean something.
        </div>
        <div class="quote-author">
            <div class="author-avatar">SB</div>
            <div class="author-info">
                <h4>Sandesh Bhandari</h4>
                <p>Founder & CEO</p>
            </div>
        </div>
    </div>

</div>

@endsection