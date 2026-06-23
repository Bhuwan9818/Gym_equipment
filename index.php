<?php
require_once __DIR__ . '/includes/functions.php';
$page_title = SITE_NAME . ' — Premium Gym Equipment, Strength Machines & More';
$meta_description = 'Commercial-grade indoor and outdoor gym equipment for home gyms, fitness studios, corporates and hotels. Free design, expert installation, pan-India delivery.';
$categories = get_categories();
$featured = get_featured_products(9);
include __DIR__ . '/includes/header.php';
?>

<!-- ══ HERO CAROUSEL ══ -->
<section class="hero" id="home" aria-label="Hero carousel" data-slide-dur="5500">
  <div class="hero-progress" aria-hidden="true"><div class="hero-progress-bar" id="heroProgressBar"></div></div>

  <div class="hero-slide active" aria-hidden="false">
    <div class="hero-slide-imgwrap"><img src="<?php echo asset('assets/images/site/gym_setup.jpg'); ?>" alt="Premium home gym setup" loading="eager" decoding="async"></div>
    <div class="hero-slide-ov"></div>
    <div class="slide-text">
      <div class="hero-tag">Premium Gym Equipment · India</div>
      <h1 class="hero-h1">
        <div class="ln"><span>BUILD YOUR</span></div>
        <div class="ln"><span>ULTIMATE <span class="g">GYM</span></span></div>
        <div class="ln"><span>AT HOME</span></div>
      </h1>
      <p class="hero-sub">Commercial-grade fitness equipment delivered to your door. Transform any space into a world-class training sanctuary.</p>
      <div class="hero-btns">
        <a href="#contact" class="btn-p">Get Free Quote →</a>
        <a href="#products" class="btn-s">Explore Equipment ↓</a>
      </div>
    </div>
  </div>

  <div class="hero-slide" aria-hidden="true">
    <div class="hero-slide-imgwrap"><img src="<?php echo asset('assets/images/site/banner1.webp'); ?>" alt="Complete gym setup" loading="lazy" decoding="async"></div>
    <div class="hero-slide-ov"></div>
    <div class="slide-text">
      <div class="hero-tag">Strength &amp; Performance</div>
      <h1 class="hero-h1">
        <div class="ln"><span>MAXIMUM</span></div>
        <div class="ln"><span>PERFORMANCE</span></div>
        <div class="ln"><span>IN <span class="g">MINIMAL</span> SPACE</span></div>
      </h1>
      <p class="hero-sub">Delivering over 50 exercises in a single setup. Full-body tone, definition, and power — all within your home.</p>
      <div class="hero-btns">
        <a href="#categories" class="btn-p">Shop by Category →</a>
        <a href="#about" class="btn-s">Our Story ↓</a>
      </div>
    </div>
  </div>

  <div class="hero-slide" aria-hidden="true">
    <div class="hero-slide-imgwrap"><img src="<?php echo asset('assets/images/site/banner2.png'); ?>" alt="Professional gym equipment" loading="lazy" decoding="async"></div>
    <div class="hero-slide-ov"></div>
    <div class="slide-text">
      <div class="hero-tag">Commercial Grade · 5-Year Warranty</div>
      <h1 class="hero-h1">
        <div class="ln"><span>ENGINEERED</span></div>
        <div class="ln"><span>FOR <span class="g">PEAK</span></span></div>
        <div class="ln"><span>PERFORMANCE</span></div>
      </h1>
      <p class="hero-sub">Every machine curated for engineering excellence. Built to perform. Designed to last.</p>
      <div class="hero-btns">
        <a href="#products" class="btn-p">View All Products →</a>
        <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="btn-s">📞 Call Us Now</a>
      </div>
    </div>
  </div>

  <div class="hero-slide" aria-hidden="true">
    <div class="hero-slide-imgwrap"><img src="<?php echo asset('assets/images/site/banner3.png'); ?>" alt="Luxury home gym" loading="lazy" decoding="async"></div>
    <div class="hero-slide-ov"></div>
    <div class="slide-text">
      <div class="hero-tag">Free Design · Expert Installation</div>
      <h1 class="hero-h1">
        <div class="ln"><span>YOUR DREAM</span></div>
        <div class="ln"><span>GYM <span class="g">DESIGNED</span></span></div>
        <div class="ln"><span>FOR FREE</span></div>
      </h1>
      <p class="hero-sub">Our certified gym designers create a complete layout plan for your space at absolutely no charge. Zero obligation.</p>
      <div class="hero-btns">
        <a href="#contact" class="btn-p">Get Free Design →</a>
        <a href="#testimonials" class="btn-s">See Client Gyms ↓</a>
      </div>
    </div>
  </div>

  <button class="hero-arrow prev" id="heroPrev" aria-label="Previous slide">&#8592;</button>
  <button class="hero-arrow next" id="heroNext" aria-label="Next slide">&#8594;</button>

  <div class="hero-dots" role="tablist" aria-label="Slide indicators">
    <button class="hero-dot active" role="tab" aria-selected="true"  aria-label="Slide 1" data-idx="0"></button>
    <button class="hero-dot"        role="tab" aria-selected="false" aria-label="Slide 2" data-idx="1"></button>
    <button class="hero-dot"        role="tab" aria-selected="false" aria-label="Slide 3" data-idx="2"></button>
    <button class="hero-dot"        role="tab" aria-selected="false" aria-label="Slide 4" data-idx="3"></button>
  </div>

  <div class="hero-counter" aria-hidden="true"><span class="cur" id="heroCur">01</span><span>/</span><span>04</span></div>

  <div class="hero-stats">
    <div class="hstat"><strong><?php echo count(get_products()); ?>+</strong><span>Products</span></div>
    <div class="hstat"><strong>10K+</strong><span>Clients</span></div>
    <div class="hstat"><strong>15+</strong><span>Years Exp.</span></div>
    <div class="hstat"><strong>48hr</strong><span>Delivery</span></div>
  </div>

  <div class="scroll-pill" aria-hidden="true"><div class="scroll-line"></div><span>Scroll</span></div>
