<!-- BRANDS -->
<div class="brands-bar">
  <span class="brands-lbl">Trusted Brands</span>
  <div class="brands-row">
    <span class="brand">TECHNOGYM</span>
    <span class="brand">MATRIX</span>
    <span class="brand">LIFE FITNESS</span>
    <span class="brand">PRECOR</span>
    <span class="brand">CYBEX</span>
    <span class="brand">HAMMER</span>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="ft-top">
    <div class="ft-brand">
      <a href="<?php echo url_for_home(); ?>" class="logo" style="display:block;margin-bottom:.8rem">FITRON<em>FITNESS</em></a>
      <p>India's premier destination for commercial-grade gym equipment. Transforming spaces into world-class fitness sanctuaries since 2008.</p>
      <div class="ft-social">
        <a href="#" class="soc" aria-label="Instagram">▣</a>
        <a href="#" class="soc" aria-label="Facebook">f</a>
        <a href="#" class="soc" aria-label="YouTube">▶</a>
        <a href="#" class="soc" aria-label="LinkedIn">in</a>
      </div>
    </div>
    <div class="ft-col">
      <h4>Categories</h4>
      <ul>
        <?php foreach (get_categories() as $cat): ?>
          <li><a href="<?php echo url_for_category($cat['id']); ?>"><?php echo h($cat['name']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="ft-col">
      <h4>Services</h4>
      <ul>
        <li><a href="<?php echo url_for_home(); ?>#contact">Free Gym Design</a></li>
        <li><a href="<?php echo url_for_home(); ?>#contact">Equipment Leasing</a></li>
        <li><a href="<?php echo url_for_home(); ?>#contact">Installation</a></li>
        <li><a href="<?php echo url_for_home(); ?>#contact">Annual Maintenance</a></li>
        <li><a href="<?php echo url_for_home(); ?>#contact">Corporate Wellness</a></li>
      </ul>
    </div>
    <div class="ft-col">
      <h4>Contact</h4>
      <div class="ft-ci"><span class="ic">📞</span><span><?php echo h(SITE_PHONE_DISPLAY); ?><br><small>Mon–Sat · 9AM–7PM</small></span></div>
      <div class="ft-ci"><span class="ic">✉️</span><span><?php echo h(SITE_EMAIL); ?></span></div>
      <div class="ft-ci"><span class="ic">📍</span><span><?php echo h(SITE_ADDRESS); ?></span></div>
      <div class="ft-ci"><span class="ic">💬</span><span>WhatsApp: +<?php echo h(SITE_WHATSAPP); ?></span></div>
    </div>
  </div>
  <div class="ft-bot">
    <p>© <?php echo date('Y'); ?> FITRONFITNESS Premium Fitness Equipment. All rights reserved.</p>
    <div class="ft-legal">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Shipping Policy</a>
    </div>
  </div>
</footer>

<!-- FLOATING CTA -->
<div class="fcta">
  <a href="https://wa.me/<?php echo h(SITE_WHATSAPP); ?>" class="f-wa" aria-label="WhatsApp" target="_blank" rel="noopener">💬</a>
  <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="f-call">📞 Call for Quote</a>
</div>

<!-- ENQUIRY MODAL -->
<div class="modal-bg" id="modal">
  <div class="modal">
    <button class="modal-x" onclick="closeModal()" aria-label="Close">×</button>
    <div class="eyebrow" style="margin-bottom:.4rem">Get Best Price</div>
    <h3 id="modalName">Product Enquiry</h3>
    <p>Our specialist will contact you with the best price, EMI options, and delivery timeline.</p>
    <form id="enquiryForm" class="mfields" action="<?php echo url_for_enquire(); ?>" method="POST">
      <div class="form-msg"></div>
      <input type="hidden" name="type" value="enquiry">
      <input type="hidden" name="product" id="modalProductField" value="">
      <input type="hidden" name="sku" id="modalProductSku" value="">
      <input type="text" class="minp" name="name" placeholder="Your Name" required>
      <input type="tel" class="minp" name="phone" placeholder="Mobile Number" required pattern="[0-9+\-\s]{7,15}">
      <select class="msel" name="purpose">
        <option>Purpose: Home Gym</option>
        <option>Purpose: Commercial Gym</option>
        <option>Purpose: Corporate</option>
        <option>Purpose: Hotel / Resort</option>
      </select>
      <button type="submit" class="msub">Request Callback →</button>
    </form>
  </div>
</div>

<script src="<?php echo asset('assets/js/main.js'); ?>"></script>
</body>
</html>
