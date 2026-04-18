@extends('layouts.main')

@push('title')
    <title>Contact Us - Gifts Hub</title>
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

.contact-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.contact-header {
    text-align: center;
    margin-bottom: 80px;
    padding: 60px 40px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
    border: 1px solid rgba(102, 126, 234, 0.1);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}


.contact-header p {
    font-size: 1.1em;
    color: #666;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.8;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 80px;
}

.contact-form-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    position: relative;
    overflow: hidden;
}

.contact-form-card h3 {
    font-size: 1.8em;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600;
}

.card-sub {
    font-size: 1em;
    color: #666;
    margin-bottom: 30px;
    line-height: 1.6;
}

.form-label-gh {
    display: block;
    font-size: 0.9em;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #667eea;
    margin-bottom: 8px;
}

.form-control-gh {
    width: 100%;
    padding: 15px 20px;
    font-size: 1em;
    font-family: 'Poppins', sans-serif;
    color: #333;
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(102, 126, 234, 0.3);
    border-radius: 12px;
    outline: none;
    transition: box-shadow 0.3s ease;
    margin-bottom: 20px;
    display: block;
}

.form-control-gh::placeholder { 
    color: #999; 
}

.form-control-gh:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-gh-send {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-size: 1em;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: box-shadow 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-gh-send:hover { 
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.contact-info-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.gh-info-top {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    position: relative;
    overflow: hidden;
}

.gh-info-top h3 {
    font-size: 1.8em;
    margin-bottom: 30px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600;
}

.gh-contact-item {
    display: flex;
    gap: 15px;
    align-items: flex-start;
    padding: 20px 0;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

.gh-contact-item:last-child { 
    border-bottom: none; 
    padding-bottom: 0; 
}

.gh-contact-item:first-child { 
    padding-top: 0; 
}

.gh-ci-icon {
    width: 40px; 
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex; 
    align-items: center; 
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.gh-ci-label {
    font-size: 0.9em;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #667eea;
    margin-bottom: 5px;
}

.gh-ci-val {
    font-size: 1em;
    color: #444;
    line-height: 1.6;
    font-weight: 400;
    margin: 0;
}

.gh-social-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    border: 2px solid rgba(102, 126, 234, 0.3);
    padding: 25px 30px;
    border-radius: 20px;
    display: flex; 
    align-items: center; 
    justify-content: space-between;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    position: relative;
    overflow: hidden;
}

.social-label {
    font-size: 0.9em; 
    font-weight: 500;
    letter-spacing: 1px; 
    text-transform: uppercase;
    color: #667eea;
}

.social-icons { 
    display: flex; 
    gap: 10px; 
}

.social-icon-btn {
    width: 40px; 
    height: 40px; 
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(102, 126, 234, 0.3);
    display: flex; 
    align-items: center; 
    justify-content: center;
    color: #667eea;
    font-size: 16px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-icon-btn:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.form-success { 
    display: none; 
    text-align: center; 
    padding: 60px 40px; 
}

.success-ring {
    width: 80px; 
    height: 80px; 
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex; 
    align-items: center; 
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 24px; 
    color: #ffffff;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.form-success h4 {
    font-size: 1.8em;
    font-weight: 600;
    color: #333;
    line-height: 1.35;
    margin-bottom: 10px;
}

.form-success p {
    font-size: 1em;
    color: #666;
    line-height: 1.6;
}


@media (max-width: 768px) {
    .contact-container {
        padding: 40px 15px;
    }
    
    .contact-header {
        padding: 40px 25px;
    }
    
    .contact-header h1 {
        font-size: 2em;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .contact-form-card {
        padding: 30px 25px;
    }
    
    .gh-info-top {
        padding: 30px 25px;
    }
    
    .gh-social-card {
        padding: 20px 25px;
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>
@endpush

@section('content')

<div class="contact-container">
    <div class="contact-grid">
        <div class="contact-form-card">
            <h3>Send a Message</h3>
            <p class="card-sub">We read every message and reply personally.</p>

            <div id="form-wrap">
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    @if(session('success'))
                        <div class="alert alert-success">
                            Your message has been sent successfully! We'll get back to you soon.
                        </div>
                    @endif
                    
                    <label class="form-label-gh">First Name</label>
                    <input class="form-control-gh" type="text" name="first_name"
                           placeholder="Your first name" required>

                    <label class="form-label-gh">Last Name</label>
                    <input class="form-control-gh" type="text" name="last_name"
                           placeholder="Your last name" required>

                    <label class="form-label-gh">Email Address</label>
                    <input class="form-control-gh" type="email" name="email"
                           placeholder="you@example.com" required>

                    <label class="form-label-gh">Subject</label>
                    <input class="form-control-gh" type="text" name="subject"
                           placeholder="How can we help?" required>

                    <label class="form-label-gh">Message</label>
                    <textarea class="form-control-gh" name="message"
                              rows="5" placeholder="Tell us anything..." required></textarea>

                    <button type="submit" class="btn-gh-send">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <div class="contact-info-section">
            <div class="gh-info-top">
                <h3>Get in Touch</h3>
                <div class="gh-contact-item">
                    <div class="gh-ci-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="gh-ci-label">Location</div>
                        <p class="gh-ci-val">123 Gift Street, Celebration City<br>New York, NY 10012</p>
                    </div>
                </div>
                <div class="gh-contact-item">
                    <div class="gh-ci-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="gh-ci-label">Email</div>
                        <p class="gh-ci-val">support@giftshub.com</p>
                    </div>
                </div>
                <div class="gh-contact-item">
                    <div class="gh-ci-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="gh-ci-label">Phone</div>
                        <p class="gh-ci-val">+1 (555) 123-4567</p>
                    </div>
                </div>
            </div>

            <div class="gh-social-card">
                <div class="social-label">Follow Us</div>
                <div class="social-icons">
                    <a href="#" class="social-icon-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon-btn" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon-btn" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