</section>

<!-- MARQUEE -->
<div class="mq-strip" aria-hidden="true">
  <div class="mq-track">
    <span>Strength Machines</span><span class="dot">✦</span><span>Multi-Gyms</span><span class="dot">✦</span><span>Functional Trainers</span><span class="dot">✦</span><span>Benches &amp; Racks</span><span class="dot">✦</span><span>Outdoor Fitness Stations</span><span class="dot">✦</span><span>Smith Machines</span><span class="dot">✦</span><span>Cable Crossovers</span><span class="dot">✦</span><span>Leg Press</span><span class="dot">✦</span>
    <span>Strength Machines</span><span class="dot">✦</span><span>Multi-Gyms</span><span class="dot">✦</span><span>Functional Trainers</span><span class="dot">✦</span><span>Benches &amp; Racks</span><span class="dot">✦</span><span>Outdoor Fitness Stations</span><span class="dot">✦</span><span>Smith Machines</span><span class="dot">✦</span><span>Cable Crossovers</span><span class="dot">✦</span><span>Leg Press</span><span class="dot">✦</span>
  </div>
</div>

<!-- ══ INTRO ══ -->
<div class="intro-wrap" id="about">
  <div class="intro-img reveal">
    <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=900&q=80&auto=format&fit=crop" alt="Gym interior design">
    <div class="intro-img-badge">✦ Est. 2008 · New Delhi</div>
  </div>
  <div class="intro-body reveal d1">
    <div class="eyebrow">Who We Are</div>
    <h2 class="sh2">ELEGANTLY<br>DESIGNED.<br><span class="g">FUELED BY</span><br>TECHNOLOGY.</h2>
    <p>We are India's leading premium gym equipment supplier, bringing commercial-grade fitness technology to home gyms, professional fitness centres, and corporate wellness spaces.</p>
    <p>Every machine in our collection is engineered with rectangular steel-tube frames, PU-cushioned pads and silicone-grip handles — built to perform, built to last.</p>
    <div class="intro-feats">
      <div class="ifeat"><div class="ifeat-dot"></div>Commercial Grade Quality</div>
      <div class="ifeat"><div class="ifeat-dot"></div>Frame Warranty</div>
      <div class="ifeat"><div class="ifeat-dot"></div>Expert Installation</div>
      <div class="ifeat"><div class="ifeat-dot"></div>Free Gym Design</div>
      <div class="ifeat"><div class="ifeat-dot"></div>Pan-India Delivery</div>
      <div class="ifeat"><div class="ifeat-dot"></div>EMI Available</div>
    </div>
    <a href="#contact" class="btn-p">Request a Consultation →</a>
  </div>
