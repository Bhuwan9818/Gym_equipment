<?php
require_once __DIR__ . '/includes/functions.php';
$page_title = SITE_NAME . ' — Our Vision';
$meta_description = 'Discover the vision and mission behind FITRONFITNESS — building a healthier India with premium commercial-grade gym equipment.';
include __DIR__ . '/includes/header.php';
?>

<!-- ══ HERO — OUR VISION ══ -->
<section class="hero hero-sm" aria-label="Our Vision">
  <div class="hero-slide active">
    <div class="hero-slide-imgwrap">
      <img src="<?php echo asset('assets/images/site/full_gym.jpg'); ?>" alt="Our Vision" loading="eager" decoding="async">
    </div>
    <div class="hero-slide-ov" style="background:linear-gradient(110deg,rgba(0,0,0,.85) 0%,rgba(0,0,0,.4) 55%,transparent 100%),linear-gradient(to top,rgba(0,0,0,.7) 0%,transparent 50%)"></div>
    <div class="slide-text" style="display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding-bottom:clamp(3rem,7vh,5rem)">
      <div class="hero-tag">Who We Are · What We Stand For</div>
      <h1 class="hero-h1">
        <div class="ln"><span>OUR</span></div>
        <div class="ln"><span><span class="g">VISION</span></span></div>
      </h1>
      <p class="hero-sub">Building a healthier, stronger India — one gym at a time. We believe world-class fitness should be accessible to everyone.</p>
    </div>
  </div>
</section>

<!-- ══ VISION INTRO ══ -->
<section class="sec reveal" style="padding-top:clamp(4rem,8vw,7rem)">
  <div style="max-width:860px;margin:0 auto;text-align:center">
    <div class="eyebrow reveal">Our Purpose</div>
    <h2 class="sh2 reveal">THE FITRON<br><span class="g">FITNESS PROMISE</span></h2>
    <p class="reveal" style="color:var(--tx2);line-height:1.85;font-size:clamp(.9rem,1.2vw,1.08rem);margin-top:1.4rem">
      At FITRONFITNESS, we don't just sell equipment — we build ecosystems of health. Since our founding we have been driven by one belief: that every person, every institution, every community deserves access to training environments that inspire greatness. We source the world's most rigorously engineered gym equipment and bring it to homes, hotels, corporates, and fitness studios across India — backed by expert consultation, professional installation, and lifelong after-sales support.
    </p>
  </div>
</section>

<!-- ══ VISION / MISSION CARDS ══ -->
<section class="sec" style="padding-top:clamp(3rem,5vw,4.5rem)">
  <div class="vision-cards reveal">

    <div class="vision-card">
      <div class="vision-card-icon">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" width="38" height="38">
          <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2"/>
          <circle cx="24" cy="24" r="8" fill="currentColor" opacity=".25"/>
          <circle cx="24" cy="24" r="3" fill="currentColor"/>
          <line x1="24" y1="4" x2="24" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <line x1="24" y1="38" x2="24" y2="44" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <line x1="4" y1="24" x2="10" y2="24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <line x1="38" y1="24" x2="44" y2="24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </div>
      <h3>Our Vision</h3>
      <p>To be India's most trusted fitness infrastructure partner — empowering every individual, facility, and community with equipment and expertise that transforms physical spaces into sanctuaries of health, performance, and well-being.</p>
    </div>

    <div class="vision-card vision-card--accent">
      <div class="vision-card-icon">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" width="38" height="38">
          <path d="M8 36 L16 20 L24 28 L32 16 L40 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="40" cy="24" r="3" fill="currentColor"/>
        </svg>
      </div>
      <h3>Our Mission</h3>
      <p>To deliver commercial-grade fitness solutions across India with uncompromising quality, honest pricing, and world-class service — making professional-level training accessible to every home, school, hotel, and corporate facility in the country.</p>
    </div>

    <div class="vision-card">
      <div class="vision-card-icon">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" width="38" height="38">
          <path d="M24 6 L28.5 17H40L30.5 24L34 35L24 28L14 35L17.5 24L8 17H19.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        </svg>
      </div>
      <h3>Our Values</h3>
      <p>Integrity in every interaction. Excellence in every product. Commitment to every customer. We believe that building trust — not just building gyms — is what creates lasting relationships and healthier communities across India.</p>
    </div>

  </div>
</section>