</div>

<!-- ══ PRODUCTS ══ -->
<section class="sec prod-sec" id="products">
  <div class="prod-head reveal">
    <div>
      <div class="eyebrow">Our Collection</div>
      <h2 class="sh2">PREMIUM<br>EQUIPMENT</h2>
    </div>
    <p>Hand-selected for engineering excellence and long-term reliability. We beat any quote — guaranteed.</p>
  </div>
  <div class="tab-row reveal">
    <button class="tab a" data-subcat="all">All</button>
    <?php foreach ($categories as $cat): ?>
      <button class="tab" data-subcat="<?php echo h($cat['id']); ?>"><?php echo h($cat['short_name'] ?? $cat['name']); ?></button>
    <?php endforeach; ?>
  </div>
  <div class="prod-grid" id="prodGrid">
    <?php foreach ($featured as $i => $p): ?>
      <a href="<?php echo url_for_product($p['slug']); ?>" class="pcard reveal d<?php echo ($i % 4) + 1; ?>" data-subcat="<?php echo h($p['category']); ?>">
        <div class="pcard-img">
          <img src="<?php echo asset($p['image']); ?>" alt="<?php echo h($p['name']); ?>" loading="lazy">
          <div class="pcard-over">
            <button class="enq-btn" type="button" onclick="event.preventDefault();event.stopPropagation();enquire('<?php echo h(addslashes($p['name'])); ?>','<?php echo h($p['sku']); ?>')">Enquire Now</button>
          </div>
          <?php if (!empty($p['placeholder'])): ?><div class="pbadge">Sample</div><?php endif; ?>
        </div>
        <div class="pcard-body">
          <div class="ptag"><?php $pcat = get_category($p['category']); echo h($pcat ? ($pcat['short_name'] ?? $pcat['name'] ?? '') : ''); ?></div>
          <div class="pname"><?php echo h($p['name']); ?></div>
          <div class="pdesc"><?php echo h(mb_strimwidth($p['short_description'], 0, 90, '…')); ?></div>
          <div class="pprice">On Enquiry <small>/ Call for best price</small></div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
  <div style="text-align:center;margin-top:2.5rem">
    <a href="<?php echo url_for_category($categories[0]['id']); ?>" class="btn-ghost">View All Products →</a>
  </div>
</section>

<!-- ══ CATEGORIES — IMAGE GRID ══ -->
<div class="cat-sec" id="categories">
  <div class="eyebrow reveal" style="margin-bottom:.8rem">Shop by Category</div>
  <h2 class="sh2 reveal" style="margin-bottom:2rem">PRODUCTS <span class="g">BY CATEGORY</span></h2>
  <div class="cat-grid">
    <?php foreach ($categories as $i => $cat): ?>

      <?php
      $image = $cat['image'];

      if ($cat['id'] == 5) {
          $image = 'assets/images/special-category.jpg';
      }
      ?>

      <a href="<?php echo url_for_category($cat['id']); ?>"
        class="ccat reveal d<?php echo $i + 1; ?>">

        <img
            src="<?php echo asset($image); ?>"
            alt="<?php echo h($cat['name']); ?>"
            loading="lazy">

        <div class="ccat-ov"></div>
        <div class="ccat-arr">→</div>

        <div class="ccat-body">
              <span class="ccat-label">
                  <?php echo strtoupper(h($cat['name'])); ?>
              </span>

              <div class="ccat-tagline">
                  <?php echo h($cat['tagline']); ?>
              </div>
<!-- 
              <span class="ccat-count">
                  <?php echo product_count_label($cat['id']); ?> →
              </span> -->
            </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ══ FEATURE BANNER ══ -->
<div class="banner reveal">
  <img src="<?php echo asset('assets/images/site/banner1.webp'); ?>" alt="Shaping the future of health" loading="lazy">
  <div class="banner-ov"></div>
  <div class="banner-body">
    <div class="eyebrow">Our Philosophy</div>
    <h2>SHAPING THE<br>FUTURE OF <span style="color:var(--gold)">HEALTH</span></h2>
    <p>Our products are designed with your comfort and your goals in mind. Every detail engineered for people who take performance seriously.</p>
    <a href="#about" class="btn-p">Our Design Philosophy →</a>
  </div>
</div>

<!-- ══ LIFESTYLE 3-IMAGE GRID ══ -->
<section class="sec" style="padding-top:clamp(3rem,6vw,5rem);padding-bottom:0">
  <div class="eyebrow reveal">See It In Action</div>
  <h2 class="sh2 reveal" style="margin-bottom:2rem">REAL PEOPLE.<br><span class="g">REAL RESULTS.</span></h2>
</section>
<div class="life-grid reveal" style="margin-bottom:3px">
  <div class="lg-main">
    <img src="assets/images/site/gym2.webp" alt="Training lifestyle" loading="lazy">
    <div class="lg-badge">✦ Home Gym Setup</div>
    <div class="lg-label">Transform Your Space</div>
  </div>
  <div class="lg-sub">
    <img src="<?php echo asset('assets/images/site/treadmill.webp'); ?>" alt="Cardio training" loading="lazy">
    <div class="lg-label">Cardio Performance</div>
  </div>
  <div class="lg-sub">
    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80&auto=format&fit=crop" alt="Strength training" loading="lazy">
    <div class="lg-label">Strength &amp; Power</div>
  </div>
</div>

<!-- ══ AWARDS STRIP ══ -->
<section class="sec awards reveal">
  <div class="awards-inner">
    <div class="awards-left">
      <div class="eyebrow">Celebrating Quality</div>
      <div class="big">50+<br>AWARDED<br>PRODUCTS<br>SINCE 2004</div>
      <p>Carrying only the most internationally recognised and awarded fitness equipment brands in the world.</p>
    </div>
    <div class="awards-right">
      <div class="award-item reveal d1"><span class="award-num">14</span><span class="award-name">RedDot Awards</span></div>
      <div class="award-item reveal d2"><span class="award-num">18</span><span class="award-name">iF Design Awards</span></div>
      <div class="award-item reveal d3"><span class="award-num">7</span><span class="award-name">iF Awards</span></div>
      <div class="award-item reveal d4"><span class="award-num">11</span><span class="award-name">Good Design</span></div>
    </div>
  </div>
</section>

<!-- ══ VIDEO SECTION ══ -->
<div class="vid-sec">
  <img class="vid-fallback" src="<?php echo asset('assets/images/site/gym_setup.jpg'); ?>" alt="Premium gym" loading="lazy">
  <div class="vid-ov"></div>
  <div class="vid-body">
    <div class="eyebrow" style="justify-content:center;color:var(--gold)">Experience FITRONFITNESS</div>
    <h2>MAXIMUM<br>PERFORMANCE<br>IN MINIMAL <span style="color:var(--gold)">SPACE</span></h2>
    <p>Delivering over 50 exercises in a single piece of equipment. FITRONFITNESS offers full body tone and definition in just 1m².</p>
    <a href="#contact" class="btn-p">Explore Products →</a>
  </div>
</div>

<!-- ══ WHY US ══ -->
<section class="sec" style="padding-bottom:0">
  <div class="eyebrow reveal">Why Choose Us</div>
  <h2 class="sh2 reveal">THE FITRONFITNESS <span class="g">DIFFERENCE</span></h2>
  <div class="why-grid">
    <div class="wcard reveal">
      <div class="wcard-img"><img src="<?php echo asset('assets/images/site/legpress.webp'); ?>" alt="Direct manufacturing" loading="lazy"></div>
      <div class="wcard-body"><div class="wcard-num">01</div><h3>Direct from Manufacturer</h3><p>We source directly, eliminating middlemen and passing those savings straight to you — every time.</p></div>
    </div>
    <div class="wcard reveal d1">
      <div class="wcard-img"><img src="<?php echo asset('assets/images/site/home_gym.webp'); ?>" alt="Fast delivery" loading="lazy"></div>
      <div class="wcard-body"><div class="wcard-num">02</div><h3>48-Hour Delivery</h3><p>Express delivery across all major Indian metros, fully packaged and inspection-ready on arrival.</p></div>
    </div>
    <div class="wcard reveal d2">
      <div class="wcard-img"><img src="<?php echo asset('assets/images/site/outdoor_gym.webp'); ?>" alt="EMI financing" loading="lazy"></div>
      <div class="wcard-body"><div class="wcard-num">03</div><h3>Easy EMI Financing</h3><p>Flexible interest EMI options through leading banks. No-cost financing for qualified buyers.</p></div>
    </div>
    <div class="wcard reveal d3">
      <div class="wcard-img"><img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=600&q=75&auto=format&fit=crop" alt="Gym design service" loading="lazy"></div>
      <div class="wcard-body"><div class="wcard-num">04</div><h3>Free Gym Design</h3><p>Our certified gym designers create a complete layout plan for your space at absolutely no charge.</p></div>
    </div>
  </div>