<!-- ══ PILLARS / WHY US ══ -->
<div class="banner reveal" style="margin-top:clamp(2rem,4vw,4rem)">
  <img src="<?php echo asset('assets/images/site/complete_gym.webp'); ?>" alt="Complete gym setup" loading="lazy">
  <div class="banner-ov"></div>
  <div class="banner-body">
    <div class="eyebrow">Why FITRONFITNESS</div>
    <h2>ENGINEERED FOR<br><span style="color:var(--gold)">EXCELLENCE</span></h2>
    <p>Every piece of equipment we stock has been personally evaluated for build quality, ergonomic design, longevity, and true commercial-grade durability — because we believe you deserve only the best.</p>
    <a href="<?php echo url_for_home(); ?>#contact" class="btn-p">Get a Free Quote →</a>
  </div>
</div>

<!-- ══ STATS ══ -->
<section class="sec awards reveal" style="padding-top:clamp(4rem,7vw,6rem)">
  <div class="awards-inner">
    <div class="awards-left">
      <div class="eyebrow">By The Numbers</div>
      <div class="big">15+<br>YEARS OF<br>BUILDING<br>BETTER GYMS</div>
      <p>Serving home gyms, five-star hotels, corporate wellness centres, schools, and professional sports facilities across India.</p>
    </div>
    <div class="awards-right">
      <div class="award-item reveal d1"><span class="award-num">2000+</span><span class="award-name">Gyms Equipped</span></div>
      <div class="award-item reveal d2"><span class="award-num">50+</span><span class="award-name">Product Lines</span></div>
      <div class="award-item reveal d3"><span class="award-num">25+</span><span class="award-name">Cities Served</span></div>
      <div class="award-item reveal d4"><span class="award-num">98%</span><span class="award-name">Client Satisfaction</span></div>
    </div>
  </div>
</section>

<!-- ══ TEAM / STORY ══ -->
<section class="sec" style="padding:clamp(4rem,8vw,7rem) 5vw">
  <div style="max-width:920px;margin:0 auto">
    <div class="eyebrow reveal" style="justify-content:center;margin-bottom:.6rem">Our Story</div>
    <h2 class="sh2 reveal" style="text-align:center;margin-bottom:2.5rem">FROM A SINGLE<br><span class="g">SHOWROOM TO A NATION</span></h2>

    <div class="vision-story reveal">
      <div class="vision-story-text">
        <p>FITRONFITNESS was founded with a simple but powerful idea: that the gap between aspirational fitness and accessible fitness in India was too wide. We set out to bridge it.</p>
        <p style="margin-top:1rem">Starting from a single showroom in New Delhi, we built relationships with the world's leading gym equipment manufacturers and brought their best products to the Indian market — without compromising on quality or inflating prices.</p>
        <p style="margin-top:1rem">Today, our installations span five-star hotel chains, premium residential complexes, leading corporate parks, universities, and thousands of home gyms. But our founding belief hasn't changed: every person who wants to invest in their health deserves a partner they can trust completely.</p>
        <a href="<?php echo url_for_home(); ?>#contact" class="btn-p" style="margin-top:2rem;display:inline-flex">Start Your Gym Journey →</a>
      </div>
      <div class="vision-story-img">
        <img src="<?php echo asset('assets/images/site/gym3.webp'); ?>" alt="Our showroom" loading="lazy" style="border-radius:2px">
        <div class="vision-story-badge">Est. <?php echo date('Y') - 15; ?> · New Delhi</div>
      </div>
    </div>
  </div>
</section>

<!-- ══ CTA ══ -->
<section class="sec" style="text-align:center;padding-bottom:clamp(5rem,10vw,8rem)">
  <div class="eyebrow reveal" style="justify-content:center">Take the First Step</div>
  <h2 class="sh2 reveal" style="margin-bottom:1.4rem">READY TO BUILD<br><span class="g">YOUR GYM?</span></h2>
  <p class="reveal" style="color:var(--tx2);max-width:520px;margin:0 auto 2rem;line-height:1.8;font-size:.95rem">
    Our team of fitness consultants will design the perfect gym for your space and budget — completely free of charge.
  </p>
  <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap" class="reveal">
    <a href="<?php echo url_for_home(); ?>#contact" class="btn-p">Get Free Consultation →</a>
    <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="btn-s">📞 <?php echo h(SITE_PHONE_DISPLAY); ?></a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