</section>

<!-- ══ SECOND BANNER ══ -->
<div class="banner reveal" style="margin-top:3px">
  <img src="https://images.unsplash.com/photo-1593079831268-3381b0db4a77?w=1800&q=85&auto=format&fit=crop" alt="Corporate gym" loading="lazy">
  <div class="banner-ov"></div>
  <div class="banner-body">
    <div class="eyebrow">For Business</div>
    <h2>CORPORATE &amp;<br>HOTEL GYM<br><span style="color:var(--gold)">SOLUTIONS</span></h2>
    <p>Complete turnkey gym setups for corporates, hotels, resorts, and residential societies. One call, zero hassle.</p>
    <a href="#contact" class="btn-p">Get a Business Quote →</a>
  </div>
</div>

<!-- ══ TESTIMONIALS ══ -->
<section class="sec" id="testimonials">
  <div class="eyebrow reveal">Client Stories</div>
  <h2 class="sh2 reveal">WHAT OUR <span class="g">CLIENTS SAY</span></h2>
  <div class="testi-grid">
    <div class="tcard reveal">
      <div class="tcard-q">"</div>
      <div class="tcard-stars">★★★★★</div>
      <p class="tcard-text">The consultation was incredibly thorough. They designed my entire home gym, sourced the equipment, and had it installed within a week. Simply exceptional.</p>
      <div class="tcard-auth">
        <div class="tcard-av"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&q=80&auto=format&fit=crop&facepad=2&face=1" alt="Client"></div>
        <div><div class="tcard-name">Rahul Kapoor</div><div class="tcard-role">Home Gym Owner, Delhi</div></div>
      </div>
    </div>
    <div class="tcard reveal d1">
      <div class="tcard-q">"</div>
      <div class="tcard-stars">★★★★★</div>
      <p class="tcard-text">We outfitted our entire 4,000 sq ft corporate wellness centre through FITRONFITNESS. Equipment quality, delivery, and after-sales support have been impeccable.</p>
      <div class="tcard-auth">
        <div class="tcard-av"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80&auto=format&fit=crop&facepad=2&face=1" alt="Client"></div>
        <div><div class="tcard-name">Priya Mehta</div><div class="tcard-role">Director, HealthFirst Corporate</div></div>
      </div>
    </div>
    <div class="tcard reveal d2">
      <div class="tcard-q">"</div>
      <div class="tcard-stars">★★★★★</div>
      <p class="tcard-text">As a professional athlete, equipment quality is everything. FITRONFITNESS understood my specific needs and delivered a functional training setup that gave me a genuine competitive edge.</p>
      <div class="tcard-auth">
        <div class="tcard-av"><img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&q=80&auto=format&fit=crop&facepad=2&face=1" alt="Client"></div>
        <div><div class="tcard-name">Arjun Singh</div><div class="tcard-role">Professional Athlete, Delhi</div></div>
      </div>
    </div>
  </div>
</section>

<!-- ══ CONTACT / CTA SPLIT ══ -->
<div class="cta-wrap" id="contact">
  <div class="cta-left">
    <div class="eyebrow reveal">Get a Free Quote</div>
    <h2 class="sh2 reveal">LET'S BUILD<br>YOUR <span class="g">DREAM</span><br>GYM</h2>
    <p class="reveal">Speak with our equipment specialists. Zero pressure — 100% tailored advice for your space and budget.</p>
    <div class="cta-phone-row reveal">
      <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="cta-ph"><div class="cta-ph-ic">📞</div><?php echo h(SITE_PHONE_DISPLAY); ?></a>
      <div class="cta-or">— or drop your number —</div>
      <div class="form-r">
        <input type="tel" class="f-inp" placeholder="Your mobile number" id="phInp">
        <button class="f-sub" type="button" onclick="submitCb()">Call Me</button>
      </div>
    </div>
  </div>
  <div class="cta-right reveal d1">
    <img src="https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=900&q=80&auto=format&fit=crop" alt="Luxury home gym" loading="lazy">
    <div class="cta-right-ov"></div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
